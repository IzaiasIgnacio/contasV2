<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacao';

    public function mes($data) {
        // $this->definirValoresFixosMes($data, $movimentacao);

        $mes = [
            'mes' => ucfirst($data->locale('pt-br')->monthName),
            'numero_mes' => $data->locale('pt-br')->month,
            'ano' => $data->locale('pt-br')->year,
            'movimentacoes' => $this
                                ->whereMonth('data', $data->format('m'))
                                ->whereYear('data', $data->format('Y'))
                                ->whereNotIn('tipo', ['save', 'terceiros'])
                                ->where('nome', '!=', 'salario')
                                    ->orderBy('tipo')
                                    ->orderBy('posicao')
                                        ->get(),
            'salario' => $this->whereMonth('data', $data->format('m'))->whereYear('data', $data->format('Y'))->where('nome', 'salario')->first()->valor
        ];
        
        $mes['terceiros'] = $this
                                ->whereMonth('data', $data->format('m'))
                                ->whereYear('data', $data->format('Y'))
                                ->where('tipo', 'terceiros')
                                    ->orderBy('tipo')
                                    ->orderBy('posicao')
                                        ->get();
        
        return $mes;
    }
        
}