<?php

namespace App\Http\Controllers;

use App\Models\Tarjeta_digital;
use Illuminate\Http\Request;

class TarjetasController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario'
        ]);

        $tarjeta = Tarjeta_digital::where('id_usuario', $request['id_usuario'])->get();
        return response()->json([
            'tarjeta' => $tarjeta
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer|min:1|exists:usuario,id_usuario',
            'saldo' => 'required|integer'
        ]);

        $tarjeta = Tarjeta_digital::where('id_usuario', $request['id_usuario'])->first();

        $tarjeta->update([
            'saldo' => $tarjeta['saldo'] + $request['saldo']
        ]);

        if(!$tarjeta)
        {
            return response()->json([
                'mensaje' => "Erro, no se pudo actualizar la tarjeta"
            ]);
        }

        return response()->json([
            'mensaje' => "Saldo actualizado correctamente",
            'tarjeta' => $tarjeta
        ]);
    }
}
