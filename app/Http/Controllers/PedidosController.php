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
use App\Events\GetMesas;
use Illuminate\Support\Facades\Log;


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

        $pedidoProducto = PedidoProductos::create([
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

        $producto = Producto::where("id_prod", $pedidoProducto->id_prod)->first();

        event( new GetMesas([
            "Num_m"     => $pedido->Num_m,
            "id_pedido" => $pedido->id_pedido,
            "id_prod"   => $producto->id_prod,
            "producto"  => $producto->Nombre,
            "cantidad"  => $pedidoProducto->cant_prod,
            "nota"      => $pedidoProducto->Nota_prod,
            "estado"    => $pedidoProducto->Estado_prod
        ]));

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
        try {
            \Log::info('Intentando eliminar producto', [
                'request_data' => $request->all(),
                'json_data' => $request->json()->all(),
                'mesa' => $Num_m
            ]);

            $data = $request->json()->all();

            if (!isset($data['id_pedido']) || !isset($data['id_prod'])) {
                \Log::error('Datos faltantes en la solicitud', ['data' => $data]);
                return response()->json([
                    'ok' => false,
                    'message' => 'Datos incompletos en la solicitud'
                ], 400);
            }

            $id_pedido = $data['id_pedido'];
            $id_prod = $data['id_prod'];

            $producto = Producto::where('id_prod', $id_prod)
                ->first()
                ->Nombre;

            \Log::info('Eliminando producto', [
                'id_pedido' => $id_pedido,
                'id_prod' => $id_prod
            ]);

            $deleted = PedidoProductos::where('id_pedido', $id_pedido)
                ->where('id_prod', $id_prod)
                ->delete();

            if (!$deleted) {
                \Log::warning('No se pudo eliminar el producto', [
                    'id_pedido' => $id_pedido,
                    'id_prod' => $id_prod
                ]);
                return response()->json([
                    'ok' => false,
                    'message' => 'No se pudo eliminar el producto'
                ], 404);
            }

            \Log::info('Producto eliminado exitosamente', [
                'id_pedido' => $id_pedido,
                'id_prod' => $id_prod
            ]);

            event( new GetMesas([
                "Num_m"     => $Num_m,
                "id_pedido" => null,
                "id_prod"   => $id_prod,
                "producto"  => $producto,
                "cantidad"  => null,
                "nota"      => null,
                "estado"    => "eliminado"
            ]));

            return response()->json([
                'ok' => true,
                'message' => 'Producto eliminado exitosamente'
            ], 202);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar producto', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }
}
