<?php

namespace App\Http\Controllers;

use App\Models\Cartao;
use App\Models\Consolidado;
use App\Models\Movimentacao;
use App\Models\Terceiros;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request, Terceiros $terceiros) {
        if ($request->isMethod('post')) {
            $id_parcela = time();
            $data = Carbon::createFromFormat('d/m/Y', $request->data);
            $nome = $request->nome;
            
            for ($parcela=1;$parcela<=$request->parcelas;$parcela++) {
                $movimentacao = new Movimentacao();
                $nome = $request->nome;
                if ($request->parcelas > 1) {
                    $nome = $request->nome." ".$parcela."/".$request->parcelas;
                }
                
                if ($parcela > 1) {
                    $data = date_add($data, date_interval_create_from_date_string("1 month"));
                }

                $movimentacao->nome = $nome;
                $movimentacao->descricao = $request->descricao;
                $movimentacao->data = $data->format('Y-m-d');
                $movimentacao->tipo = $request->tipo;
                $movimentacao->valor = $request->valor;
                $movimentacao->status = $request->status;
                $movimentacao->responsavel = $request->responsavel;
                $movimentacao->id_cartao = !empty($request->cartao) ? $request->cartao : null;
                $movimentacao->total_parcelas = $request->parcelas;
                $movimentacao->parcela = $parcela;
                $movimentacao->id_parcela = $id_parcela;
                $movimentacao->save();
            }
            return redirect('/');
        }

        $movimentacao = new Movimentacao();
        $consolidado = new Consolidado();
        $cartao = new Cartao();
        $cartoes = $cartao->listaCartoesAtivos();
        $total = $consolidado->where('totais', 1)->sum('valor');
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', '01/'.$consolidado->where('nome', 'mes_atual')->first()->valor);
        $ano_atual = $data->year;
        $mes_atual = ucfirst($data->locale('pt-br')->monthName);

        for ($i=0;$i<=7;$i++) {
            $movimentacoes_mes[$i] = $movimentacao->mes($data);
            $data->addMonth();
        }

        return view('index', [
            'movimentacoes_mes' => $this->calculosExtrasMeses($total, $movimentacoes_mes),
            'terceiros' => $terceiros->listar(),
            'cartoes' => $cartoes,
            'total' => $total,
            'mes_atual' => $mes_atual,
            'ano_atual' => $ano_atual,
            'maximo_movimentacoes' => $this->getMaximoMovimentacoes($movimentacoes_mes),
            'maximo_terceiros' => $this->getMaximoTerceiros($movimentacoes_mes)
        ]);
    }

    private function calculosExtrasMeses($total, $movimentacoes_mes) {
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', '01/'.Consolidado::where('nome', 'mes_atual')->first()->valor);
        $cdb = 0;

        foreach ($movimentacoes_mes as $i =>$mes) {
            if ($i > 0) {
                $cdb = $total * 0.009;
                if ($i == 1) {
                    if ($data->format('m') == date('m')) {
                        $dias = 30 - date('d');
                        $cdb = ($cdb / 30) * $dias;
                    }
                }
            }
            $movimentacoes_mes[$i]['total_gastos'] = $mes['movimentacoes']->where('tipo', 'gasto')->where('status', '<>', 'pago')->sum('valor');
            $movimentacoes_mes[$i]['total_rendas'] = $mes['movimentacoes']->where('tipo', 'renda')->where('status', '<>', 'pago')->sum('valor') + $cdb;
            $movimentacoes_mes[$i]['sobra'] = $movimentacoes_mes[$i]['total_rendas'] - $movimentacoes_mes[$i]['total_gastos'];
            $movimentacoes_mes[$i]['sobra'] += ($mes['status_salario'] == 'definido') ? $mes['salario'] : 0;
            $movimentacoes_mes[$i]['total'] = $total + $movimentacoes_mes[$i]['sobra'];
            $movimentacoes_mes[$i]['cdb'] = $cdb;
            $total += $movimentacoes_mes[$i]['sobra'];
        }

        return $movimentacoes_mes;
    }

    private function getMaximoMovimentacoes(array $movimentacoes_mes): int {
        return array_reduce($movimentacoes_mes, function ($max, $mes) {
            return max($max, count($mes['movimentacoes']));
        }, 0);
    }

    private function getMaximoTerceiros(array $movimentacoes_mes): int {
        return array_reduce($movimentacoes_mes, function ($max, $mes) {
            return max($max, count($mes['terceiros']));
        }, 0);
    }
}
