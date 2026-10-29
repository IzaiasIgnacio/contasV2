<?php

namespace App\Http\Controllers;

use App\Models\Consolidado;
use App\Models\Movimentacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Atualiza toggles JÁ EXISTENTES no Notion (criados manualmente), em até
 * 3 páginas diferentes ("perfis"): Izaías, Mãe e Chah. Cada perfil tem sua
 * própria lista de toggles (posição 0 = mês atual, posição 1 = próximo mês,
 * etc, via env NOTION_TOGGLE_IDS_IZAIAS / NOTION_TOGGLE_IDS_MAE / NOTION_TOGGLE_IDS_CHAH)
 * e sua própria query de registros no banco.
 *
 * A página "Chah" também tem um bloco de texto no topo (NOTION_TOPO_ID_CHAH)
 * que é atualizado com o valor consolidado (Consolidado::get('chah')->valor).
 *
 * Pensado para ser chamado via AJAX (POST) a partir de um clique no front-end.
 *
 * Preparado para as limitações da API do Notion:
 *   - Máximo de 100 blocos por requisição: tabelas com mais de 100 linhas
 *     são criadas em lotes (primeiro lote na criação da tabela, o restante
 *     anexado em chamadas subsequentes de 100 em 100).
 *   - Rate limit (~3 req/s, em média): todas as chamadas passam por um
 *     helper único que aplica um pequeno intervalo entre requisições e
 *     faz retry automático com backoff quando recebe HTTP 429
 *     (respeitando o header Retry-After quando presente).
 */
class NotionController extends Controller
{
    /** Limite de blocos por requisição imposto pela API do Notion. */
    private const NOTION_MAX_BLOCKS_PER_REQUEST = 100;

    /** Intervalo mínimo (segundos) entre requisições, para respeitar o rate limit. */
    private const NOTION_MIN_INTERVAL_SECONDS = 0.35; // ~3 req/s

    /** Tentativas máximas em caso de 429 / erro transitório. */
    private const MAX_RETRIES = 5;

