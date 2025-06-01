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
                    "id_pedido" => $pedido->id_pedido,
                    "producto"  => $producto->Nombre,
                    "cantidad"  => $pedidoProducto->cant_prod,
                    "nota"      => $pedidoProducto->Nota_prod
                ]));
            }
        }
        return "OK";
    }
}
