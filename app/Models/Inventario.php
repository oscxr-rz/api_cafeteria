<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $connection = 'mysql';
    protected $table = 'inventario';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'id_producto',
        'stock_actual',
        'stock_minimo'
    ];
    public $timestamps = false;

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id_producto');
    }
}
