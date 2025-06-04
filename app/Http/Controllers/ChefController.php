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
        DB::table('pedidos_productos')
            ->where('id_pedido', $id_pedido)
            ->where('id_prod', $id_prod)
            ->update(['Estado_prod' => 'entregado']);

        event(new ProductoEntregado([
            "id_pedido" => $id_pedido,
            "id_prod"   => $id_prod,
            "nombre"    => Producto::where("id_prod", $id_prod)->first()->Nombre,
            "N_mesa"    => Pedido::where("id_pedido", $id_pedido)->orderBy("id_pedido", "desc")->first()->Num_m
        ]));
    }
}
