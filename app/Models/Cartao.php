<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;

    protected $table = 'cartao';

    public function listaCartoesAtivos() {
        $data_atual = \Carbon\Carbon::createFromFormat('d/m/Y', '01/'.Consolidado::where('nome', 'mes_atual')->first()->valor);
        $proximo_mes = $data_atual->copy()->addMonth();
        $mes_seguinte = $proximo_mes->copy()->addMonth();

        return $this
            ->select('cartao.*',
                DB::raw('(
                    select coalesce(sum(case when tipo in(\'gasto\', \'terceiros\') then valor else 0 end), 0) - 
                           coalesce(sum(case when tipo = \'renda\' then valor else 0 end), 0)
                    from movimentacao 
                    where id_cartao = cartao.id 
                    and month(data) = '.$proximo_mes->month.' 
                    and year(data) = '.$proximo_mes->year.'
                ) as proxima_fatura'),
                DB::raw('(
                    select coalesce(sum(case when tipo in(\'gasto\', \'terceiros\') then valor else 0 end), 0) - 
                           coalesce(sum(case when tipo = \'renda\' then valor else 0 end), 0)
                    from movimentacao 
                    where id_cartao = cartao.id 
                    and month(data) = '.$mes_seguinte->month.' 
                    and year(data) = '.$mes_seguinte->year.'
                ) as fatura_seguinte')
            )
            ->addSelect(DB::raw('(credito - (
                select coalesce(sum(case when tipo in(\'gasto\', \'terceiros\') then valor when tipo = \'renda\' then -valor else 0 end), 0)
                from movimentacao where id_cartao = cartao.id and status <> \'pago\'
            )) as limite_atual'))
            ->where('ativo', 1)
            ->where('id', '<>', 4)
                ->orderBy('ordem')
                    ->get();
    }
}