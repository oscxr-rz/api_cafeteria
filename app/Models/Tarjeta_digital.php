<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarjeta_digital extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tarjeta_digital';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'saldo'
    ];
    public $timestamps = false;
}
