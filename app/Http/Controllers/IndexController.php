<?php

namespace App\Http\Controllers;

use App\Models\Cartao;
use App\Models\Consolidado;
use App\Models\Helper;
use App\Models\Movimentacao;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $movimentacao = new Movimentacao();
        $consolidado = new Consolidado();
        $cartoes = Cartao::where('ativo', 1)->where('id', '<>', 4)->get();
        $total = $consolidado->where('totais', 1)->sum('valor');
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', '01/'.$consolidado->where('nome', 'mes_atual')->first()->valor);
        $ano_atual = $data->year;
        $mes_atual = ucfirst($data->locale('pt-br')->monthName);
        

        for ($i=0;$i<=7;$i++) {
            $movimentacoes_mes[$i] = $movimentacao->mes($data);
            $data->addMonth();
        }

        return view('index', [
            'movimentacoes_mes' => $movimentacoes_mes,
            'cartoes' => $cartoes,
            'total' => $total,
            'mes_atual' => $mes_atual,
            'ano_atual' => $ano_atual,
            'maximo_movimentacoes' => $this->getMaximoMovimentacoes($movimentacoes_mes)
        ]);
    }

    private function getMaximoMovimentacoes(array $movimentacoes_mes): int {
        return array_reduce($movimentacoes_mes, function ($max, $mes) {
            return max($max, count($mes['movimentacoes']));
        }, 0);
    }

    private function meses() {
        $consolidado = new Consolidado();
        $movimentacao = new Movimentacao();
        $helper = new Helper();
        $meses = [];

        date_default_timezone_set('America/Sao_Paulo');
        $total_atual = Consolidado::where('totais', 1)->sum('valor');
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', '01/'.$consolidado->where('nome', 'mes_atual')->first()->valor);

        for ($i=0;$i<=6;$i++) {
            $renda = $movimentacao->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('tipo', 'renda')->where('status', '<>', 'pago')->sum('valor');
            $gastos = $movimentacao->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('tipo', 'gasto')->where('status', '<>', 'pago')->sum('valor');
            $saldo = $total_atual - $gastos + $renda;
            $renda_cdb = $saldo * 0.009;

            if ($i == 0) {
                if ($data->format('m') == date('m')) {
                    $dias = 30 - date('d');
                    $renda_cdb = ($renda_cdb / 30) * $dias;
                }
            }

            $meses[$i] = [
                'saldo' => $helper->format($saldo),
                'renda' => $renda_cdb
            ];

            $total_atual = $saldo + $renda_cdb;
            $data->addMonth();
        }
        
        return $meses;
    }
}