<?php

namespace App\Http\Controllers;

use App\Models\Menu_producto;
use Illuminate\Http\Request;

class Menus_productosController extends Controller
{
    public function index()
    {
        return Menu_producto::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:1|exists:menu,id_menu',
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'cantidad_disponible' => 'required|integer'
        ]);

        $menu_producto = Menu_producto::create($request->all());

        if(!$menu_producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el menú'
            ]);
        }

        return response()->json([
            'mensaje' => 'Menú creado correctamente',
            'menu_producto' => $menu_producto
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:1|exists:menu,id_menu',
            'id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'cantidad_disponible' => 'required|integer'
        ]);

        $menu_producto = Menu_producto::find($request['id_menu']);

        if(!$menu_producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menú'
            ]);
        }

        $menu_producto->update($request->all());

        if(!$menu_producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el menú'
            ]);
        }

        return response()->json([
            'mensaje' => 'El menú se actualizó correctamente',
            'menu_producto' => $menu_producto
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:0|exists:menu,id_menu'
        ]);

        $menu_producto = Menu_producto::find($request['id_menu']);

        if(!$menu_producto)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menu'
            ]);
        }

        $menu_producto->delete();

        if(!$menu_producto)
        {
            return response()->json([
                'mensaje' => 'Error, el menú no se pudo eliminar'
            ]);
        }
        
        return response()->json([
            'mensaje' => 'El menú se eliminó correctamente'
        ]);
    }
}
