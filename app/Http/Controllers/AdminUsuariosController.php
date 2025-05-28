<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUsuariosController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('EMPLEADO')
            ->join('Usuarios_Sistema', 'EMPLEADO.ID_emp', '=', 'Usuarios_Sistema.ID_emp')
            ->join('Tipo_US', 'Usuarios_Sistema.ID_Tipo', '=', 'Tipo_US.ID_Tipo')
            ->whereIn('Tipo_US.Tipo_Us', ['Mesero', 'Chef'])
            ->select('EMPLEADO.*', 'Tipo_US.Tipo_Us', 'Usuarios_Sistema.Usuario')
            ->get();
        return view('admin-usuarios', compact('usuarios'));
    }
}