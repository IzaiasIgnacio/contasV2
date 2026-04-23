<div id="statusContextMenu" class="fixed hidden z-50 w-48 bg-black border border-gray-700 rounded-md shadow-lg py-1 text-sm text-gray-300">
    <ul>
        <li onclick="setStatus('planejado')" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
            </svg>
            Planejado
        </li>
        <li onclick="setStatus('definido')" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 12.75 1.5 1.5 3-3" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
            </svg>
            Definido
        </li>
        <li onclick="setStatus('pago')" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
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
                <li onclick="setCartao(null)" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                    Nenhum
                </li>
                @foreach ($cartoes as $cartao)
                <li onclick="setCartao({{ $cartao->id }})" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
                    {{ $cartao->rotulo }}
                </li>
                @endforeach
            </ul>
        </li>
        <li class="my-1">
            <hr class="border-gray-600">
        </li>
        <li onclick="setItau()" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.25-5.5h-1.5l.25 5.5h1.5zM12 16.5a.75.75 0 110-1.5.75.75 0 010 1.5zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Itaú
        </li>
        <li onclick="setNb()" class="px-3 py-1 hover:bg-gray-700 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-3">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
            </svg>
            Nubank
        </li>
        <li class="my-1">
            <hr class="border-gray-600">
        </li>
        <li onclick="openEditModal()" class="px-3 py-1 hover:bg-blue-500 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
            Editar
        </li>
        <li onclick="deleteMovimentacao()" class="px-3 py-1 hover:bg-red-500 hover:text-white cursor-pointer transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09.92-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            Excluir
        </li>
    </ul>
</div>