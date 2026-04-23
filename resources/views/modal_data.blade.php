<div id="dateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-sm">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-white">Mês atual</h2>
            <button onclick="closeDateModal()" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <select id="monthSelect" class="flex-1 bg-transparent text-white text-sm focus:outline-none">
                    <option value="1" class="bg-gray-800" {{ $mes_atual_numero == 1 ? 'selected' : '' }}>Janeiro</option>
                    <option value="2" class="bg-gray-800" {{ $mes_atual_numero == 2 ? 'selected' : '' }}>Fevereiro</option>
                    <option value="3" class="bg-gray-800" {{ $mes_atual_numero == 3 ? 'selected' : '' }}>Março</option>
                    <option value="4" class="bg-gray-800" {{ $mes_atual_numero == 4 ? 'selected' : '' }}>Abril</option>
                    <option value="5" class="bg-gray-800" {{ $mes_atual_numero == 5 ? 'selected' : '' }}>Maio</option>
                    <option value="6" class="bg-gray-800" {{ $mes_atual_numero == 6 ? 'selected' : '' }}>Junho</option>
                    <option value="7" class="bg-gray-800" {{ $mes_atual_numero == 7 ? 'selected' : '' }}>Julho</option>
                    <option value="8" class="bg-gray-800" {{ $mes_atual_numero == 8 ? 'selected' : '' }}>Agosto</option>
                    <option value="9" class="bg-gray-800" {{ $mes_atual_numero == 9 ? 'selected' : '' }}>Setembro</option>
                    <option value="10" class="bg-gray-800" {{ $mes_atual_numero == 10 ? 'selected' : '' }}>Outubro</option>
                    <option value="11" class="bg-gray-800" {{ $mes_atual_numero == 11 ? 'selected' : '' }}>Novembro</option>
                    <option value="12" class="bg-gray-800" {{ $mes_atual_numero == 12 ? 'selected' : '' }}>Dezembro</option>
                </select>
            </div>

            <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                <input type="number" id="yearInput" value="{{ $ano_atual }}" min="2020" max="2030" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
            </div>

            <div class="pt-4">
                <button onclick="updateDate()" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">APLICAR</button>
            </div>
        </div>
    </div>
</div>