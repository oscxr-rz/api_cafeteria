<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_producto extends Model
{
    protected $connection = 'mysql';
    protected $table = 'menu_producto';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'id_menu',
        'id_producto',
        'cantidad_disponible'
    ];
    public $timestamps = false;
}
