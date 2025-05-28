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

        $producto->delete();
        \Log::info('Producto eliminado', ['id' => $id]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Producto eliminado');
    }
}