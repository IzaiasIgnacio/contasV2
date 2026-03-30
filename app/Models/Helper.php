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
    
    // public function getTotalSavingsAtual() {
    //     return Consolidado::get('caixinha2');
    // }

    // // total incluindo savings
    // public function getTotal() {
    //     return $this->format(Consolidado::where('totais', 1)->sum('valor'));
    // }

    // public function getTotalAtual() {
    //     return $this->format(Consolidado::where('atual', 1)->sum('valor'));
    // }

    public static function data_fechamento($vencimento, $dias_fechamento) {
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', $vencimento.'/'.Consolidado::where('nome', 'mes_atual')->first()->valor);
        $data->addMonth();

        return $data->subDays($dias_fechamento)->format('d/m');
    }

}