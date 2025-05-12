<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $connection = 'mysql';
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'password',
        'tipo',
        'imagen'
    ];
    public $timestamps = false;

     public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
