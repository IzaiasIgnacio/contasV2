<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Navegação Superior -->
    <nav class="bg-gray-800 border-b border-gray-700 p-2">
        <div class="w-full flex flex-col lg:flex-row justify-between items-center px-4 gap-2">
            <div class="flex flex-col items-start gap-2">
                <div class="flex items-center gap-3">
                    <button onclick="openDateModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="text-xl text-white-400" id="currentDate">Janeiro 2024</span>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openBankModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <p class="text-xl lg:text-2xl font-bold text-green-400">15.847,32</p>
                </div>
            </div>
            
            <div class="flex gap-1 lg:gap-2 overflow-x-auto lg:overflow-visible w-full lg:w-auto justify-center">
                <!-- Cartão 1 -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">VISA</span>
                    </div>
                    <p class="text-xs opacity-90">5.000</p>
                    <p class="text-xs font-bold">3.200</p>
                    <p class="text-xs opacity-75">15/01</p>
                </div>

                <!-- Cartão 2 -->
                <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">MASTER</span>
                    </div>
                    <p class="text-xs opacity-90">8.000</p>
                    <p class="text-xs font-bold">6.500</p>
                    <p class="text-xs opacity-75">20/01</p>
                </div>

                <!-- Cartão 3 -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">ELO</span>
                    </div>
                    <p class="text-xs opacity-90">3.000</p>
                    <p class="text-xs font-bold">2.100</p>
                    <p class="text-xs opacity-75">10/01</p>
                </div>

                <!-- Cartão 4 -->
                <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">AMEX</span>
                    </div>
                    <p class="text-xs opacity-90">10.000</p>
                    <p class="text-xs font-bold">8.500</p>
                    <p class="text-xs opacity-75">25/01</p>
                </div>

                <!-- Cartão 5 -->
                <div class="bg-gradient-to-r from-orange-600 to-orange-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">HIPER</span>
                    </div>
                    <p class="text-xs opacity-90">2.000</p>
                    <p class="text-xs font-bold">1.800</p>
                    <p class="text-xs opacity-75">12/01</p>
                </div>

                <!-- Cartão 6 -->
                <div class="bg-gradient-to-r from-pink-600 to-pink-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">NUBANK</span>
                    </div>
                    <p class="text-xs opacity-90">6.000</p>
                    <p class="text-xs font-bold">4.200</p>
                    <p class="text-xs opacity-75">18/01</p>
                </div>

                <!-- Cartão 7 -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg p-1 lg:p-2 text-white w-20 lg:w-32 flex-shrink-0">
                    <div class="flex justify-end mb-1">
                        <span class="text-xs font-medium">INTER</span>
                    </div>
                    <p class="text-xs opacity-90">4.000</p>
                    <p class="text-xs font-bold">3.500</p>
                    <p class="text-xs opacity-75">22/01</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                    </svg>
                </button>
                <button class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Tabelas de Meses -->
    <section class="px-4 pt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-3">
            <!-- Janeiro 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Janeiro 2024</h3>
                        <button onclick="openModal('jan')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-green-600 bg-opacity-50 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-white">Mercado</span>
                            <div class="w-4 h-3 bg-blue-600 rounded text-xs"></div>
                        </div>
                        <span class="text-white">450</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-blue-600 bg-opacity-50 px-2">
                        <span class="text-white">Salário</span>
                        <span class="text-white">5.000</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 px-2">
                        <span class="text-white">Aluguel</span>
                        <span class="text-white">1.200</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-green-600 bg-opacity-50 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-white">Gasolina</span>
                            <div class="w-4 h-3 bg-red-600 rounded text-xs"></div>
                        </div>
                        <span class="text-white">180</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-green-600 bg-opacity-50 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-white">Farmácia</span>
                            <div class="w-4 h-3 bg-purple-600 rounded text-xs"></div>
                        </div>
                        <span class="text-white">85</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 bg-purple-800 bg-opacity-70 px-2">
                        <span class="text-white">Freelance</span>
                        <span class="text-white">800</span>
                    </div>
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
            </div>

            <!-- Fevereiro 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Fevereiro 2024</h3>
                        <button onclick="openModal('fev')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-blue-600 bg-opacity-50 px-2">
                        <span class="text-white">Salário</span>
                        <span class="text-white">5.000</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-gray-400 bg-opacity-50 px-2">
                        <span class="text-white">Internet</span>
                        <span class="text-white">120</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 bg-green-600 bg-opacity-50 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-white">Restaurante</span>
                            <div class="w-4 h-3 bg-pink-600 rounded text-xs"></div>
                        </div>
                        <span class="text-white">95</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 bg-gray-400 bg-opacity-50 px-2">
                        <span class="text-white">Academia</span>
                        <span class="text-white">80</span>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>295</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>5.000</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>4.705</span>
                    </div>
                </div>
            </div>

            <!-- Março 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Março 2024</h3>
                        <button onclick="openModal('mar')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Abril 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Abril 2024</h3>
                        <button onclick="openModal('abr')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Maio 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Maio 2024</h3>
                        <button onclick="openModal('mai')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Junho 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Junho 2024</h3>
                        <button onclick="openModal('jun')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Julho 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Julho 2024</h3>
                        <button onclick="openModal('jul')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-red-400">
                        <span>Gastos:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Rendas:</span>
                        <span>R$ 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabelas de Terceiros -->
    <section class="px-4 pt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-3">
            <!-- Janeiro 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Janeiro 2024</h3>
                        <button onclick="openModal('jan-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 px-2">
                        <span class="text-white">Mãe - Remédio</span>
                        <span class="text-white">120</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 px-2">
                        <span class="text-white">Irmão - Gasolina</span>
                        <span class="text-white">80</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 px-2">
                        <span class="text-white">Pai - Mercado</span>
                        <span class="text-white">200</span>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 400</span>
                    </div>
                </div>
            </div>

            <!-- Fevereiro 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Fevereiro 2024</h3>
                        <button onclick="openModal('fev-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-xs py-0.5 border-b border-gray-600 px-2">
                        <span class="text-white">Mãe - Consulta</span>
                        <span class="text-white">150</span>
                    </div>
                    <div class="flex justify-between items-center text-xs py-0.5 px-2">
                        <span class="text-white">Sogra - Compras</span>
                        <span class="text-white">90</span>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 240</span>
                    </div>
                </div>
            </div>

            <!-- Março 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Março 2024</h3>
                        <button onclick="openModal('mar-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Abril 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Abril 2024</h3>
                        <button onclick="openModal('abr-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Maio 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Maio 2024</h3>
                        <button onclick="openModal('mai-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Junho 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Junho 2024</h3>
                        <button onclick="openModal('jun-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>

            <!-- Julho 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-200">Julho 2024</h3>
                        <button onclick="openModal('jul-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs">+</button>
                    </div>
                </div>
                <div class="p-4 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-4 border-t border-gray-700 text-sm">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>R$ 0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal para Adicionar Transação -->
    <div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-white">Nova Transação</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form class="grid grid-cols-2 gap-4">
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select id="tipoSelect" onchange="toggleTerceiros()" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
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
                        <select class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                            <option value="" class="bg-gray-800">Selecione...</option>
                            <option value="joao" class="bg-gray-800">João</option>
                            <option value="maria" class="bg-gray-800">Maria</option>
                            <option value="empresa" class="bg-gray-800">Empresa XYZ</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="text" placeholder="Nome" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <input type="text" placeholder="Descrição" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                    <input type="number" step="0.01" placeholder="Valor" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <select class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                        <option value="definido" class="bg-gray-800">Definido</option>
                        <option value="planejado" class="bg-gray-800">Planejado</option>
                        <option value="pago" class="bg-gray-800">Pago</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    <select class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                        <option value="" class="bg-gray-800">Selecione...</option>
                        <option value="visa" class="bg-gray-800">VISA</option>
                        <option value="master" class="bg-gray-800">MASTER</option>
                        <option value="elo" class="bg-gray-800">ELO</option>
                        <option value="amex" class="bg-gray-800">AMEX</option>
                        <option value="hiper" class="bg-gray-800">HIPER</option>
                        <option value="nubank" class="bg-gray-800">NUBANK</option>
                        <option value="inter" class="bg-gray-800">INTER</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-3 pb-2 border-b border-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <input type="number" min="1" max="24" value="1" placeholder="Parcelas" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
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
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
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
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <input type="number" id="yearInput" value="2024" min="2020" max="2030" class="flex-1 bg-transparent text-white text-sm focus:outline-none placeholder-gray-400">
                </div>
                
                <div class="pt-4">
                    <button onclick="updateDate()" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">APLICAR</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(month) {
            document.getElementById('transactionModal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('transactionModal').classList.add('hidden');
        }
        
        function openBankModal() {
            document.getElementById('bankModal').classList.remove('hidden');
            document.getElementById('bankModal').classList.add('flex');
        }
        
        function closeBankModal() {
            document.getElementById('bankModal').classList.add('hidden');
            document.getElementById('bankModal').classList.remove('flex');
        }
        
        function toggleTerceiros() {
            const tipoSelect = document.getElementById('tipoSelect');
            const terceirosField = document.getElementById('terceirosField');
            
            if (tipoSelect.value === 'terceiros') {
                terceirosField.classList.remove('hidden');
            } else {
                terceirosField.classList.add('hidden');
            }
        }
        
        function openDateModal() {
            document.getElementById('dateModal').classList.remove('hidden');
        }
        
        function closeDateModal() {
            document.getElementById('dateModal').classList.add('hidden');
        }
        
        function updateDate() {
            const monthSelect = document.getElementById('monthSelect');
            const yearInput = document.getElementById('yearInput');
            const currentDateSpan = document.getElementById('currentDate');
            
            const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                          'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            
            const selectedMonth = months[monthSelect.value - 1];
            const selectedYear = yearInput.value;
            
            currentDateSpan.textContent = `${selectedMonth} ${selectedYear}`;
            closeDateModal();
        }
        
        // Fechar modais ao clicar fora
        document.getElementById('transactionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        document.getElementById('bankModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBankModal();
            }
        });
    </script>

</body>
</html>