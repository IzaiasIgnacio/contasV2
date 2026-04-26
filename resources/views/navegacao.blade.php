<!-- Barra Lateral Esquerda -->
<aside class="fixed top-0 left-0 h-screen w-48 md:w-54 bg-black border-r border-gray-700 p-2 flex flex-col gap-4 overflow-y-auto z-10">
    <div class="flex flex-col items-start p-2 gap-3">
        <!-- Mês atual -->
        <div class="flex items-center gap-3">
            <button onclick="openDateModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </button>
            <span class="text-xl text-white-400" id="currentDate">{{$mes_atual}} {{$ano_atual}}</span>
        </div>

        <!-- Total e modal contas -->
        <div class="flex items-center gap-3">
            <button onclick="openBankModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
            </button>
            <p class="text-xl lg:text-2xl text-white-400">{{App\Models\Helper::format($total)}}</p>
        </div>

        <!-- Totais por conta -->
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded">NU</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['nubank']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded">CX</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['caixinha']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded">C2</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['caixinha2']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded">IT</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['itau']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-xs font-bold rounded">MP</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['mercado_pago']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-xs font-bold rounded">CF</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['cofrinho']->valor)}}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-600 text-white text-xs font-bold rounded">CS</span>
            <p class="text-l text-white-400">{{App\Models\Helper::format($valor_contas['casa']->valor)}}</p>
        </div>
        
        <!-- Nubank e Itaú -->
        @if(($total_nb ?? 0) > 0 || ($total_itau ?? 0) > 0)
            <hr class="border-gray-600 w-full">
        @endif        
        @if(($total_nb ?? 0) > 0)
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded">N</span>
                <p class="text-sm text-white-400 whitespace-nowrap">{{App\Models\Helper::format($total_nb ?? 0)}} <span class="text-sm text-gray-400">({{$diferenca_nb}})</span></p>
            </div>
        @endif
        @if(($total_itau ?? 0) > 0)
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded">I</span>
                <p class="text-sm  text-white-400 whitespace-nowrap">{{App\Models\Helper::format($total_itau ?? 0)}} <span class="text-sm text-gray-400">({{$diferenca_itau}})</span></p>
            </div>
        @endif
    </div>

    <!-- Upload -->
    <div class="flex flex-col gap-1">
        <button id="btnExportar" onclick="exportarDados()" class="w-full flex justify-center items-center p-1 bg-gray-700 hover:bg-gray-600 rounded-lg disabled:opacity-50">
            <svg id="iconExportar" class="w-6 h-6 translate-y-[3px]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
            </svg>
            <svg id="spinnerExportar" class="w-6 h-6 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </div>
    
    <!-- Cartões -->
    <div class="flex flex-col gap-2">
       @foreach ($cartoes as $cartao)
        <div class="bg-{{$cartao->cor}} rounded-lg p-2 text-white w-full border border-gray-600">
            <div class="flex justify-end mb-1">
                <span class="text-[14px] font-bold [text-shadow:0_2px_4px_rgba(0,0,0,1)]">{{$cartao->rotulo}}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path></svg>
                <p class="text-[14px] [text-shadow:0_2px_4px_rgba(0,0,0,1)]">{{App\Models\Helper::format($cartao->limite_atual)}} | {{App\Models\Helper::format($cartao->credito)}}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-[14px] [text-shadow:0_2px_4px_rgba(0,0,0,1)]">{{App\Models\Helper::format($cartao->proxima_fatura)}} | {{App\Models\Helper::format($cartao->fatura_seguinte)}}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-[14px] [text-shadow:0_2px_4px_rgba(0,0,0,1)]">{{App\Models\Helper::format($cartao->vencimento)}} | {{App\Models\Helper::data_fechamento($cartao->vencimento, $cartao->dias_fechamento)}}</p>
            </div>
        </div>
       @endforeach
    </div>
</aside>
