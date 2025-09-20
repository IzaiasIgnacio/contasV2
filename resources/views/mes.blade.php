<div class="p-2 border-b border-gray-700">
    <div class="flex justify-between items-center">
        <h3 class="text-base font-bold text-gray-200">{{$mes['mes']}}</h3>
        <button onclick="openModal('jan')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
    </div>
</div>
<div>
    <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-blue-800">
        <div class="flex items-center gap-1">
            <span class="text-gray-300 text-base font-semibold">Salário</span>
        </div>
        <span class="text-gray-300 text-base font-semibold">{{$mes['salario']}}</span>
    </div>
    @foreach ($mes['movimentacoes'] as $movimentacao)
    <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status == 'pago') bg-green-900 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status == 'pago') bg-blue-600 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status != 'pago') bg-blue-800 @endif
    @if($movimentacao->status == 'planejado') bg-gray-600 @endif
    ">
        <div class="flex items-center gap-1">
            <span class="text-gray-300 text-base font-semibold">{{$movimentacao->nome}}</span>
            @if (!empty($movimentacao->cartao->cor))<div class="w-4 h-3 bg-{{$movimentacao->cartao->cor}} rounded text-xs border border-white/20"></div>@endif
        </div>
        <span class="text-gray-300 text-base font-semibold">{{$movimentacao->valor}}</span>
    </div>
    @endforeach
    @for ($i = count($mes['movimentacoes']); $i < $maximo_movimentacoes; $i++)
    <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2">
        <span class="text-gray-300 text-base font-semibold">&nbsp;</span>
    </div>
    @endfor
</div>
<div class="p-2"></div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-red-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-base font-semibold">Gastos</span>
    </div>
    <span class="text-gray-300 text-base font-semibold">{{$mes['total_gastos']}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-green-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-base font-semibold">Renda</span>
    </div>
    <span class="text-gray-300 text-base font-semibold">{{$mes['total_rendas']}}</span>
</div>
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-blue-800">
    <div class="flex items-center gap-1">
        <span class="text-gray-300 text-base font-semibold">Sobra</span>
    </div>
    <span class="text-gray-300 text-base font-semibold">{{$mes['salario'] + $mes['total_rendas'] - $mes['total_gastos']}}</span>
</div>