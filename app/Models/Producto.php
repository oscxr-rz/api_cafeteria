<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'mysql';
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'disponible'
    ];
    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
