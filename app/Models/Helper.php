<?php
namespace App\Models;

class Helper {
    public static function format($valor) {
        // Verifica se o número é um inteiro ou se a parte decimal é zero
        if ($valor == floor($valor)) {
            return number_format($valor, 0, ',', '.');
        }
        
        // Formata com 2 casas decimais se houver centavos
        return number_format($valor, 2, ',', '.');
    }

    public static function data_fechamento($vencimento, $dias_fechamento) {
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', $vencimento.'/'.Consolidado::where('nome', 'mes_atual')->first()->valor);
        $data->addMonth();

        return $data->subDays($dias_fechamento)->format('d/m');
    }

}