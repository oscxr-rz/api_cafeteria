<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        return Categoria::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string'
        ]);

        $categoria = Categoria::create($request->all());

        if(!$categoria)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear la categoria'
            ]);
        }

        return response()->json([
            'mensaje' => 'Categoria creada correctamente',
            'categoria' => $categoria
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|integer|min:1|exists:categoria,id_categoria',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'activo' => 'required|boolean'
        ]);

        $categoria = Categoria::find($request['id_categoria']);

        if(!$categoria)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar la categoría'
            ]);
        }

        $categoria->update($request->all());

        if(!$categoria)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar la categoría'
            ]);
        }

        return response()->json([
            'mensaje' => 'La categoría se actualizó correctamente',
            'categoria' => $categoria
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|integer|min:0|exists:categoria,id_categoria'
        ]);

        $categoria = Categoria::find($request['id_categoria']);

        if(!$categoria)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar la categoría'
            ]);
        }

        $categoria->delete();

        if(!$categoria)
        {
            return response()->json([
                'mensaje' => 'Error, la categoría no se pudo eliminar'
            ]);
        }
        
        return response()->json([
            'mensaje' => 'La categoría se eliminó correctamente'
        ]);
    }
}
