<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terceiros extends Model {
    
    public function listar() {
        return [
            'mae' => 'Mãe',
            'junior' => 'Junior',
            'tia_cacilda' => 'Tia Cacilda',
            'chah' => 'Chah',
            'cristiane' => 'Cristiane',
            'tia_lucenir' => 'Tia Lucenir',
            'tio_anisio' => 'Tio Anisio'
        ];
    } 
    
}
