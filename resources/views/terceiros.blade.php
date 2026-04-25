<div>
    @forelse ($mes['terceiros'] as $terceiro)
        <div data-movimentacao-id="{{ $terceiro->id }}" data-movimentacao-type="{{ $terceiro->tipo }}" data-movimentacao-nome="{{ $terceiro->nome }}" data-movimentacao-valor="{{ $terceiro->valor }}" data-movimentacao-descricao="{{ $terceiro->descricao }}" class="flex justify-between items-center text-[15px] border-b border-gray-500 px-2 linha_movimentacao {{ $terceiro->status == 'pago' ? 'bg-gray-700' : 'bg-gray-900' }}">
            <div class="flex items-center gap-1">
                <span class="text-gray-300 text-[15px]">{{$terceiro->nome}} ({{$terceiro->responsavel}})</span>
                @if (!empty($terceiro->cartao->cor))<div class="w-4 h-3 bg-{{$terceiro->cartao->cor}} rounded text-xs border border-white/50"></div>@endif
            </div>
            <span class="text-gray-300 text-[15px]">{{App\Models\Helper::format($terceiro->valor)}}</span>
        </div>
    @empty
        <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2">
            <span class="text-gray-400 text-xs italic">Nenhum lançamento.</span>
        </div>
    @endforelse
</div>
@for ($i = count($mes['terceiros']); $i < $maximo_terceiros; $i++)
<div class="flex justify-between items-center text-[15px] border-b border-gray-500 px-2 linha_movimentacao">
    <span class="text-gray-300 text-[15px]">&nbsp;</span>
</div>
@endfor

<div class="p-2"></div>

@foreach ($mes['total_terceiros'] as $responsavel => $valor)
<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-purple-800">
    <span class="text-gray-300 text-base font-semibold">{{ ucfirst($responsavel) }}</span>
    <span class="text-gray-300 text-base font-semibold">{{ App\Models\Helper::format($valor) }} {{ ($responsavel == 'chah') ? '('.App\Models\Helper::format($antigo).')' : '' }}</span>
</div>
@endforeach

<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-purple-800">
    <span class="text-gray-300 text-base font-semibold">Total</span>
    <span class="text-gray-300 text-base font-semibold">{{App\Models\Helper::format($mes['terceiros']->sum('valor'))}}</span>
</div>
