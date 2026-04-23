<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-gray-700 text-white min-h-screen flex font-sans pl-48 md:pl-54">
    @include('navegacao', ['total' => $total, 'cartoes' => $cartoes, 'total_nb' => $total_nb, 'total_itau' => $total_itau, 'diferenca_nb' => $diferenca_nb, 'diferenca_itau' => $diferenca_itau, 'valor_contas' => $valor_contas])

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
    @include('modal_transacao')

    <!-- Modal Contas Bancárias -->
    @include('modal_contas')

    <!-- Modal Seleção de Data -->
    @include('modal_data')

    <!-- Modal Editar -->
    @include('modal_editar')

    <!-- Menu de Contexto -->
    @include('menu_contexto', ['cartoes' => $cartoes])

    <script src="{{ URL::asset('resources/js/contas.js') }}"></script>

</body>

</html>
