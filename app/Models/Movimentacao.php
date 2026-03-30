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

    public function mes($data) {
        $this->definirValoresFixosMes($data);
        $this->rescisao($data->copy());

        $mes = [
            'mes' => ucfirst($data->locale('pt-br')->monthName),
            'numero_mes' => $data->locale('pt-br')->month,
            'ano' => $data->locale('pt-br')->year,
            'movimentacoes' => $this
                                ->whereMonth('data', $data->format('m'))
                                ->whereYear('data', $data->format('Y'))
                                ->whereNotIn('tipo', ['save', 'terceiros'])
                                ->where('nome', '!=', 'salario')
                                    ->orderBy('tipo')
                                    ->orderByDesc('fixo')
                                    ->orderBy('status')
                                    ->orderByDesc(DB::raw('total_parcelas - parcela'))
                                    ->orderBy('nome')
                                        ->get(),
            'salario' => $this->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('nome', 'salario')->first()->valor,
            'status_salario' => $this->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('nome', 'salario')->first()->status,
            'novo' => $this->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('tipo', 'gasto')->where('novo', 1)->where('status', '<>', 'pago')->sum('valor')
            - $this->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('tipo', 'renda')->where('novo', 1)->where('nome', '!=', 'salario')->where('status', '<>', 'pago')->sum('valor'),
            'rescisao' => Rescisao::where('data', $data->format('Y-m-d'))->first()->subtotal - Rescisao::where('data', $data->format('Y-m-d'))->first()->retirada + 9770,
        ];
        
        $mes['terceiros'] = $this
                                ->whereMonth('data', $data->format('m'))
                                ->whereYear('data', $data->format('Y'))
                                ->where('tipo', 'terceiros')
                                    ->orderBy('tipo')
                                    ->orderBy('posicao')
                                        ->get();
        
        return $mes;
    }

    private function definirValoresFixosMes($data) {
        $valores_fixos = [
            "salario" => [
                'valor' => Consolidado::where('nome', 'salario')->first()->valor,
                'descricao' => null
            ],
            "gas" => [
                'valor' => 160,
                'descricao' => null
            ],
            "claro" => [
                'valor' => 79.9,
                'descricao' => null
            ],
            "netflix" => [
                'valor' => 59.9,
                'descricao' => null
            ],
            'google' => [
                'valor' => 33.29,
                'descricao' => 'Youtube Premium'
            ],
            'meli' => [
                'valor' => 9.90,
                'descricao' => null
            ],
            "m" => [
                'valor' => 1400,
                'descricao' => 'Mãe'
            ],
            'luz' => [
                'valor' => 350,
                'descricao' => null
            ],
            'merc' => [
                'valor' => 0,
                'descricao' => 'Mercado'
            ],
            'klini' => [
                'valor' => 302,
                'descricao' => 'Saúde'
            ]
        ];

        $p = 1;
        foreach ($valores_fixos as $nome => $valores) {
            if ($this->whereRaw("data = '".$data->format('Y-m-d')."'")->where('nome', $nome)->whereIn('tipo', ['gasto', 'renda'])->count() == 0) {
                $mov = new Movimentacao();
                $mov->nome = $nome;
                $mov->descricao = $valores['descricao'];
                $mov->valor = $valores['valor'];
                $mov->tipo = ($nome != 'salario') ? 'gasto' :  'renda';
                $mov->data = $data->format('Y-m-d');
                $mov->status = 'definido';
                $mov->posicao = ($nome != 'salario') ? 0 : $p;
                $mov->fixo = true;
                $mov->save();
                if ($nome != 'salario') {
                    $p++;
                }
            }
        }

        $valores_fixos = [
            'klini' => 302,
            'sky' => 84.9,
            'vivo' => 44.42,
            'globoplay' => 6.45,
            'youtube' => 8.6,
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
            'google' => 4
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