<div class="p-2 border-b border-gray-700">
    <div class="flex justify-between items-center">
        <h3 class="text-base font-bold text-gray-200">{{$mes['mes']}}</h3>
        <button onclick="openModal('jan')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
    </div>
</div>
<div>
    <div class="flex justify-between items-center text-sm border-b border-gray-500 bg-opacity-50 px-2 bg-blue-600">
        <div class="flex items-center gap-1">
            <span class="text-gray-400 text-base font-semibold">Salário</span>
            <div class="w-4 h-3 bg-blue-600 rounded text-xs"></div>
        </div>
        <span class="text-gray-400 text-base font-semibold">{{$mes['salario']}}</span>
    </div>
    @foreach ($mes['movimentacoes'] as $movimentacao)
    <div class="flex justify-between items-center text-sm border-b border-gray-500 bg-opacity-50 px-2
    @if($movimentacao->tipo == 'gasto' && $movimentacao->status == 'pago') bg-green-800 @endif
    @if($movimentacao->tipo == 'renda' && $movimentacao->status == 'pago') bg-blue-700 @endif
    @if($movimentacao->tipo == 'renda') bg-blue-500 @endif
    @if($movimentacao->status == 'planejado') bg-gray-600 @endif
    ">
        <div class="flex items-center gap-1">
            <span class="text-gray-400 text-base font-semibold">{{$movimentacao->nome}}</span>
            <div class="w-4 h-3 bg-blue-600 rounded text-xs"></div>
        </div>
        <span class="text-gray-400 text-base font-semibold">{{$movimentacao->valor}}</span>
    </div>
    @endforeach
</div>
<div class="p-4 border-t border-gray-700 text-sm">
    <div class="flex justify-between text-red-400">
        <span>Gastos:</span>
        <span>1.915</span>
    </div>
    <div class="flex justify-between text-green-400">
        <span>Rendas:</span>
        <span>5.800</span>
    </div>
    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
        <span>Sobra:</span>
        <span>3.885</span>
    </div>
</div>