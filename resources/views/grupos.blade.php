<div class="flex justify-between items-center border-b border-gray-500 px-2 bg-red-950">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-bold">{{ $mes['mes'] }}</span>
    </div>
</div>
@php
    $categoriasPorMes = [];
    foreach ($mes['movimentacoes'] as $movimentacao) {
        if ($movimentacao->tipo !== 'gasto' || empty($movimentacao->id_categoria)) {
            continue;
        }

        $categoria = App\Models\Categoria::find($movimentacao->id_categoria);
        if (!$categoria) {
            continue;
        }

        if (!isset($categoriasPorMes[$categoria->id])) {
            $categoriasPorMes[$categoria->id] = (object) [
                'nome' => $categoria->nome,
                'grupo_nome' => $categoria->grupo ? $categoria->grupo->nome : 'Sem Grupo',
                'total' => 0,
            ];
        }

        $categoriasPorMes[$categoria->id]->total += (float) $movimentacao->valor;
    }

    usort($categoriasPorMes, function ($a, $b) {
        if ($a->grupo_nome === $b->grupo_nome) {
            return strcmp($a->nome, $b->nome);
        }
        return strcmp($a->grupo_nome, $b->grupo_nome);
    });

    // Calcular total por grupo
    $totaisPorGrupo = [];
    foreach ($categoriasPorMes as $categoria) {
        if (!isset($totaisPorGrupo[$categoria->grupo_nome])) {
            $totaisPorGrupo[$categoria->grupo_nome] = 0;
        }
        $totaisPorGrupo[$categoria->grupo_nome] += $categoria->total;
    }
@endphp

@php
    $currentGrupo = null;
@endphp
@foreach ($categoriasPorMes as $categoriaResumo)
    @if ($currentGrupo !== $categoriaResumo->grupo_nome)
        <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-gray-700">
            <div class="flex items-center gap-1">
                <span class="text-gray-300 text-[15px] font-bold">{{ $categoriaResumo->grupo_nome }}</span>
            </div>
            <span class="text-gray-300 text-[15px] font-bold">{{ App\Models\Helper::format($totaisPorGrupo[$categoriaResumo->grupo_nome]) }}</span>
        </div>
        @php $currentGrupo = $categoriaResumo->grupo_nome; @endphp
    @endif
    <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-gray-900">
        <div class="flex items-center gap-1">
            <span class="text-gray-300 text-[15px] font-semibold">{{ $categoriaResumo->nome }}</span>
        </div>
        <span class="text-gray-300 text-[15px] font-semibold">{{ App\Models\Helper::format($categoriaResumo->total) }}</span>
    </div>
@endforeach
