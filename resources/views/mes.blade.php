<div class="flex justify-between items-center border-b border-gray-500 px-2 bg-red-950">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-bold">{{$mes['mes']}}</span>
    </div>
    @php $mesAbrev = strtolower(substr($mes['mes'], 0, 3)); @endphp
    <button onclick="openModal('{{ $mes['mes'] }}', '{{ $mes['ano'] }}')" class="bg-gray-300 hover:bg-gray-400 text-black rounded p-0.5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-3 h-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </button>
</div>
<div>
    <div data-movimentacao-id="{{ $mes['salario_movimentacao']->id ?? '' }}" data-movimentacao-type="renda" data-movimentacao-nome="salario" data-movimentacao-valor="{{ $mes['salario'] }}" data-movimentacao-descricao="{{ $mes['salario_movimentacao']->descricao ?? '' }}" data-movimentacao-categoria="{{ $mes['salario_movimentacao']->id_categoria ?? '' }}" class="flex justify-between items-center text-[15px] border-b border-gray-500 px-2 leading-snug linha_movimentacao
    @if($mes['status_salario'] == 'pago') bg-blue-600 @endif
    @if($mes['status_salario'] == 'definido') bg-blue-800 @endif
    ">
        <div class="flex items-center gap-1">
            <span class="text-gray-300 text-[15px] ">Salário</span>
        </div>
        <span class="text-gray-300 text-[15px] ">{{App\Models\Helper::format($mes['salario'])}}</span>
    </div>
    @foreach ($mes['movimentacoes'] as $movimentacao)
    <div data-movimentacao-id="{{ $movimentacao->id }}" data-movimentacao-type="{{ $movimentacao->tipo }}" data-movimentacao-nome="{{ $movimentacao->nome }}" data-movimentacao-valor="{{ $movimentacao->valor }}" data-movimentacao-descricao="{{ $movimentacao->descricao }}" data-movimentacao-categoria="{{ $movimentacao->id_categoria ?? '' }}" data-movimentacao-rotulo="{{ optional($movimentacao->cartao)->rotulo }}" class="flex justify-between items-center text-[15px] border-b border-gray-500 px-2 leading-snug linha_movimentacao
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status != 'pago' && $movimentacao->fixo == 0 && $movimentacao->valor > 150) bg-red-900 @endif
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status == 'pago') bg-green-900 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status == 'pago') bg-blue-600 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status == 'definido') bg-blue-800 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status == 'planejado') bg-purple-900 @endif
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status == 'planejado') bg-gray-600 @endif
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status == 'definido') bg-gray-900 @endif
    ">
        <div class="flex items-center gap-1">
            @php
                $grupoIcone = null;
                if (!empty($movimentacao->id_categoria)) {
                    $categoria = App\Models\Categoria::find($movimentacao->id_categoria);
                    if ($categoria && $categoria->grupo) {
                        $grupoIcone = $categoria->grupo->icone;
                    }
                }
            @endphp
            <span class="text-gray-300 text-[15px]">{{$movimentacao->nome}}</span>
            @if (!empty($movimentacao->cartao->cor))<div class="w-4 h-3 bg-{{$movimentacao->cartao->cor}} rounded text-xs border border-white/50 movimentacao-cartao-indicator" data-movimentacao-rotulo="{{ optional($movimentacao->cartao)->rotulo }}" onclick="event.stopPropagation(); showTooltip({{ json_encode(optional($movimentacao->cartao)->rotulo) }}, event.clientX, event.clientY)" onmouseleave="hideTooltip()"></div>@endif
            @if ($movimentacao->itau)
                <span class="inline-flex items-center justify-center w-4 h-4 bg-orange-500 text-white text-xs font-bold rounded">I</span>
            @endif
            @if ($movimentacao->nb)
                <span class="inline-flex items-center justify-center w-4 h-4 bg-purple-600 text-white text-xs font-bold rounded">N</span>
            @endif
            @if (!empty($grupoIcone))
                <span class="inline-flex items-center justify-center w-4 h-4 text-gray-300 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" viewBox="0 0 640 640">
                        <path fill="rgb(206, 205, 205)" d="{!! $grupoIcone !!}"/>
                    </svg>
                </span>
            @endif
        </div>
        <span class="text-gray-300 text-[15px] ">{{App\Models\Helper::format($movimentacao->valor)}}</span>
    </div>
    @endforeach
    @for ($i = count($mes['movimentacoes']); $i < $maximo_movimentacoes; $i++)
    <div class="flex justify-between items-center border-b border-gray-500 px-2 leading-snug">
        <span class="text-gray-300 text-[15px] ">&nbsp;</span>
    </div>
    @endfor
</div>

<div class="p-2"></div>

<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-red-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Gastos</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['total_gastos'])}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-red-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Novos</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['novos'])}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-red-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Encerrados</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['encerrados'])}}</span>
</div>
@isset($mes['cdb'])
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-green-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">cdb</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['cdb'])}}</span>
</div>
@endisset
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-green-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Renda</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format(($mes['status_salario'] <> 'pago' ? $mes['salario'] : 0) + $mes['total_rendas'])}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-blue-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Sobra</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['sobra'])}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-blue-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Total</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['total'])}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-blue-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-semibold">Rescisão</span>
    </div>
    <span class="text-gray-300 text-[15px] font-semibold">{{App\Models\Helper::format($mes['total'] + $mes['rescisao'])}}</span>
</div>
<div class="flex justify-between items-center border-b border-gray-500 px-2 bg-red-950">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-[15px] font-bold">{{$mes['mes']}}</span>
    </div>
</div>