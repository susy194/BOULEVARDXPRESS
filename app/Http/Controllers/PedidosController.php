<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Producto;
use App\Models\User;
use App\Models\Empleado;
use App\Models\PedidoProductos;
use App\Models\Pedido;
use App\Models\Mesa;

class PedidosController extends Controller
{
    public function agregarPedido( Request $request, $Num_m ): JsonResponse
    {
        $user = Auth::user()->usuario;
        $data = $request->json()->all();

        $ID_emp = User::where('usuario', $user)->first()->ID_emp;
        $PRECIO = Producto::where('id_prod', $data['producto'])->first()->PRECIO;

        $pedido = Pedido::create([
            'ID_emp' => $ID_emp,
            'Fecha'  => date('Y-m-d'),
            'Hora'   => date('H:i:s'),
            'Num_m'  => $Num_m,
            'Estado' => 'Pendiente',
        ]);

        PedidoProductos::insert([
            'id_pedido'   => $pedido->id_pedido,
            'id_prod'     => $data['producto'],
            'cant_prod'   => $data['cantidad'],
            'Nota_prod'   => $data['notas'   ],
            'Estado_prod' => 'pendiente',
        ]);


        Mesa::where('Num_m', $Num_m)->update(['Estado' => 1]);

        return response()->json([
            'ok' => true
        ], 202);
    }

    public function eliminarPedido(Request $request, $Num_m): JsonResponse
    {
        $pedidoProductos = PedidoProductos::find($request["id_pedido"]);

        if ( $pedidoProductos ) {
            $pedidoProductos->delete();
        }

        return response()->json([
            'ok' => true
        ], 202);
    }
}
