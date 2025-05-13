<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'mysql';
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'fecha',
        'activo'
    ];
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsToMany(Producto::class, 'menu_producto', 'id_menu', 'id_producto');
    }
}
