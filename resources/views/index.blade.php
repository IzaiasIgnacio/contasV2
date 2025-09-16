<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas</title>
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
        <div class="w-full flex justify-between items-center px-4">
            <div class="flex items-center gap-3">
                <button onclick="openBankModal()" class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <p class="text-2xl font-bold text-400">15.847,32</p>
            </div>
            
            <div class="flex gap-2">
                <!-- Cartão 1 -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">VISA</span>
                    <p class="text-s opacity-90">5.000</p>
                    <p class="text-s font-bold">3.200</p>
                    <p class="text-s opacity-75">15/01</p>
                </div>

                <!-- Cartão 2 -->
                <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">MASTER</span>
                    <p class="text-s opacity-90">8.000</p>
                    <p class="text-s font-bold">6.500</p>
                    <p class="text-s opacity-75">20/01</p>
                </div>

                <!-- Cartão 3 -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">ELO</span>
                    <p class="text-s opacity-90">3.000</p>
                    <p class="text-s font-bold">2.100</p>
                    <p class="text-s opacity-75">10/01</p>
                </div>

                <!-- Cartão 4 -->
                <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">AMEX</span>
                    <p class="text-s opacity-90">10.000</p>
                    <p class="text-s font-bold">8.500</p>
                    <p class="text-s opacity-75">25/01</p>
                </div>

                <!-- Cartão 5 -->
                <div class="bg-gradient-to-r from-orange-600 to-orange-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">HIPER</span>
                    <p class="text-s opacity-90">2.000</p>
                    <p class="text-s font-bold">1.800</p>
                    <p class="text-s opacity-75">12/01</p>
                </div>

                <!-- Cartão 6 -->
                <div class="bg-gradient-to-r from-pink-600 to-pink-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">NUBANK</span>
                    <p class="text-s opacity-90">6.000</p>
                    <p class="text-s font-bold">4.200</p>
                    <p class="text-s opacity-75">18/01</p>
                </div>

                <!-- Cartão 7 -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg p-2 text-white w-48">
                    <span class="block text-right text-s font-medium">INTER</span>
                    <p class="text-s opacity-90">4.000</p>
                    <p class="text-s font-bold">3.500</p>
                    <p class="text-s opacity-75">22/01</p>
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
        <div class="grid grid-cols-7 gap-3">
            <!-- Janeiro 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Janeiro 2024</h3>
                        <button onclick="openModal('jan')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-400">Mercado</span>
                            <div class="w-4 h-3 bg-blue-600 rounded text-s"></div>
                        </div>
                        <span class="text-400">450</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-blue-900 bg-opacity-80 px-2">
                        <span class="text-400">Salário</span>
                        <span class="text-400">5.000</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <span class="text-400">Aluguel</span>
                        <span class="text-400">1.200</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-400">Gasolina</span>
                            <div class="w-4 h-3 bg-red-600 rounded text-s"></div>
                        </div>
                        <span class="text-400">180</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-400">Farmácia</span>
                            <div class="w-4 h-3 bg-purple-600 rounded text-s"></div>
                        </div>
                        <span class="text-400">85</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 bg-blue-900 bg-opacity-80 px-2">
                        <span class="text-400">Freelance</span>
                        <span class="text-400">800</span>
                    </div>
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>1.915</span>
                    </div>
                    <div class="flex justify-between text-400">
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
                        <h3 class="text-s font-medium text-gray-200">Fevereiro 2024</h3>
                        <button onclick="openModal('fev')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-blue-900 bg-opacity-80 px-2">
                        <span class="text-400">Salário</span>
                        <span class="text-400">5.000</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <span class="text-400">Internet</span>
                        <span class="text-400">120</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600 bg-red-900 bg-opacity-80 px-2">
                        <div class="flex items-center gap-2">
                            <span class="text-400">Restaurante</span>
                            <div class="w-4 h-3 bg-pink-600 rounded text-s"></div>
                        </div>
                        <span class="text-400">95</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 bg-red-900 bg-opacity-80 px-2">
                        <span class="text-400">Academia</span>
                        <span class="text-400">80</span>
                    </div>
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>295</span>
                    </div>
                    <div class="flex justify-between text-400">
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
                        <h3 class="text-s font-medium text-gray-200">Março 2024</h3>
                        <button onclick="openModal('mar')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between text-400">
                        <span>Rendas:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Abril 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Abril 2024</h3>
                        <button onclick="openModal('abr')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between text-400">
                        <span>Rendas:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Maio 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Maio 2024</h3>
                        <button onclick="openModal('mai')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between text-400">
                        <span>Rendas:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Junho 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Junho 2024</h3>
                        <button onclick="openModal('jun')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between text-400">
                        <span>Rendas:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Julho 2024 -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Julho 2024</h3>
                        <button onclick="openModal('jul')" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 space-y-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-400">
                        <span>Gastos:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between text-400">
                        <span>Rendas:</span>
                        <span>0</span>
                    </div>
                    <div class="flex justify-between font-bold text-blue-400 border-t border-gray-600 pt-1 mt-1">
                        <span>Sobra:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabelas de Terceiros -->
    <section class="px-4 pt-4">
        <h2 class="text-lg font-semibold mb-3 text-gray-200">Gastos de Terceiros</h2>
        <div class="grid grid-cols-7 gap-3">
            <!-- Janeiro 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Janeiro 2024</h3>
                        <button onclick="openModal('jan-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600">
                        <span class="text-purple-400">Mãe - Remédio</span>
                        <span class="text-purple-400">120</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600">
                        <span class="text-purple-400">Irmão - Gasolina</span>
                        <span class="text-purple-400">80</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5">
                        <span class="text-purple-400">Pai - Mercado</span>
                        <span class="text-purple-400">200</span>
                    </div>
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>400</span>
                    </div>
                </div>
            </div>

            <!-- Fevereiro 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Fevereiro 2024</h3>
                        <button onclick="openModal('fev-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <div class="flex justify-between items-center text-s py-0.5 border-b border-gray-600">
                        <span class="text-purple-400">Mãe - Consulta</span>
                        <span class="text-purple-400">150</span>
                    </div>
                    <div class="flex justify-between items-center text-s py-0.5">
                        <span class="text-purple-400">Sogra - Compras</span>
                        <span class="text-purple-400">90</span>
                    </div>
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>240</span>
                    </div>
                </div>
            </div>

            <!-- Março 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Março 2024</h3>
                        <button onclick="openModal('mar-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Abril 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Abril 2024</h3>
                        <button onclick="openModal('abr-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Maio 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Maio 2024</h3>
                        <button onclick="openModal('mai-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Junho 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Junho 2024</h3>
                        <button onclick="openModal('jun-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Julho 2024 - Terceiros -->
            <div class="bg-gray-800 rounded-lg border border-gray-700">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-s font-medium text-gray-200">Julho 2024</h3>
                        <button onclick="openModal('jul-t')" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-s">+</button>
                    </div>
                </div>
                <div class="p-2 h-64 overflow-y-auto">
                    <!-- Vazio -->
                </div>
                <div class="p-2 border-t border-gray-700 text-s">
                    <div class="flex justify-between text-purple-400">
                        <span>Total Terceiros:</span>
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Registro -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg p-6 w-full max-w-md mx-4 border border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-200">Adicionar Registro</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-s font-medium text-gray-300 mb-1">Descrição</label>
                    <input type="text" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex: Mercado, Salário...">
                </div>
                
                <div>
                    <label class="block text-s font-medium text-gray-300 mb-1">Valor</label>
                    <input type="number" step="0.01" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0,00">
                </div>
                
                <div>
                    <label class="block text-s font-medium text-gray-300 mb-1">Tipo</label>
                    <select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="gasto">Gasto</option>
                        <option value="renda">Renda</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-s font-medium text-gray-300 mb-1">Categoria</label>
                    <select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="alimentacao">Alimentação</option>
                        <option value="transporte">Transporte</option>
                        <option value="moradia">Moradia</option>
                        <option value="lazer">Lazer</option>
                        <option value="saude">Saúde</option>
                        <option value="trabalho">Trabalho</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md">Cancelar</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Contas Bancárias -->
    <div id="bankModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg p-6 w-full max-w-lg mx-4 border border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-200">Contas Bancárias</h3>
                <button onclick="closeBankModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-3 max-h-96 overflow-y-auto">
                <!-- Banco do Brasil -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-yellow-500 rounded flex items-center justify-center text-black font-bold text-s">BB</div>
                        <span class="text-white">Banco do Brasil</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>

                <!-- Itaú -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-500 rounded flex items-center justify-center text-white font-bold text-s">IT</div>
                        <span class="text-white">Itaú</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>

                <!-- Bradesco -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-600 rounded flex items-center justify-center text-white font-bold text-s">BR</div>
                        <span class="text-white">Bradesco</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>

                <!-- Santander -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded flex items-center justify-center text-white font-bold text-s">ST</div>
                        <span class="text-white">Santander</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>

                <!-- Nubank -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-600 rounded flex items-center justify-center text-white font-bold text-s">NU</div>
                        <span class="text-white">Nubank</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>

                <!-- Inter -->
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-600 rounded flex items-center justify-center text-white font-bold text-s">IN</div>
                        <span class="text-white">Inter</span>
                    </div>
                    <input type="number" step="0.01" class="w-24 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-s" placeholder="0,00">
                </div>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeBankModal()" class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md">Cancelar</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Salvar</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(month) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }
        
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }
        
        function openBankModal() {
            document.getElementById('bankModal').classList.remove('hidden');
            document.getElementById('bankModal').classList.add('flex');
        }
        
        function closeBankModal() {
            document.getElementById('bankModal').classList.add('hidden');
            document.getElementById('bankModal').classList.remove('flex');
        }
        
        // Fechar modais ao clicar fora
        document.getElementById('modal').addEventListener('click', function(e) {
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