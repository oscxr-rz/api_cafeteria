<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;

class CarritosController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario'
        ]);

        $carrito = Carrito::where('id_usuario', $request['id_usuario'])
        ->with('productos')->get();

        if (!$carrito) {
            return response()->json([
                'mensaje' => 'No ha agregado ningún producto al carrito'
            ]);
        }

        return response()->json([
            'carrito' => $carrito
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto'
        ]);

        $carrito = Carrito::create($request->all());

        if (!$carrito) {
            return response()->json([
                'mensaje' => 'Error, no se pudo agregar el producto al carrito'
            ]);
        }

        return response()->json([
            'mensaje' => 'El producto se agregó correctamente al carrito',
            'carrito' => $carrito
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:0'
        ]);

        $carrito = Carrito::where('id_usuario', $request['id_usuario'])
            ->where('id_producto', $request['id_producto'])
            ->update(['cantidad' => $request['cantidad']]);

        if (!$carrito) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el carrito'
            ]);
        }

        Carrito::where('id_usuario', $request['id_usuario'])
            ->where('id_producto', $request['id_producto'])
            ->where('cantidad', '=', 0)
            ->delete();

        return response()->json([
            'mensaje' => 'Carrito actualizado correctamente',
            'carrito' => $carrito
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto'
        ]);

        $carrito = Carrito::where('id_usuario', $request['id_usuario'])
            ->where('id_producto', $request['id_producto'])
            ->first();

        if (!$carrito) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el carrito'
            ]);
        }

        $carrito->delete();

        if (!$carrito) {
            return response()->json([
                'mensaje' => 'Error, el carrito no se pudo eliminar'
            ]);
        }

        return response()->json([
            'mensaje' => 'El carrito se eliminó correctamente'
        ]);
    }
}
