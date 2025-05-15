<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $connection = 'mysql';
    protected $table = 'carrito';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'id_usuario',
        'id_producto',
        'cantidad'
    ];
    public $timestamps = false;

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
