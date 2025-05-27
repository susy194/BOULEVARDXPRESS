<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class PedidosController extends Controller
{
    public function agregarPedido( Request $request, $Num_m )
    {
        $user = Auth::user()->usuario;

        $data = $request->json()->all();

        return response()->json([
            'mesa' => $mesa,
            'pedido' => $data,
        ]);
    }
}
