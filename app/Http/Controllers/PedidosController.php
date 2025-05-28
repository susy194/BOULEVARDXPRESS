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
    public function agregarPedido(Request $request, $Num_m): JsonResponse
    {
        $user = Auth::user()->usuario;
        $data = $request->json()->all();

        $ID_emp = User::where('usuario', $user)->first()->ID_emp;
        $PRECIO = Producto::where('id_prod', $data['producto'])->first()->PRECIO;

        // Verificar si ya existe un pedido para esta mesa
        $pedido = Pedido::where('Num_m', $Num_m)
            ->where('Estado', 'Pendiente')
            ->first();

        if (!$pedido) {
            $pedido = Pedido::create([
                'ID_emp' => $ID_emp,
                'Fecha'  => date('Y-m-d'),
                'Hora'   => date('H:i:s'),
                'Num_m'  => $Num_m,
                'Estado' => 'Pendiente',
            ]);
        }

        PedidoProductos::create([
            'id_pedido'   => $pedido->id_pedido,
            'id_prod'     => $data['producto'],
            'cant_prod'   => $data['cantidad'],
            'Nota_prod'   => $data['notas'],
            'Estado_prod' => 'pendiente',
        ]);

        Mesa::where('Num_m', $Num_m)->update(['Estado' => 1]);

        // Obtener los productos actualizados del pedido
        $productosPedidos = PedidoProductos::with('productos')
            ->where('id_pedido', $pedido->id_pedido)
            ->get();

        return response()->json([
            'ok' => true,
            'message' => 'Producto agregado exitosamente',
            'pedido' => [
                'id' => $pedido->id_pedido,
                'productos' => $productosPedidos->map(function($item) {
                    return [
                        'id' => $item->id_pedido,
                        'cantidad' => $item->cant_prod,
                        'nombre' => $item->productos->Nombre,
                        'notas' => $item->Nota_prod,
                        'estado' => $item->Estado_prod
                    ];
                })
            ]
        ], 202);
    }

    public function eliminarPedido(Request $request, $Num_m): JsonResponse
    {
        $id_pedido = $request["id_pedido"];
        $id_prod = $request["id_prod"];

        PedidoProductos::where('id_pedido', $id_pedido)
            ->where('id_prod', $id_prod)
            ->delete();

        return response()->json([
            'ok' => true
        ], 202);
    }
}
