<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\View\View;
use App\Models\Producto;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::with('productos')
            ->orderBy('Categoria')
            ->get();

        return view('admin-menu', compact('categorias'));
    }

    public function eliminarProducto($id, Request $request)
    {
        \Log::info('Intentando eliminar producto', ['id' => $id]);
        $producto = Producto::find($id);

        if (!$producto) {
            \Log::warning('Producto no encontrado', ['id' => $id]);
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        // Elimina los hijos primero
        \DB::table('pedidos_productos')->where('id_prod', $id)->delete();

        $deleted = $producto->delete();
        \Log::info('Resultado delete()', ['deleted' => $deleted]);

        if ($request->ajax()) {
            return response()->json(['success' => (bool)$deleted]);
        }
        return back()->with('success', 'Producto eliminado');
    }

    public function create()
    {
        $categorias = \DB::table('CATEGORIA')->orderBy('Categoria')->get();
        return view('admin-menu-agregar', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Cod_cat' => 'required|exists:CATEGORIA,Cod_cat',
            'Nombre' => 'required|max:100',
            'Descripcion' => 'required|max:1000',
            'PRECIO' => 'required|integer|min:0|max:9999',
        ]);

        \DB::table('PRODUCTOS')->insert([
            'Cod_cat' => $request->Cod_cat,
            'Nombre' => $request->Nombre,
            'Descripcion' => $request->Descripcion,
            'PRECIO' => $request->PRECIO,
        ]);

        return response()->json(['success' => true]);
    }

    public function actualizarPrecio(Request $request, $id)
    {
        $request->validate([
            'precio' => 'required|integer|min:0|max:9999'
        ]);

        \DB::table('PRODUCTOS')->where('id_prod', $id)->update([
            'PRECIO' => $request->precio
        ]);

        return response()->json(['success' => true]);
    }
}