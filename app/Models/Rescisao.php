<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rescisao extends Model {
    protected $connection = 'mysql';
    protected $table = 'rescisao';
    public $timestamps = false;

    public $fillable = [
        'data',
        'valor',
        'retirada',
        'subtotal',
    ];
}
