<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\PedidoProductos;

class MesaController extends Controller
{
    const OCUPADO = 1;
    const VACIO   = 0;

    public function getMesas()
    {
        $mesas = Mesa::select('Num_m', 'Estado')->get();
        return response()->json($mesas);
    }

    public function verMesa($id)
    {
        $mesa = Mesa::find($id);

        if (!$mesa) {
            abort(404, 'Mesa no encontrada');
        }

        if ( $mesa->Estado == self::OCUPADO ) {
            $pedido = Pedido::with("PedidoProductos.productos")
                ->where('Num_m', $id)
                ->orderBy('id_pedido', 'desc')
                ->first();

            return view("ver-mesa", [
                'pedido' => $pedido,
                'Num_m' => $id
            ]);
        }

        return redirect()->route('categorias', ['mesa' => $id]);
    }
}
