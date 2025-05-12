<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController extends Controller
{
    public function index()
    {
        return Producto::with('categoria')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|integer|min:1|exists:categoria,id_categoria',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'required|string'
        ]);

        $producto = Producto::create($request->all());

        if(!$producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el producto'
            ]);
        }

        return response()->json([
            'mensaje' => 'Producto creado correctamente',
            'producto' => $producto
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'id_categoria' => 'required|integer|min:1|exists:categoria,id_categoria',
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'required|string',
            'disponible' => 'required|boolean'
        ]);

        $producto = Producto::find($request['id_producto']);

        if(!$producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el producto'
            ]);
        }

        $producto->update($request->all());

        if(!$producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el producto'
            ]);
        }

        return response()->json([
            'mensaje' => 'El producto se actualizó correctamente',
            'producto' => $producto
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|min:0|exists:producto,id_producto'
        ]);

        $producto = Producto::find($request['id_producto']);

        if(!$producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el producto'
            ]);
        }

        $producto->delete();

        if(!$producto)
        {
            return response()->json([
                'mensaje' => 'Error, el producto no se pudo eliminar'
            ]);
        }
        
        return response()->json([
            'mensaje' => 'El producto se eliminó correctamente'
        ]);
    }
}
