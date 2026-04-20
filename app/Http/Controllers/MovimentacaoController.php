<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notion;

class MovimentacaoController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $statuses = ['planejado', 'definido', 'pago'];

        if (!in_array($status, $statuses)) {
            return response()->json(['error' => 'Status inválido'], 422);
        }

        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        $movimentacao->status = $status;
        $movimentacao->save();

        return response()->json(['success' => true, 'status' => $status]);
    }

    public function updateCartao(Request $request, $id)
    {
        $cartaoId = $request->input('cartao_id');

        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        $movimentacao->id_cartao = $cartaoId;
        $movimentacao->save();

        return response()->json(['success' => true, 'cartao_id' => $cartaoId]);
    }

    public function updateItau(Request $request, $id)
    {
        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        $movimentacao->itau = !$movimentacao->itau;
        $movimentacao->nb = 0;
        $movimentacao->save();

        return response()->json(['success' => true, 'itau' => $movimentacao->itau, 'nb' => $movimentacao->nb]);
    }

    public function updateNb(Request $request, $id)
    {
        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        $movimentacao->nb = !$movimentacao->nb;
        $movimentacao->itau = 0;
        $movimentacao->save();

        return response()->json(['success' => true, 'nb' => $movimentacao->nb, 'itau' => $movimentacao->itau]);
    }

    public function deleteMovimentacao($id)
    {
        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        if (!empty($movimentacao->id_parcela)) {
            Movimentacao::where('id_parcela', $movimentacao->id_parcela)->delete();
        } else {
            $movimentacao->delete();
        }

        return response()->json(['success' => true]);
    }

    public function notion() {
        $pages = Notion::database(env('NOTION_DATABASE_ID'))->query()->asCollection();
        $gastos = $this->mapGastos($pages);

        foreach ($gastos as $gasto) {
            $this->criarMovimentacao($gasto);
        }

        return response()->json($gastos);
    }

    private function criarMovimentacao($gasto) {
        $id_parcela = time();
        $data = Carbon::now();
        $data = date_add($data, date_interval_create_from_date_string("1 month"));

        $mov = Movimentacao::where('nome', $gasto['nome'])
                            ->whereMonth('data', $data->format('m'))
                            ->whereYear('data', $data->format('Y'))
                                ->first();
        if ($mov) {
            $mov->valor += $gasto['valor'];
            $mov->save();
        }
        else {
            // Busca o ID do cartão a partir do nome obtido do Notion
            $cartaoId = null;
            if (!empty($gasto['cartao'])) {
                $cartao = \App\Models\Cartao::where('nome', $gasto['cartao'])->first();
                if ($cartao) {
                    $cartaoId = $cartao->id;
                }
            }

            for ($parcela=1;$parcela<=$gasto['parcelas'];$parcela++) {
                $movimentacao = new Movimentacao();
                $nome = $gasto['nome'];

                if ($gasto['parcelas'] > 1) {
                    $nome = $gasto['nome']." ".$parcela."/".$gasto['parcelas'];
                }

                if ($parcela > 1) {
                    $data = date_add($data, date_interval_create_from_date_string("1 month"));
                }

                $movimentacao->nome = $nome;
                $movimentacao->descricao = $gasto['desc'];
                $movimentacao->data = $data->format('Y-m-d');
                $movimentacao->tipo = 'gasto';
                $movimentacao->valor = $gasto['valor'];
                $movimentacao->status = 'definido';
                // $movimentacao->responsavel = $gasto['responsavel'];
                $movimentacao->id_cartao = $cartaoId;
                $movimentacao->total_parcelas = $gasto['parcelas'];
                $movimentacao->parcela = $parcela;
                $movimentacao->id_parcela = $id_parcela;
                $movimentacao->save();
            }
        }
        // Arquiva a página do Notion via requisição HTTP direta
        $this->arquivarPaginaNotion($gasto['id']);
    }

    private function arquivarPaginaNotion($pageId) {
        $token = env('NOTION_API_TOKEN');
        $url = "https://api.notion.com/v1/pages/{$pageId}";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Notion-Version: 2022-06-28',
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode(['archived' => true])
        ]);
        
        curl_exec($ch);
    }

    private function mapGastos($pages) {
        return $pages->map(function($gastoPage) {
            $nomeProp = $gastoPage->getProperty('Name');
            $descProp = $gastoPage->getProperty('desc');
            $valorProp = $gastoPage->getProperty('valor');
            $cartaoProp = $gastoPage->getProperty('cartao');
            $parcelasProp = $gastoPage->getProperty('parcelas');
            $pixProp = $gastoPage->getProperty('pix');
            $tipoProp = $gastoPage->getProperty('tipo');
            $responsavelProp = $gastoPage->getProperty('responsavel');

            return [
                'id' => $gastoPage->getId(),
                // Propriedades de Title e Rich Text usam getPlainText()
                'nome' => $nomeProp ? $nomeProp->getPlainText() : null,
                'desc' => $descProp ? $descProp->getPlainText() : null,

                // Propriedades de Number usam getNumber()
                'valor' => $valorProp ? $valorProp->getNumber() : null,
                'parcelas' => $parcelasProp ? $parcelasProp->getNumber() : 1,

                // Propriedades de Select podem usar getName() para obter o nome da opção
                'cartao' => $cartaoProp && $cartaoProp->getItem() ? $cartaoProp->getName() : null,

                // Propriedades de Checkbox usam isChecked()
                'pix' => $pixProp ? $pixProp->isChecked() : false,

                // 'tipo' => $tipoProp && $tipoProp->getItem() ? $tipoProp->getName() : 'gasto',
                // 'responsavel' => $responsavelProp && $responsavelProp->getItem() ? $responsavelProp->getName() : null,
            ];
        });
    }

}
