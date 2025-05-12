<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $connection = 'mysql';
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

}
