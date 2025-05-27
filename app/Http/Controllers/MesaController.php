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
            $pedido = Pedido::where('Num_m', $id)->first();

            return view("ver-mesa", [
                'productosPedidos' => PedidoProductos::with('productos')->where('id_pedido', $pedido->id_pedido)->get(),
                'pedido' => $pedido
            ]);
        }

        return redirect()->route('categorias', ['mesa' => $id]);
    }
}
