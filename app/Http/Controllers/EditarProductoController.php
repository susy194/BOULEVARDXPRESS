<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoProductos;
use Illuminate\Support\Facades\DB;

class EditarProductoController extends Controller
{
    public function editar(Request $request)
    {
        $request->validate([
            'id_pedido' => 'required|integer',
            'id_prod' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'notas' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $pedidoProducto = PedidoProductos::where([
                'id_pedido' => $request->id_pedido,
                'id_prod' => $request->id_prod
            ])->first();

            if (!$pedidoProducto) {
                return response()->json([
                    'error' => 'Producto no encontrado en el pedido'
                ], 404);
            }

            // Actualizar usando query builder para evitar problemas con la clave primaria compuesta
            DB::table('pedidos_productos')
                ->where('id_pedido', $request->id_pedido)
                ->where('id_prod', $request->id_prod)
                ->update([
                    'cant_prod' => $request->cantidad,
                    'Nota_prod' => $request->notas
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al editar producto: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }
}