<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rescisao;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacao';
    public $timestamps = false;

    public function cartao() {
        return $this->hasOne(Cartao::class, 'id', 'id_cartao');
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /**
     * Versão em lote de mes(): recebe um array de instâncias Carbon (uma por mês)
     * e retorna o mesmo formato que mes() retornaria para cada uma, mas fazendo
     * apenas 2 consultas de leitura no total (movimentacoes + rescisoes) em vez
     * de 3 consultas por mês.
     *
     * As gravações (definirValoresFixosMes e rescisao) continuam sendo feitas
     * mês a mês, pois rescisao() depende do subtotal do mês anterior.
     */
    public function mesesEmLote(array $datas): array {
        // 1) Garante que os lançamentos fixos e a rescisão de cada mês existem.
        //    Isso precisa continuar em loop (é gravação, e rescisao() é sequencial
        //    por depender do mês anterior), mas não faz leitura de movimentações.
        foreach ($datas as $data) {
            $this->definirValoresFixosMes($data);
            $this->rescisao($data->copy());
        }

        // 2) Uma única leitura cobrindo todo o intervalo, em vez de 3 consultas por mês.
        $dataInicio = $datas[0]->copy()->startOfMonth()->format('Y-m-d');
        $dataFim = end($datas)->copy()->endOfMonth()->format('Y-m-d');

        $todasMovimentacoes = $this
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->get()
            ->groupBy(fn ($mov) => \Carbon\Carbon::parse($mov->data)->format('Y-m'));

        $todasRescisoes = Rescisao::whereBetween('data', [$dataInicio, $dataFim])
            ->get()
            ->keyBy(fn ($r) => \Carbon\Carbon::parse($r->data)->format('Y-m-d'));

        // 3) Monta o array de meses em PHP, sem nenhuma query adicional.
        $resultado = [];
        foreach ($datas as $i => $data) {
            $grupoMes = $todasMovimentacoes->get($data->format('Y-m'), collect());

            $salarioMovimentacao = $grupoMes->firstWhere('nome', 'salario');

            $movimentacoesMes = $grupoMes
                ->whereNotIn('tipo', ['save', 'terceiros'])
                ->where('nome', '!=', 'salario')
                ->each(function ($mov) {
                    $mov->ordem_parcela = ($mov->total_parcelas ?? 0) - ($mov->parcela ?? 0);
                })
                ->sortBy([
                    ['tipo', 'asc'],
                    ['fixo', 'desc'],
                    ['ordem_parcela', 'desc'],
                    ['status', 'asc'],
                    ['nome', 'asc']                    
                ])
                ->values();

            $terceirosMes = $grupoMes
                ->where('tipo', 'terceiros')
                ->sortBy([
                    ['responsavel', 'asc'],
                    ['nome', 'asc'],
                ])
                ->values();

            $rescisaoMes = $todasRescisoes->get($data->format('Y-m-d'));

            $mes = [
                'mes' => ucfirst($data->locale('pt-br')->monthName),
                'numero_mes' => $data->locale('pt-br')->month,
                'ano' => $data->locale('pt-br')->year,
                'movimentacoes' => $movimentacoesMes,
                'salario' => $salarioMovimentacao ? $salarioMovimentacao->valor : 0,
                'status_salario' => $salarioMovimentacao ? $salarioMovimentacao->status : 'definido',
                'salario_movimentacao' => $salarioMovimentacao,
                'rescisao' => $rescisaoMes ? ($rescisaoMes->subtotal - $rescisaoMes->retirada + 10286) : 10286,
            ];

            $mes['terceiros'] = $terceirosMes;

            $mes['total_terceiros'] = $terceirosMes
                ->groupBy('responsavel')
                ->mapWithKeys(function ($items, $responsavel) {
                    return [$responsavel => $items->sum('valor')];
                })
                ->toArray();

            if (isset($mes['total_terceiros']['mae'])) {
                $mes['total_terceiros']['mae'] -= 1400;
            }

            $mae_pago = Consolidado::where('nome', 'pago')->first();
            if (\Carbon\Carbon::parse($mae_pago->data_atualizacao)->format('m') == $data->format('m')) {
                $mes['total_terceiros']['mae'] -= $mae_pago->valor;
            }

            $resultado[$i] = $mes;
        }

        return $resultado;
    }

    private function definirValoresFixosMes($data) {
        $valores_fixos = [
            "salario" => [
                'valor' => Consolidado::where('nome', 'salario')->first()->valor,
                'descricao' => null
            ],
            "beneficios" => [
                'valor' => 2365,
                'descricao' => 'caju'
            ],
            "gas" => [
                'valor' => 250,
                'descricao' => null,
                'id_categoria' => 12
            ],
            "claro" => [
                'valor' => 93.9,
                'descricao' => 'fibra',
                'id_categoria' => 28
            ],
            "clarotv" => [
                'valor' => 54,
                'descricao' => 'prime, disney, apple, netflix, max',
                'id_categoria' => 21
            ],
            "prime" => [
                'valor' => 10,
                'descricao' => 'ad-free',
                'id_categoria' => 21
            ],
            'google' => [
                'valor' => 43.9,
                'descricao' => 'Youtube Premium',
                'id_categoria' => 21
            ],
            'meli' => [
                'valor' => 9.90,
                'descricao' => null,
                'id_categoria' => 21
            ],
            "m" => [
                'valor' => 1400,
                'descricao' => 'Mãe',
                'id_categoria' => 24
            ],
            'luz' => [
                'valor' => 350,
                'descricao' => null,
                'id_categoria' => 28
            ],
            'merc' => [
                'valor' => 1500,
                'descricao' => 'Mercado',
                'id_categoria' => 28
            ],
            'alm' => [
                'valor' => 615,
                'descricao' => null,
                'id_categoria' => 1
            ],
            'klini' => [
                'valor' => 302,
                'descricao' => 'Saúde',
                'id_categoria' => 22           ]
        ];

        $p = 1;
        foreach ($valores_fixos as $nome => $valores) {
            if ($this->whereRaw("data = '".$data->format('Y-m-d')."'")->where('nome', $nome)->whereIn('tipo', ['gasto', 'renda'])->count() == 0) {
                $mov = new Movimentacao();
                $mov->nome = $nome;
                $mov->descricao = $valores['descricao'];
                $mov->valor = $valores['valor'];
                $mov->tipo = in_array($nome, ['salario', 'beneficios']) ? 'renda' : 'gasto';
                $mov->data = $data->format('Y-m-d');
                $mov->status = 'definido';
                // $mov->posicao = ($nome != 'salario') ? 0 : $p;
                $mov->fixo = true;
                $mov->id_categoria = $valores['id_categoria'] ?? null;
                $mov->save();
                if ($nome != 'salario') {
                    $p++;
                }
            }
        }

        $valores_fixos = [
            'klini' => 302,
            'clarotv' => 84.9,
            'vivo' => 44.42,
            'youtube' => 10,
            'nubank' => null,
            'luz' => null
        ];

        $p = 1;
        foreach ($valores_fixos as $nome => $valor) {
            if ($this->whereRaw("data = '".$data->format('Y-m-d')."'")->where('nome', $nome)->where('tipo', 'terceiros')->count() == 0) {
                $mov = new Movimentacao();
                $mov->nome = $nome;
                $mov->valor = $valor;
                $mov->tipo = 'terceiros';
                $mov->data = $data->format('Y-m-d');
                $mov->status = 'definido';
                $mov->responsavel = 'mae';
                $mov->posicao = $p;
                $mov->save();
                $p++;
            }
        }

        $valores_fixos = [
            'google' => 4,
            'divida' => 100,
            'alelo' => -800,
            'aluguel' => -200
        ];

        $p = 1;
        foreach ($valores_fixos as $nome => $valor) {
            if ($this->whereRaw("data = '".$data->format('Y-m-d')."'")->where('nome', $nome)->where('tipo', 'terceiros')->count() == 0) {
                $mov = new Movimentacao();
                $mov->nome = $nome;
                $mov->valor = $valor;
                $mov->tipo = 'terceiros';
                $mov->data = $data->format('Y-m-d');
                $mov->status = 'definido';
                $mov->responsavel = 'chah';
                $mov->posicao = $p;
                $mov->save();
                $p++;
            }
        }
    }

    private function rescisao($data) {
        // Verifica se já existe um registro para a data fornecida.
        if (!Rescisao::where('data', $data->format('Y-m-d'))->exists()) {
            $valor = Consolidado::where('nome', 'rescisao')->first()->valor;

            // Busca o subtotal do mês anterior de forma segura, sem modificar $data.
            $dataMesAnterior = $data->copy()->subMonth()->format('Y-m-d');
            $subtotalAnterior = Rescisao::where('data', $dataMesAnterior)->first()->subtotal ?? 0;

            Rescisao::create([
                'data' => $data,
                'valor' => $valor,
                'retirada' => 0,
                'subtotal' => $subtotalAnterior + $valor,
            ]);
        }
    }

}
