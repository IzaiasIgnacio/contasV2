<div>
    @forelse ($mes['terceiros'] as $terceiro)
        <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2">
            <span class="text-gray-300 text-base font-semibold">{{$terceiro->nome}} ({{$terceiro->responsavel}})</span>
            <span class="text-gray-300 text-base font-semibold">{{App\Models\Helper::format($terceiro->valor)}}</span>
        </div>
    @empty
        <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2">
            <span class="text-gray-400 text-xs italic">Nenhum lançamento.</span>
        </div>
    @endforelse
    @for ($i = count($mes['terceiros']); $i < $maximo_terceiros; $i++)
    <div class="flex justify-between items-center text-sm border-b border-gray-500 px-2">
        <span class="text-gray-300 text-base font-semibold">&nbsp;</span>
    </div>
    @endfor
</div>

<div class="p-2"></div>

<div class="flex justify-between items-center text-sm border-b border-gray-500 px-2 bg-purple-800">
    <span class="text-gray-300 text-base font-semibold">Total</span>
    <span class="text-gray-300 text-base font-semibold">{{App\Models\Helper::format($mes['terceiros']->sum('valor'))}}</span>
</div>
