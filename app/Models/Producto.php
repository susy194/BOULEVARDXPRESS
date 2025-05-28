<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Producto extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id_prod';
    public    $timestamps = false;

    protected $fillable = [
        'Descripcion', 'Nombre', 'PRECIO', 'Cod_cat'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'Cod_cat', 'Cod_cat');
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoProductos::class, 'id_prod');
    }

    public function eliminarProducto($id, Request $request)
    {
        \Log::info('Intentando eliminar producto', ['id' => $id]);
        $producto = \DB::table('productos')->where('id_prod', $id)->first();

        if (!$producto) {
            \Log::warning('Producto no encontrado', ['id' => $id]);
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        // Elimina los hijos primero
        $hijosBorrados = \DB::table('pedidos_productos')->where('id_prod', $id)->delete();
        \Log::info('Hijos borrados', ['cantidad' => $hijosBorrados]);

        // Elimina el producto directamente con Query Builder
        $deletedDirect = \DB::table('productos')->where('id_prod', $id)->delete();
        \Log::info('Resultado delete directo', ['deletedDirect' => $deletedDirect]);

        if ($request->ajax()) {
            return response()->json(['success' => (bool)$deletedDirect]);
        }
        return back()->with('success', 'Producto eliminado');
    }
}
