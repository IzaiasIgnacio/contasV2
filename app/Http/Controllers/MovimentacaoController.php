<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;

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
}
