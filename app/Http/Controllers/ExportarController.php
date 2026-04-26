<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movimentacao;
use App\Models\Consolidado;
use App\Models\Rescisao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ExportarController extends Controller {
    
    public function gerarRelatorio() {
        // Meses: anterior, atual e próximos 2
        $hoje = Carbon::today()->startOfMonth();
        $periodos = [
            $hoje->copy(),
            $hoje->copy()->addMonth(),
            $hoje->copy()->addMonths(2),
            $hoje->copy()->addMonths(3),
            $hoje->copy()->addMonths(4),
            $hoje->copy()->addMonths(5),
            $hoje->copy()->addMonths(6)
        ];

        $totalInicial = Consolidado::where('totais', 1)->sum('valor');

        $resultado = [
            "total" => $totalInicial,
            "movimentacoes" => [],
            "mae" => [],
            "chah" => [],
        ];

        $saldoParcial = $totalInicial;

        foreach ($periodos as $i => $mes) {
            $inicio = $mes->copy()->startOfMonth();
            $fim = $mes->copy()->endOfMonth();

            // Busca os registros do mês
            $registros = Movimentacao::whereBetween('data', [$inicio, $fim])->orderBy('posicao')->get();

            $gastos = $registros->where('tipo', 'gasto')->where('status', '!=', 'pago')->sum('valor');
            $rendas = $registros->where('tipo', 'renda')->where('status', '!=', 'pago')->sum('valor');
            $novos = $registros->where('tipo', 'gasto')->where('novo', 1)->sum('valor');
            $renda_novos = $registros->where('tipo', 'renda')->where('novo', 1)->sum('valor');

            // Atualiza saldo parcial
            $saldoParcial = $saldoParcial - $gastos + $rendas;
            $registrosMes = $registros->where('tipo', '!=', 'terceiros');
            
            // Filtra registros que não são 'terceiros' nem do tipo 'save'
            $registrosFiltrados = $registros->where('tipo', '!=', 'terceiros')->where('nome', '!=', 'save');

            // Separa o salário dos demais registros
            $salario = $registrosFiltrados->where('nome', 'salario')->first(); // Opcional: pode ser null
            $outrosRegistros = $registrosFiltrados->where('nome', '!=', 'salario')
                                                    ->sortBy('tipo')
                                                    ->sortBy('posicao');

            $registrosMes = $salario ? $outrosRegistros->prepend($salario) : $outrosRegistros;
            
            $resultado["movimentacoes"][] = [
                "mes" => ucfirst($mes->locale('pt_BR')->translatedFormat('F')),
                "novo" => $novos - ($renda_novos - $salario->valor),
                "gastos" => $gastos,
                "rendas" => $rendas,
                "saldo_parcial" => $saldoParcial,
                "rescisao" => Rescisao::where('data', $inicio)->first()->subtotal +  + 9770 ?? 0,
                "registros" => $registrosMes->map(function ($m) {
                    return [
                        "nome" => $m->nome,
                        "valor" => $m->valor,
                        "status" => $m->status,
                        "tipo" => $m->tipo,
                    ];
                })->values()->toArray()
            ];

            if ($i > 1) {
                continue;
            }

            $pago = Consolidado::where('nome', 'pago')
                                ->whereMonth('data_atualizacao', $mes->month)
                                ->whereYear('data_atualizacao', $mes->year)
                                    ->first()->valor ?? 0;

            // Bloco mae
            $maeRegistros = $registros->where('tipo', 'terceiros')->where('responsavel', 'mae');
            $resultado["mae"][] = [
                "mes" => ucfirst($mes->locale('pt_BR')->translatedFormat('F')),
                "gastos" => $maeRegistros->sum('valor'),
                "izaias" => 1400,
                "pago" => ($i == 0) ? $pago : 0,
                "registros" => $maeRegistros->map(function ($m) {
                    return [
                        "nome" => $m->nome,
                        "valor" => $m->valor,
                    ];
                })->values()->toArray()
            ];

            // Bloco chah
            $chahRegistros = $registros->where('tipo', 'terceiros')->where('responsavel', 'chah');
            $resultado["chah"][] = [
                "mes" => ucfirst($mes->locale('pt_BR')->translatedFormat('F')),
                "gastos" => $chahRegistros->sum('valor'),
                "antigo" => Consolidado::where('nome', 'chah')->first()->valor,
                "registros" => $chahRegistros->map(function ($m) {
                    return [
                        "nome" => $m->nome,
                        "valor" => $m->valor,
                    ];
                })->values()->toArray()
            ];
        }

        return $resultado;
    }

    public function exportar() {
        $data = $this->gerarRelatorio();

        // Criar dump do banco de dados
        $dumpFile = 'db_contasV2.sql';
        $path = '/mnt/host/db/' . $dumpFile;
        
        // Verificar se mysqldump existe
        exec("which mysqldump 2>&1", $whichOutput, $whichReturn);
        if ($whichReturn !== 0) {
            $dumpSuccess = false;
            $dumpError = "mysqldump não encontrado: " . implode("\n", $whichOutput);
        } else {
            $command = "mysqldump -h " . env('DB_HOST') . " -u " . env('DB_USERNAME') . " --password=" . escapeshellarg(env('DB_PASSWORD')) . " --skip-ssl " . env('DB_DATABASE') . " 2>&1";
            exec($command, $output, $returnVar);
            if ($returnVar === 0) {
                $dumpContent = implode("\n", $output);
                $writeSuccess = file_put_contents($path, $dumpContent);
                if (!$writeSuccess) {
                    $dumpSuccess = false;
                    $dumpError = "Erro ao escrever o arquivo de dump";
                } else {
                    $dumpSuccess = true;
                }
            } else {
                $dumpSuccess = false;
                $dumpError = implode("\n", $output);
            }
        }

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Master-key' => env('JSONBIN_KEY'),
        ])->put('https://api.jsonbin.io/v3/b/'.env('JSONBIN_ID'), $data);
        
        $result = ['dump_success' => $dumpSuccess];
        if ($dumpSuccess) {
            $result['dump'] = $dumpFile;
        } else {
            $result['dump_error'] = $dumpError;
        }
        
        if ($response->successful()) {
            $result['success'] = true;
            return response()->json($result);
        } else {
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Erro desconhecido no JSONBin';
            $result['success'] = false;
            $result['error'] = $errorMessage;
            return response()->json($result, 500);
        }
    }
    
}