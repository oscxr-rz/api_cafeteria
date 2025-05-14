<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Menu_producto;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        return Menu::with('productos')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date|unique:menu,fecha',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'productos.*.cantidad_disponible' => 'required|integer'
        ]);

        $menu = Menu::create([
            'fecha' => $request['fecha']
        ]);

        if (!$menu) {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el menú'
            ]);
        }

        $menu_productos = [];

        foreach ($request['productos'] as $producto) {
            $menu_producto = Menu_producto::create([
                'id_menu' => $menu['id_menu'],
                'id_producto' => $producto['id_producto'],
                'cantidad_disponible' => $producto['cantidad_disponible']
            ]);

            if (!$menu_producto) {
                $menu->delete();

                return response()->json([
                    'mensaje' => 'Error, no se pudo crear el menú con los productos'
                ]);
            }

            $menu_productos[] = $menu_producto;
        }

        return response()->json([
            'mensaje' => 'Menú creado correctamente con ' . count($menu_productos) . ' productos',
            'menu' => $menu,
            'menu_productos' => $menu_productos
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:1|exists:menu,id_menu',
            'fecha' => 'required|date',
            'activo' => 'required|integer|min:0|max:1',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|integer|min:1|exists:producto,id_producto',
            'productos.*.cantidad_disponible' => 'required|integer|min:0'
        ]);

        $menu = Menu::find($request['id_menu']);

        if (!$menu) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menú'
            ]);
        }

        if ($menu['fecha'] != $request['fecha']) {
            $menuFecha = Menu::where('fecha', $request['fecha'])
                ->where('id_menu', '!=', $request['id_menu'])
                ->first();

            if ($menuFecha) {
                return response()->json([
                    'mensaje' => 'Error, ya existe otro menú con esta fecha'
                ]);
            }
        }

        $menu->update([
            'fecha' => $request['fecha'],
            'activo' => $request['activo']
        ]);

        if (!$menu) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el menú'
            ]);
        }

        Menu_producto::where('id_menu', $menu['id_menu'])->delete();

        $menu_productos = [];

        foreach ($request['productos'] as $producto) {
            $menu_producto = Menu_producto::create([
                'id_menu' => $menu['id_menu'],
                'id_producto' => $producto['id_producto'],
                'cantidad_disponible' => $producto['cantidad_disponible']
            ]);

            if (!$menu_producto) {
                return response()->json([
                    'mensaje' => 'Error, no se pudo actualizar el menú con los productos'
                ]);
            }

            $menu_productos[] = $menu_producto;
        }

        return response()->json([
            'mensaje' => 'Menú actualizado correctamente',
            'menu' => $menu,
            'menu_productos' => $menu_productos
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer|min:0|exists:menu,id_menu'
        ]);
        
        $menu = Menu::find($request['id_menu']);
        
        if (!$menu) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el menu'
            ]);
        }

        Menu_producto::where('id_menu', $menu['id_menu'])->delete();
        
        $menu->delete();

        if (!$menu) {
            return response()->json([
                'mensaje' => 'Error, el menú no se pudo eliminar'
            ]);
        }

        return response()->json([
            'mensaje' => 'El menú se eliminó correctamente'
        ]);
    }
}
