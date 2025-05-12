<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function index()
    {
        return Comentario::with('usuario')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'comentario' => 'required|string',
            'calificacion' => 'required|integer|min:0|max:5'
        ]);

        $comentario = Comentario::create($request->all());

        if(!$comentario)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el comentario'
            ]);
        }

        return response()->json([
            'mensaje' => 'Producto creado correctamente',
            'comentario' => $comentario
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_comentario' => 'required|integer|min:1|exists:comentario,id_comentario',
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'comentario' => 'required|string',
            'calificacion' => 'required|integer|min:0|max:5'
        ]);

        $comentario = Comentario::find($request['id_comentario']);

        if(!$comentario)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el comentario'
            ]);
        }

        $comentario->update($request->all());

        if(!$comentario)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el comentario'
            ]);
        }

        return response()->json([
            'mensaje' => 'El comentario se actualizó correctamente',
            'comentario' => $comentario
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_comentario' => 'required|integer|min:0|exists:comentario,id_comentario'
        ]);

        $comentario = Comentario::find($request['id_comentario']);

        if(!$comentario)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el comentario'
            ]);
        }

        $comentario->delete();

        if(!$comentario)
        {
            return response()->json([
                'mensaje' => 'Error, el comentario no se pudo eliminar'
            ]);
        }
        
        return response()->json([
            'mensaje' => 'El comentario se eliminó correctamente'
        ]);
    }
}
