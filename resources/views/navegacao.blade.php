<!-- Barra Lateral Esquerda -->
<aside class="w-54 bg-black border-r border-gray-700 p-2 flex flex-col gap-4">
    <!-- Mês e Total -->
    <div class="flex flex-col items-start p-2 gap-4">
        <div class="flex items-center gap-3">
            <button onclick="openDateModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </button>
            <span class="text-xl text-white-400" id="currentDate">{{$mes_atual}} {{$ano_atual}}</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openBankModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
            </button>
            <p class="text-xl lg:text-2xl text-white-400">{{App\Models\Helper::format($total)}}</p>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex flex-col gap-3">
        <button class="w-full flex justify-center p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
            </svg>
        </button>
        <button class="w-full flex justify-center p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <!-- Cartões -->
    <div class="flex flex-col gap-2">
       @foreach ($cartoes as $cartao)
        <div class="bg-{{$cartao->cor}} rounded-lg p-2 text-white w-full border border-gray-600">
            <div class="flex justify-end mb-1">
                <span class="text-sm font-bold [text-shadow:0_1px_2px_rgba(0,0,0,1)]">{{$cartao->rotulo}}</span>
            </div>
            <p class="text-sm [text-shadow:0_1px_2px_rgba(0,0,0,1)]">5000 / 3200</p>
            <p class="text-sm [text-shadow:0_1px_2px_rgba(0,0,0,1)]">5230</p>
            <p class="text-sm [text-shadow:0_1px_2px_rgba(0,0,0,1)]">15/01 / 16/01</p>
        </div>
       @endforeach
    </div>
</aside>
