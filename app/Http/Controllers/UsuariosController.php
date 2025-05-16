<?php

namespace App\Http\Controllers;

use App\Models\Tarjeta_digital;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email|unique:usuario,email',
            'telefono' => 'required|numeric|unique:usuario,telefono',
            'password' => 'required|string',
            'tipo' => 'required|string'
        ]);

        $usuario = Usuario::create($request->all());

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo crear el usuario'
            ]);
        }

        $tarjeta = Tarjeta_digital::create([
            'id_usuario' => $usuario['id_usuario']
        ]);

        if (!$tarjeta) {
            return response()->json([
                'mensaje' => "Error, no se pudo crear la tarjeta"
            ]);
        }

        return response()->json([
            'mensaje' => 'Usuario creado correctamente',
            'usuario' => $usuario,
            'tarjeta' => $tarjeta
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'password' => 'required|string',
            'imagen' => 'required|string'
        ]);

        $usuario = Usuario::find($request['id_usuario']);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el usuario'
            ]);
        }

        $usuario->update($request->all());

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el usuario'
            ]);
        }

        return response()->json([
            'mensaje' => 'El usuario se actualizó correctamente',
            'usuario' => $usuario
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:0|exists:usuario,id_usuario'
        ]);

        $usuario = Usuario::find($request['id_usuario']);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el usuario'
            ]);
        }

        $tarjeta = Tarjeta_digital::find($usuario['id_usuario']);

        if (!$tarjeta) {
            $usuario->delete();
            return response()->json([
                'mensaje' => 'El usuario se eliminó correctamente'
            ]);
        }

        $tarjeta->delete();
        $usuario->delete();

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, el usuario no se pudo eliminar'
            ]);
        }

        return response()->json([
            'mensaje' => 'El usuario se eliminó correctamente'
        ]);
    }

    public function validate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'tipo' => 'required|string'
        ]);

        $usuario = Usuario::where('email', $request['email'])
            ->where('tipo', $request['tipo'])
            ->first();

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se encontró el usuario'
            ]);
        }

        if (Hash::check($request['password'], $usuario['password_hash'])) {
            return response()->json([
                'mensaje' => 'Se inició sesión',
                'usuario' => $usuario
            ]);
        } else {
            return response()->json([
                'mensaje' => 'Datos incorrectos'
            ]);
        }
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'email' => 'required|email|unique:usuario,email',
        ]);

        $usuario = Usuario::find($request['id_usuario']);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el usuario'
            ]);
        }

        $usuario->update($request->all());

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el usuario'
            ]);
        }

        return response()->json([
            'mensaje' => 'El usuario se actualizó correctamente',
            'usuario' => $usuario
        ]);
    }

    public function updateTelefono(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'telefono' => 'required|numeric|unique:usuario,telefono',
        ]);

        $usuario = Usuario::find($request['id_usuario']);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo encontrar el usuario'
            ]);
        }

        $usuario->update($request->all());

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Error, no se pudo actualizar el usuario'
            ]);
        }

        return response()->json([
            'mensaje' => 'El usuario se actualizó correctamente',
            'usuario' => $usuario
        ]);
    }
}
