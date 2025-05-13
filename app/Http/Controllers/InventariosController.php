<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventariosController extends Controller
{
    public function index()
    {
        return Inventario::with('producto')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer'
        ]);

        $inventario = Inventario::create($request->all());

        if (!$inventario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el inventario'
            ]);
        }

        return response()->json([
            'mensaje' => 'Inventario creado correctamente',
            'inventario' => $inventario
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer'
        ]);

        $inventario = Inventario::find($request['id_producto']);

        if (!$inventario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el inventario'
            ]);
        }

        $inventario->update($request->all());

        if (!$inventario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el inventario'
            ]);
        }

        return response()->json([
            'mensaje' => 'El inventario se actualizó correctamente',
            'inventario' => $inventario
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|min:0|exists:producto,id_producto'
        ]);

        $inventario = Inventario::find($request['id_producto']);

        if (!$inventario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el inventario'
            ]);
        }

        $inventario->delete();

        if (!$inventario) {
            return response()->json([
                'mensaje' => 'Error, el inventario no se pudo eliminar'
            ]);
        }

        return response()->json([
            'mensaje' => 'El inventario se eliminó correctamente'
        ]);
    }
}
