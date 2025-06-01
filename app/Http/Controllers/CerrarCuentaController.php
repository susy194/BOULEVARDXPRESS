<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CerrarCuentaController extends Controller
{
    public function cerrarCuenta($num_mesa)
    {
        $pedido = DB::table('PEDIDOS')
            ->where('Num_m', $num_mesa)
            ->where('Estado', 'Pendiente')
            ->orderByDesc('id_pedido')
            ->first();

        $productos = [];
        $total = 0;

        if ($pedido) {
            $productos = DB::table('PEDIDOS_PRODUCTOS as pp')
                ->join('PRODUCTOS as p', 'pp.id_prod', '=', 'p.id_prod')
                ->where('pp.id_pedido', $pedido->id_pedido)
                ->select('p.Nombre', 'p.PRECIO', 'pp.cant_prod', DB::raw('(p.PRECIO * pp.cant_prod) as importe'))
                ->get();

            $total = $productos->sum('importe');
        }

        return view('cerrar-cuenta', [
            'num_mesa' => $num_mesa,
            'productos' => $productos,
            'total' => $total
        ]);
    }
}