    private const MESES_PT = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
    ];

    private ?float $ultimaRequisicaoEm = null;

    /**
     * Endpoint chamado via AJAX (POST) para disparar a atualização de todos
     * os perfis/páginas configurados. Retorna um resumo em JSON do que foi
     * feito em cada perfil/mês/toggle (e no bloco de topo, quando houver).
     */
    public function exportar(): JsonResponse
    {
        $notionToken = env('NOTION_API_TOKEN');

        if (!$notionToken) {
            return response()->json([
                'success' => false,
                'message' => 'Configure NOTION_API_TOKEN no .env.',
            ], 500);
        }

        // Cada perfil representa uma página do Notion: sua própria lista de
        // toggles (env), sua própria query de registros no banco, e
        // opcionalmente um bloco de texto no topo (topo_id) para exibir um
        // valor consolidado.
        $perfis = [
            'izaias' => [
                'label'      => 'Izaias',
                'toggle_ids' => env('NOTION_TOGGLE_IDS_IZAIAS'),
                'topo_id'    => null,
                'query'      => fn (Carbon $referencia) => $this->buscarRegistrosIzaias($referencia),
            ],
            'mae' => [
                'label'      => 'Mãe',
                'toggle_ids' => env('NOTION_TOGGLE_IDS_MAE'),
                'topo_id'    => null,
                'query'      => fn (Carbon $referencia) => $this->buscarRegistrosMae($referencia),
            ],
            'chah' => [
                'label'      => 'Chah',
                'toggle_ids' => env('NOTION_TOGGLE_IDS_CHAH'),
                'topo_id'    => env('NOTION_TOPO_ID_CHAH'),
                'query'      => fn (Carbon $referencia) => $this->buscarRegistrosChah($referencia),
            ],
        ];

        $mesBase   = Carbon::now()->startOfMonth();
        $resultado = [];

        foreach ($perfis as $perfilChave => $perfil) {
            if (empty($perfil['toggle_ids'])) {
                Log::warning("Perfil '{$perfilChave}' sem NOTION_TOGGLE_IDS configurado, pulando.");
                continue;
            }

            $toggleIds = explode(',', $perfil['toggle_ids']);

            foreach (array_values($toggleIds) as $indice => $toggleId) {
                $toggleId = trim($toggleId);
                if ($toggleId === '') {
                    continue;
                }

                $referencia = $mesBase->copy()->addMonthsNoOverflow($indice);
                $nomeMes    = self::MESES_PT[$referencia->month];

                $this->atualizarTituloToggle($notionToken, $toggleId, $nomeMes);

                $registros = ($perfil['query'])($referencia);

                $resultadoRemocao = $this->removerBlocosAntigos($notionToken, $toggleId);

                $resultadoConteudo = $this->criarConteudoDoMes($notionToken, $toggleId, $registros);

                $ok = $resultadoRemocao['success'] && $resultadoConteudo['success'];

                $erro = null;
                if (!$resultadoRemocao['success']) {
                    $erro = 'Falha ao remover conteúdo antigo: ' . $resultadoRemocao['error'];
                } elseif (!$resultadoConteudo['success']) {
                    $erro = $resultadoConteudo['error'];
                }

                $resultado[] = [
                    'perfil'          => $perfilChave,
                    'perfil_label'    => $perfil['label'],
                    'bloco'           => 'toggle',
                    'toggle_id'       => $toggleId,
                    'mes'             => $nomeMes,
                    'ano'             => $referencia->year,
                    'total_registros' => $registros->count(),
                    'status'          => $ok ? 'ok' : 'erro',
                    'error'           => $erro,
                ];
            }

            // Bloco de texto no topo da página (valor consolidado), quando configurado.
            if (!empty($perfil['topo_id'])) {
                $resultadoTopo = $this->atualizarBlocoTopo($notionToken, trim($perfil['topo_id']));

                $resultado[] = [
                    'perfil'       => $perfilChave,
                    'perfil_label' => $perfil['label'],
                    'bloco'        => 'topo',
                    'toggle_id'    => trim($perfil['topo_id']),
                    'mes'          => null,
                    'ano'          => null,
                    'status'       => $resultadoTopo['success'] ? 'ok' : 'erro',
                    'error'        => $resultadoTopo['success'] ? null : $resultadoTopo['error'],
                ];
            }
        }

        if (empty($resultado)) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum perfil configurado. Defina NOTION_TOGGLE_IDS_IZAIAS, NOTION_TOGGLE_IDS_MAE e/ou NOTION_TOGGLE_IDS_CHAH no .env.',
            ], 500);
        }

        $houveErro = collect($resultado)->contains('status', 'erro');

        return response()->json([
            'success' => !$houveErro,
            'message' => $houveErro
                ? 'Concluído com um ou mais erros. Veja os detalhes por toggle.'
                : 'Todos os toggles foram atualizados com sucesso.',
            'toggles' => $resultado,
        ], $houveErro ? 207 : 200); // 207: sucesso parcial
    }

    // -------------------------------------------------------------------
    // Queries por perfil (uma página do Notion por perfil)
    // -------------------------------------------------------------------

    /**
     * Registros do perfil "Izaías" para o mês de referência.
     */
    private function buscarRegistrosIzaias(Carbon $referencia)
    {
        return Movimentacao::query()
            ->whereYear('data', $referencia->year)
            ->whereMonth('data', $referencia->month)
            ->where('tipo', '!=', 'terceiros')
                ->orderBy('tipo')
                ->orderByDesc('fixo')
                ->orderBy('nome')
                ->orderBy('status')
                    ->get(['nome', 'valor', 'descricao']);
    }

    /**
     * Registros do perfil "Mãe" para o mês de referência.
     */
    private function buscarRegistrosMae(Carbon $referencia)
    {
        return Movimentacao::query()
            ->whereYear('data', $referencia->year)
            ->whereMonth('data', $referencia->month)
            ->where('tipo', 'terceiros')
            ->where('responsavel', 'mae')
                ->orderBy('nome')
                    ->get(['nome', 'valor', 'descricao']);
    }

    /**
     * Registros do perfil "Chah" para o mês de referência.
     */
    private function buscarRegistrosChah(Carbon $referencia)
    {
        return Movimentacao::query()
            ->whereYear('data', $referencia->year)
            ->whereMonth('data', $referencia->month)
            ->where('tipo', 'terceiros')
            ->where('responsavel', 'chah')
                ->orderBy('nome')
                    ->get(['nome', 'valor', 'descricao']);
    }

    // -------------------------------------------------------------------
    // Bloco de texto no topo da página (valor consolidado)
    // -------------------------------------------------------------------

    /**
     * Atualiza o bloco de texto (paragraph) no topo da página do perfil com
     * o valor consolidado vindo de Consolidado::get($perfilChave)->valor.
     *
     * @return array{success: bool, error: string|null}
     */
    private function atualizarBlocoTopo(string $token, string $blockId): array
    {
        $consolidado = Consolidado::where('nome', 'chah')->first();

        if (!$consolidado) {
            return ['success' => false, 'error' => "Consolidado não retornou registro."];
        }

        $texto = $this->formatarValor((float) $consolidado->valor);

        $response = $this->notionRequest('PATCH', "https://api.notion.com/v1/blocks/{$blockId}", $token, [
            'paragraph' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => ['content' => 'Dívida: '.$texto],
                    ],
                ],
            ],
        ]);

        if (!$response) {
            return ['success' => false, 'error' => 'Falha de rede ao atualizar o bloco de topo (sem resposta do servidor).'];
        }

        if ($response->failed()) {
            return ['success' => false, 'error' => $this->extrairMensagemErroNotion($response)];
        }

        return ['success' => true, 'error' => null];
    }

    // -------------------------------------------------------------------
    // Criação do conteúdo do mês: tabela (dados)
    // -------------------------------------------------------------------

    /**
     * Cria, dentro do toggle: a tabela com os registros do mês (paginada em
     * lotes de até 100 linhas, se necessário)
     *
     * @return array{success: bool, error: string|null}
     */
    private function criarConteudoDoMes(string $token, string $toggleId, $registros): array
    {
        $linhas = $this->montarLinhasDeDados($registros);

        return $this->criarTabelaComLinhas($token, $toggleId, $linhas);
    }

    /**
     * Cria a tabela dentro do toggle. Se o total de linhas ultrapassar o
     * limite de blocos por requisição, cria a tabela com o primeiro lote
     * de linhas e anexa o restante em lotes subsequentes.
     *
     * @return array{success: bool, error: string|null}
     */
    private function criarTabelaComLinhas(string $token, string $toggleId, array $linhas): array
    {
        // Reserva 1 "slot" do lote para o próprio bloco de tabela na
        // primeira requisição (tabela + N linhas <= limite da API).
        $primeiroLoteTamanho = self::NOTION_MAX_BLOCKS_PER_REQUEST - 1;

        $primeiroLote = array_slice($linhas, 0, $primeiroLoteTamanho);
        $restante     = array_slice($linhas, $primeiroLoteTamanho);

        $tabelaBlock = [
            'object' => 'block',
            'type'   => 'table',
            'table'  => [
                'table_width'       => 3,
                'has_column_header' => false,
                'has_row_header'    => false,
                'children'          => $primeiroLote,
            ],
        ];

        $response = $this->notionRequest('PATCH', "https://api.notion.com/v1/blocks/{$toggleId}/children", $token, [
            'children' => [$tabelaBlock],
        ]);

        if (!$response) {
            return ['success' => false, 'error' => 'Falha de rede ao criar a tabela no Notion (sem resposta do servidor).'];
        }

        if ($response->failed()) {
            return ['success' => false, 'error' => $this->extrairMensagemErroNotion($response)];
        }

        $tabelaId = $response->json('results.0.id');

        if (!$tabelaId) {
            return ['success' => false, 'error' => 'A API do Notion não retornou o ID da tabela criada.'];
        }

        // Anexa as linhas restantes em lotes de até 100.
        foreach (array_chunk($restante, self::NOTION_MAX_BLOCKS_PER_REQUEST) as $lote) {
            $resp = $this->notionRequest('PATCH', "https://api.notion.com/v1/blocks/{$tabelaId}/children", $token, [
                'children' => $lote,
            ]);

            if (!$resp) {
                return ['success' => false, 'error' => 'Falha de rede ao anexar linhas na tabela do Notion (sem resposta do servidor).'];
            }

            if ($resp->failed()) {
                return ['success' => false, 'error' => $this->extrairMensagemErroNotion($resp)];
            }
        }

        return ['success' => true, 'error' => null];
    }

    /**
     * Extrai uma mensagem de erro legível a partir da resposta de erro da
     * API do Notion (que normalmente retorna JSON com "message" e "code").
     */
    private function extrairMensagemErroNotion($response): string
    {
        $status = $response->status();
        $corpo  = $response->json();

        $mensagemNotion = $corpo['message'] ?? $response->body();
        $codigoNotion   = $corpo['code'] ?? null;

        $mensagem = "HTTP {$status}";
        if ($codigoNotion) {
            $mensagem .= " [{$codigoNotion}]";
        }
        $mensagem .= ": {$mensagemNotion}";

        return $mensagem;
    }

    /**
     * Monta o array de blocos table_row a partir dos registros do mês,
     * incluindo uma linha de cabeçalho e uma linha de total (ambas em negrito).
     *
     * @return array $linhas
     */
    private function montarLinhasDeDados($registros): array
    {
        $linhas = [];
        $somaTotal = 0;

        $linhas[] = $this->montarLinhaTabela([
            ['texto' => 'Nome', 'bold' => true, 'color' => 'blue'],
            ['texto' => 'Valor', 'bold' => true, 'color' => 'blue'],
            ['texto' => 'Descrição', 'bold' => true, 'color' => 'blue'],
        ]);

        foreach ($registros as $registro) {
            $valor = (float) $registro->valor;
            $somaTotal += $valor;

            $linhas[] = $this->montarLinhaTabela([
                $registro->nome,
                $this->formatarValor($valor),
                $registro->descricao,
            ]);
        }

        if ($registros->isEmpty()) {
            $linhas[] = $this->montarLinhaTabela(['Sem registros', null, null]);
        }

        $linhas[] = $this->montarLinhaTabela([
            ['texto' => 'Total', 'bold' => true, 'color' => 'red'],
            ['texto' => $this->formatarValor($somaTotal), 'bold' => true, 'color' => 'red'],
            '',
        ]);

        return $linhas;
    }

    // -------------------------------------------------------------------
    // Título do toggle
    // -------------------------------------------------------------------

    private function atualizarTituloToggle(string $token, string $toggleId, string $novoTitulo): void
    {
        $this->notionRequest('PATCH', "https://api.notion.com/v1/blocks/{$toggleId}", $token, [
            'toggle' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => ['content' => $novoTitulo],
                    ],
                ],
            ],
        ]);
    }

    // -------------------------------------------------------------------
    // Remoção de blocos antigos (tabela), com paginação
    // -------------------------------------------------------------------

    /**
     * Lista os blocos filhos do toggle e arquiva a tabela de execuções
     * anteriores, para que seja recriada do zero.
     *
     * @return array{success: bool, error: string|null}
     */
    private function removerBlocosAntigos(string $token, string $toggleId): array
    {
        $cursor = null;

        do {
            $query = ['page_size' => 100];
            if ($cursor) {
                $query['start_cursor'] = $cursor;
            }

            $response = $this->notionRequest('GET', "https://api.notion.com/v1/blocks/{$toggleId}/children", $token, $query);

            if (!$response) {
                return ['success' => false, 'error' => 'Falha de rede ao listar blocos existentes no toggle (sem resposta do servidor).'];
            }

            if ($response->failed()) {
                return ['success' => false, 'error' => $this->extrairMensagemErroNotion($response)];
            }

            $data = $response->json();

            foreach ($data['results'] ?? [] as $block) {
                if (in_array($block['type'] ?? null, ['table'], true)) {
                    $arquivar = $this->notionRequest('PATCH', "https://api.notion.com/v1/blocks/{$block['id']}", $token, [
                        'archived' => true,
                    ]);

                    if (!$arquivar) {
                        return ['success' => false, 'error' => 'Falha de rede ao arquivar tabela antiga (sem resposta do servidor).'];
                    }

                    if ($arquivar->failed()) {
                        return ['success' => false, 'error' => $this->extrairMensagemErroNotion($arquivar)];
                    }
                }
            }

            $cursor = ($data['has_more'] ?? false) ? ($data['next_cursor'] ?? null) : null;
        } while ($cursor);

        return ['success' => true, 'error' => null];
    }

    // -------------------------------------------------------------------
    // Helpers de formatação
    // -------------------------------------------------------------------

    private function formatarValor(float $valor): string
    {
        return rtrim(rtrim(number_format($valor, 2, ',', ''), '0'), ',');
    }

    /**
     * Monta uma linha (table_row) do Notion. Cada célula pode ser:
     *  - uma string simples: "texto"
     *  - um array com formatação: ['texto' => '...', 'bold' => true, 'color' => 'red_background']
     *
     * rich_text.annotations
     *
     * Exemplo de uso:
     *   $this->montarLinhaTabela([
     *       'Nome normal',
     *       ['texto' => 'Nome em negrito', 'bold' => true],
     *   ]);
     */
    private function montarLinhaTabela(array $celulas): array
    {
        return [
            'object'    => 'block',
            'type'      => 'table_row',
            'table_row' => [
                'cells' => array_map(function ($celula) {
                    // Aceita string simples (sem formatação) ou array com opções.
                    if (is_string($celula)) {
                        $celula = ['texto' => $celula];
                    }

                    $richText = [
                        'type' => 'text',
                        'text' => ['content' => $celula['texto'] ?? ''],
                    ];

                    $annotations = array_filter([
                        'bold'          => $celula['bold'] ?? null,
                        'italic'        => $celula['italic'] ?? null,
                        'strikethrough' => $celula['strikethrough'] ?? null,
                        'underline'     => $celula['underline'] ?? null,
                        'code'          => $celula['code'] ?? null,
                        'color'         => $celula['color'] ?? null,
                    ], fn ($v) => $v !== null);

                    if (!empty($annotations)) {
                        $richText['annotations'] = $annotations;
                    }

                    return [$richText];
                }, $celulas),
            ],
        ];
    }

    // -------------------------------------------------------------------
    // Cliente HTTP com rate limiting + retry (429 / erros transitórios)
    // -------------------------------------------------------------------

    /**
     * Executa uma requisição contra a API do Notion, respeitando um
     * intervalo mínimo entre chamadas e refazendo automaticamente em
     * caso de HTTP 429 (rate limit) ou erros 5xx transitórios, com
     * backoff exponencial. Retorna null se todas as tentativas falharem
     * por erro de rede (exceção), ou a Response (mesmo que HTTP-failed)
     * caso o servidor tenha respondido.
     */
    private function notionRequest(string $method, string $url, string $token, array $payload = [])
    {
        for ($tentativa = 1; $tentativa <= self::MAX_RETRIES; $tentativa++) {
            $this->respeitarIntervaloMinimo();

            try {
                $request = Http::withToken($token)
                    ->withHeaders(['Notion-Version' => '2022-06-28'])
                    ->timeout(30);

                $metodo = strtoupper($method);

                if ($metodo === 'GET') {
                    $response = $request->get($url, $payload);
                } elseif ($metodo === 'PATCH') {
                    $response = $request->patch($url, $payload);
                } elseif ($metodo === 'POST') {
                    $response = $request->post($url, $payload);
                } else {
                    throw new \InvalidArgumentException("Método HTTP não suportado: {$method}");
                }
            } catch (\Throwable $e) {
                Log::warning('Erro de rede ao chamar API do Notion', [
                    'url'       => $url,
                    'tentativa' => $tentativa,
                    'erro'      => $e->getMessage(),
                ]);

                if ($tentativa === self::MAX_RETRIES) {
                    return null;
                }

                sleep(2 ** $tentativa); // backoff exponencial
                continue;
            }

            if ($response->status() === 429) {
                $retryAfter = (int) ($response->header('Retry-After') ?: (2 ** $tentativa));
                Log::info('Notion rate limit (429)', ['url' => $url, 'retry_after' => $retryAfter]);
                sleep($retryAfter);
                continue;
            }

            if ($response->serverError() && $tentativa < self::MAX_RETRIES) {
                Log::warning('Erro 5xx da API do Notion, tentando novamente', [
                    'url' => $url, 'status' => $response->status(), 'tentativa' => $tentativa,
                ]);
                sleep(2 ** $tentativa);
                continue;
            }

            if ($response->failed()) {
                Log::error('Requisição ao Notion falhou', [
                    'url'    => $url,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }

            return $response;
        }

        return null;
    }

    /**
     * Garante um intervalo mínimo entre requisições consecutivas para
     * não estourar o rate limit da API do Notion.
     */
    private function respeitarIntervaloMinimo(): void
    {
        if ($this->ultimaRequisicaoEm !== null) {
            $decorrido = microtime(true) - $this->ultimaRequisicaoEm;
            $faltante  = self::NOTION_MIN_INTERVAL_SECONDS - $decorrido;

            if ($faltante > 0) {
                usleep((int) ($faltante * 1_000_000));
            }
        }

        $this->ultimaRequisicaoEm = microtime(true);
    }
}
