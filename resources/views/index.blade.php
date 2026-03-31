<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContasV2</title>
    <link rel="shortcut icon" href="{{URL::asset('public/favicon.ico')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Helvetica Neue"', 'Helvetica', 'Arial', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-gray-700 text-white min-h-screen flex font-sans">
    @include('navegacao', ['total' => $total, 'cartoes' => $cartoes])

    <!-- Conteúdo Principal -->
    <main class="flex-1 overflow-y-auto">
        <!-- Tabelas de Meses -->
        <section class="px-2 pt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-3">
                @foreach ($movimentacoes_mes as $mes)
                    <div class="bg-gray-900 rounded-lg border border-gray-700">
                        @include('mes', ['mes' => $mes])
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Tabelas de Terceiros -->
        <section class="px-2 pt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-3">
                @foreach ($movimentacoes_mes as $mes)
                    <div class="bg-gray-900 rounded-lg border border-gray-700">
                        @include('terceiros', ['mes' => $mes])
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Modal para Adicionar Transação -->
    <div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-white">Movimentação</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="movimentacaoForm" class="grid grid-cols-2 gap-4" method="POST">
                @csrf
                <input type="hidden" name="data" />
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select id="tipoSelect" name="tipo" onchange="toggleTerceiros()" class="flex-1 bg-gray-800 text-white text-sm focus:outline-none placeholder-gray-400">
                        <option value="gasto" class="bg-gray-800">Gasto</option>
                        <option value="renda" class="bg-gray-800">Renda</option>
                        <option value="terceiros" class="bg-gray-800">Terceiros</option>
                    </select>
                </div>
                <div>
                    <div id="terceirosField" class="hidden flex items-center gap-3 pb-2 border-b border-gray-600">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                        <select name="responsavel" class="flex-1 bg-gray-800 text-white text-sm focus:outline-none placeholder-gray-400">
                            <option value="" class="bg-gray-800">Selecione...</option>
                            @foreach ($terceiros as $nome => $rotulo)
                                <option value="{{$nome}}" class="bg-gray-800">{{$rotulo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="text" name="nome" placeholder="Nome" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <input type="text" name="descricao" placeholder="Descrição" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    <input type="number" name="valor" step="0.01" placeholder="Valor" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>

                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <select name="status" class="flex-1 bg-gray-800 text-white text-sm focus:outline-none placeholder-gray-400">
                        <option value="definido" class="bg-gray-800">Definido</option>
                        <option value="planejado" class="bg-gray-800">Planejado</option>
                        <option value="pago" class="bg-gray-800">Pago</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                    <select name="cartao" class="flex-1 bg-gray-800 text-white text-sm focus:outline-none placeholder-gray-400">
                        <option value="" class="bg-gray-800">Selecione...</option>
                        @foreach ($cartoes as $cartao)
                        <option value="{{$cartao->id}}" class="bg-gray-800">{{$cartao->rotulo}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <input type="number" name="parcelas" min="1" value="1" placeholder="Parcelas" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>

                <div class="col-span-2 pt-4">
                    <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">SALVAR</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Contas Bancárias -->
    <div id="bankModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-lg">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-white">Contas Bancárias</h2>
                <button onclick="closeBankModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                <!-- Banco do Brasil -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-black font-bold text-xs">BB</div>
                    <span class="text-white text-sm flex-1">Banco do Brasil</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>

                <!-- Itaú -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">IT</div>
                    <span class="text-white text-sm flex-1">Itaú</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>

                <!-- Bradesco -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">BR</div>
                    <span class="text-white text-sm flex-1">Bradesco</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>

                <!-- Santander -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">ST</div>
                    <span class="text-white text-sm flex-1">Santander</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>

                <!-- Nubank -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">NU</div>
                    <span class="text-white text-sm flex-1">Nubank</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>

                <!-- Inter -->
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">IN</div>
                    <span class="text-white text-sm flex-1">Inter</span>
                    <input type="number" step="0.01" placeholder="0,00" class="w-20 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400 text-right">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">SALVAR</button>
            </div>
        </div>
    </div>

    <!-- Modal Seleção de Data -->
    <div id="dateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-sm">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-white">Selecionar Período</h2>
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
                        <option value="1" class="bg-gray-800">Janeiro</option>
                        <option value="2" class="bg-gray-800">Fevereiro</option>
                        <option value="3" class="bg-gray-800">Março</option>
                        <option value="4" class="bg-gray-800">Abril</option>
                        <option value="5" class="bg-gray-800">Maio</option>
                        <option value="6" class="bg-gray-800">Junho</option>
                        <option value="7" class="bg-gray-800">Julho</option>
                        <option value="8" class="bg-gray-800">Agosto</option>
                        <option value="9" class="bg-gray-800">Setembro</option>
                        <option value="10" class="bg-gray-800">Outubro</option>
                        <option value="11" class="bg-gray-800">Novembro</option>
                        <option value="12" class="bg-gray-800">Dezembro</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <input type="number" id="yearInput" value="2024" min="2020" max="2030" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>

                <div class="pt-4">
                    <button onclick="updateDate()" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">APLICAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu de Contexto -->
    <div id="statusContextMenu" class="fixed hidden z-50 w-48 bg-black border border-gray-700 rounded-md shadow-lg py-1 text-sm text-gray-300">
        <ul>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
                </svg>
                Planejado
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 12.75 1.5 1.5 3-3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
                </svg>
                Definido
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-3">
                    <path fill-rule="evenodd" d="M2.25 6.75c0-1.036.84-1.875 1.875-1.875h15.75c1.036 0 1.875.84 1.875 1.875v10.5c0 1.036-.84 1.875-1.875 1.875H4.125c-1.036 0-1.875-.84-1.875-1.875V6.75Zm8.25 9.75a.75.75 0 0 0 1.06 0l4.5-4.5a.75.75 0 0 0-1.06-1.06L11.25 14.44l-2.47-2.47a.75.75 0 0 0-1.06 1.06l3 3Z" clip-rule="evenodd" />
                </svg>
                Pago
            </li>
            <li class="my-1">
                <hr class="border-gray-600">
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                </svg>
                Gasto
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
                Renda
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                </svg>
                Terceiros
            </li>
            <li class="my-1">
                <hr class="border-gray-600">
            </li>
            <li class="relative group">
                <div class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center justify-between">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3M3.75 21h16.5a1.5 1.5 0 001.5-1.5v-12a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5z" />
                        </svg>
                        Cartão
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
                <ul class="absolute left-full top-0 w-48 bg-gray-800 border border-gray-700 rounded-md shadow-lg py-1 text-sm text-gray-300 hidden group-hover:block">
                    @foreach ($cartoes as $cartao)
                    <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                        {{ $cartao->rotulo }}
                    </li>
                    @endforeach
                </ul>
            </li>
            <li class="my-1">
                <hr class="border-gray-600">
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.25-5.5h-1.5l.25 5.5h1.5zM12 16.5a.75.75 0 110-1.5.75.75 0 010 1.5zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Itaú
            </li>
            <li class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-3">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                </svg>
                Nubank
            </li>
            <li class="my-1">
                <hr class="border-gray-600">
            </li>
            <li class="px-3 py-1 hover:bg-red-500 hover:text-white cursor-pointer transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09.92-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Excluir
            </li>
        </ul>
    </div>

    <script src="{{ URL::asset('resources/js/contas.js') }}"></script>

</body>

</html>
