<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\PedidoProductos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Events\GetMesas;

class ChefController extends Controller
{
    public function CargarPagina()
    {
        return view('pagina-principal-chef');
    }

    public function ObtenerComanda()
    {
        broadcast(new GetMesas("hola"));
        return "OK";
    }

}
