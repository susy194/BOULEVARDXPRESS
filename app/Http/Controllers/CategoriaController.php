<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use App\Models\Mesa;

class CategoriaController extends Controller
{
    const OCUPADO = 1;
    const VACIO   = 0;

    public function index($Num_m)
    {
        $mesa = Mesa::find($Num_m);

        if (!$mesa) {
            abort(404, 'Mesa no encontrada');
        }

        if ( $mesa->Estado == self::OCUPADO ) {
            return redirect()->route('home-mesero');
        }

        return view('categorias', [ 'categorias' => Categoria::with('productos')->get(), 'Num_m' => $Num_m ]);
    }


    public function show($Num_m, $id)
    {
        $categoria = Categoria::with('productos')->where('Cod_cat', $id)->firstOrFail();

        return view('productos-categoria', [
            'categoria' => $categoria,
            'productos' => $categoria->productos,
            'Num_m'     => $Num_m
        ]);
    }
}
