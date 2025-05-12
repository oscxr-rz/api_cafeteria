<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $connection = 'mysql';
    protected $table = 'comentario';
    protected $primaryKey = 'id_comentario';
    protected $fillable = [
        'id_usuario',
        'comentario',
        'calificacion'
    ];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
