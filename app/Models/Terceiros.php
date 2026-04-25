<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terceiros extends Model {
    
    public function listar() {
        return [
            'mae' => 'Mãe',
            'chah' => 'Chah',
            'cristiane' => 'Cristiane',
            'tio_anisio' => 'Tio Anisio',
            'junior' => 'Junior',
            'tia_cacilda' => 'Tia Cacilda',
            'tia_lucenir' => 'Tia Lucenir',
        ];
    } 
    
}
