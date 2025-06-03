<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoProductos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Events\GetMesas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\ActualizarEstadoProducto;
use App\Events\ProductoEntregado;

class ChefController extends Controller
{
    public function CargarPagina()
    {
        session([ "ws_token" => Str::random(16)]);
        session()->save();

        return view('pagina-principal-chef', [
            'token' => session('ws_token')
        ]);
    }

    public function ObtenerComanda()
    {
        $pedidos = Pedido::with('PedidoProductos.productos')
            ->where("Estado", "pendiente")
            ->get();

        foreach ( $pedidos as $pedido ) {
            foreach ( $pedido->pedidoProductos as $pedidoProducto ) {
                $producto = Producto::where("id_prod", $pedidoProducto->id_prod)->first();

                event( new GetMesas([
                    "Num_m"       => $pedido->Num_m,
                    "id_pedido"   => $pedido->id_pedido,
                    "id_prod"     => $producto->id_prod,
                    "producto"    => $producto->Nombre,
                    "cantidad"    => $pedidoProducto->cant_prod,
                    "nota"        => $pedidoProducto->Nota_prod,
                    "estado"      => $pedidoProducto->Estado_prod
                ]));
            }
        }
        return "OK";
    }

    public function CambiarEstadoProducto($id_pedido, $id_prod)
    {
        try {
            \Log::info('Intentando cambiar estado del producto', [
                'id_pedido' => $id_pedido,
                'id_prod' => $id_prod
            ]);

            // Obtener el estado actual del producto
            $producto = DB::table('pedidos_productos')
                ->where('id_pedido', $id_pedido)
                ->where('id_prod', $id_prod)
                ->first();

            if (!$producto) {
                \Log::error('Producto no encontrado');
                return response()->json(['success' => false, 'error' => 'Producto no encontrado'], 404);
            }

            // Solo actualizar si está pendiente
            if ($producto->Estado_prod === 'pendiente') {
                DB::table('pedidos_productos')
                    ->where('id_pedido', $id_pedido)
                    ->where('id_prod', $id_prod)
                    ->update(['Estado_prod' => 'entregado']);

                \Log::info('Estado actualizado a entregado');

                // Emitir el evento
                $eventData = [
                    'id_pedido' => $id_pedido,
                    'id_prod' => $id_prod,
                    'estado' => 'entregado'
                ];

                \Log::info('Emitiendo evento con datos:', $eventData);

                // Emitir el evento de dos formas para asegurar que funcione
                event(new ProductoEntregado($eventData));
                broadcast(new ProductoEntregado($eventData))->toOthers();

                return response()->json(['success' => true, 'estado' => 'entregado']);
            }

            \Log::warning('Producto ya no está pendiente');
            return response()->json(['success' => false, 'error' => 'El producto ya no está pendiente']);
        } catch (\Exception $e) {
            \Log::error('Error al actualizar estado del producto: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
