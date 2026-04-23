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
        $mes_atual_numero = $data->month;

        for ($i=0;$i<=7;$i++) {
            $movimentacoes_mes[$i] = $movimentacao->mes($data);
            $data->addMonth();
        }

        // Calcular somas de nb e itau
        $total_nb = $movimentacao->where('nb', true)->sum('valor');
        $total_itau = $movimentacao->where('itau', true)->sum('valor');

        // Buscar valores atuais das contas
        $valor_contas = [
            'itau' => Consolidado::where('nome', 'itau')->first() ?? 0,
            'nubank' => Consolidado::where('nome', 'nubank')->first() ?? 0,
            'cofrinho' => Consolidado::where('nome', 'cofrinho')->first() ?? 0,
            'casa' => Consolidado::where('nome', 'casa')->first() ?? 0,
            'mercado_pago' => Consolidado::where('nome', 'mp')->first() ?? 0,
            'caixinha2' => Consolidado::where('nome', 'caixinha2')->first() ?? 0,
            'caixinha' => Consolidado::where('nome', 'caixinha')->first() ?? 0
        ];
        

        // Calcular diferenças (total movimentações - valor atual na conta)
        $diferenca_itau = $total_itau - $valor_contas['itau']->valor;
        $diferenca_nb = $total_nb - $valor_contas['nubank']->valor;

        return view('index', [
            'movimentacoes_mes' => $this->calculosExtrasMeses($total, $movimentacoes_mes),
            'terceiros' => $terceiros->listar(),
            'cartoes' => $cartoes,
            'total' => $total,
            'mes_atual' => $mes_atual,
            'ano_atual' => $ano_atual,
            'mes_atual_numero' => $mes_atual_numero,
            'total_nb' => $total_nb,
            'total_itau' => $total_itau,
            'diferenca_nb' => $diferenca_nb,
            'diferenca_itau' => $diferenca_itau,
            'valor_contas' => $valor_contas,
            'maximo_movimentacoes' => $this->getMaximoMovimentacoes($movimentacoes_mes),
            'maximo_terceiros' => $this->getMaximoTerceiros($movimentacoes_mes)
        ]);
    }

    public function updateMesAtual(Request $request)
    {
        $mes = str_pad($request->input('mes'), 2, '0', STR_PAD_LEFT);
        $ano = $request->input('ano');
        $valor = $mes . '/' . $ano;

        Consolidado::where('nome', 'mes_atual')->update(['valor' => $valor]);

        return response()->json(['success' => true]);
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

    public function deleteMovimentacao($id)
    {
        $movimentacao = Movimentacao::find($id);

        if (!$movimentacao) {
            return response()->json(['error' => 'Movimentação não encontrada'], 404);
        }

        // Se a movimentação tem parcelas, excluir todas as parcelas relacionadas
        if (!empty($movimentacao->id_parcela)) {
            Movimentacao::where('id_parcela', $movimentacao->id_parcela)->delete();
        } else {
            $movimentacao->delete();
        }

        return response()->json(['success' => true]);
    }

    public function salvarContas(Request $request)
    {
        $contas = $request->input('contas');

        if (is_array($contas)) {
            foreach ($contas as $nome => $valor) {
                $consolidado = Consolidado::where('nome', $nome)->first();
                if ($consolidado) {
                    $consolidado->valor = $valor;
                    $consolidado->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
