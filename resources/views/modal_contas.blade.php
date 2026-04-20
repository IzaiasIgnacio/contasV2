<div id="bankModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-lg">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-white">Contas</h2>
            <button onclick="closeBankModal()" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4 max-h-96 overflow-y-auto">
            <!-- Nubank -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">NU</div>
                <span class="text-white text-sm flex-1">Nubank ({{ $valor_contas['nubank']->data_atualizacao }})</span>
                <input value="{{$valor_contas['nubank']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Caixinha -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">CX</div>
                <span class="text-white text-sm flex-1">Caixinha ({{ $valor_contas['caixinha']->data_atualizacao }})</span>
                <input value="{{$valor_contas['caixinha']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Caixinha2 -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">C2</div>
                <span class="text-white text-sm flex-1">Caixinha2 ({{ $valor_contas['caixinha2']->data_atualizacao}})</span>
                <input value="{{$valor_contas['caixinha2']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Itaú -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">IT</div>
                <span class="text-white text-sm flex-1">Itaú ({{ $valor_contas['itau']->data_atualizacao }})</span>
                <input value="{{$valor_contas['itau']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Mercado Pago -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">MP</div>
                <span class="text-white text-sm flex-1">Mercado Pago ({{ $valor_contas['mercado_pago']->data_atualizacao }})</span>
                <input value="{{$valor_contas['mercado_pago']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Cofrinho -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">CF</div>
                <span class="text-white text-sm flex-1">Cofrinho ({{ $valor_contas['cofrinho']->data_atualizacao }})</span>
                <input value="{{$valor_contas['cofrinho']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>

            <!-- Casa -->
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">CS</div>
                <span class="text-white text-sm flex-1">Casa ({{ $valor_contas['casa']->data_atualizacao }})</span>
                <input value="{{$valor_contas['casa']->valor}}" type="text" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">SALVAR</button>
        </div>
    </div>
</div>
