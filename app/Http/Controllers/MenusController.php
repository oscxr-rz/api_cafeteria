<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        return Menu::with('producto')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $menu = Menu::create($request->all());

        if(!$menu)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el menú'
            ]);
        }

        return response()->json([
            'mensaje' => 'Menú creado correctamente',
            'menu' => $menu
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:1|exists:menu,id_menu',
            'fecha' => 'required|date',
            'activo' => 'required|integer|min:0|max:1'
        ]);

        $menu = Menu::find($request['id_menu']);

        if(!$menu)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menú'
            ]);
        }

        $menu->update($request->all());

        if(!$menu)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el menú'
            ]);
        }

        return response()->json([
            'mensaje' => 'El menú se actualizó correctamente',
            'menu' => $menu
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:0|exists:menu,id_menu'
        ]);

        $menu = Menu::find($request['id_menu']);

        if(!$menu)
        {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menu'
            ]);
        }
        
        $menu->delete();

        if(!$menu)
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
