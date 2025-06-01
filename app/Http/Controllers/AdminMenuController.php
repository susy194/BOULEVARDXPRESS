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

    public function eliminarProducto($id)
    {
        try {
            // ELIMINACION PEDIDOS_PRODUCTOS
            \DB::table('PEDIDOS_PRODUCTOS')->where('id_prod', $id)->delete();

            // ELIMINAR - PEDIDOS PRODUCTOS.
            \DB::table('PRODUCTOS')->where('id_prod', $id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
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