<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminUsuariosController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('Usuarios_Sistema')
            ->join('EMPLEADO', 'Usuarios_Sistema.ID_emp', '=', 'EMPLEADO.ID_emp')
            ->join('Tipo_US', 'Usuarios_Sistema.ID_Tipo', '=', 'Tipo_US.ID_Tipo')
            ->select('Usuarios_Sistema.*', 'EMPLEADO.nombre_emp', 'Tipo_US.Tipo_Us as rol')
            ->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    public function desbloquearUsuarios()
    {
        $usuarios = DB::table('Usuarios_Sistema')
            ->join('EMPLEADO', 'Usuarios_Sistema.ID_emp', '=', 'EMPLEADO.ID_emp')
            ->join('Tipo_US', 'Usuarios_Sistema.ID_Tipo', '=', 'Tipo_US.ID_Tipo')
            ->select('Usuarios_Sistema.*', 'EMPLEADO.nombre_emp', 'Tipo_US.Tipo_Us as rol')
            ->get();

        return view('admin.desbloquear-usuarios', compact('usuarios'));
    }

    public function toggleBloqueo(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string'
        ]);

        $usuario = DB::table('Usuarios_Sistema')
            ->join('Tipo_US', 'Usuarios_Sistema.ID_Tipo', '=', 'Tipo_US.ID_Tipo')
            ->where('Usuarios_Sistema.usuario', $request->usuario)
            ->select('Usuarios_Sistema.*', 'Tipo_US.Tipo_Us as rol')
            ->first();

        if (!$usuario) {
            return response()->json([
                'ok' => false,
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        // Verificar si es administrador
        if ($usuario->rol === 'Administrador') {
            return response()->json([
                'ok' => false,
                'error' => 'No se puede bloquear a un administrador'
            ], 403);
        }

        // Cambiar el estado de bloqueo
        $nuevoEstado = !$usuario->bloqueado;

        DB::table('Usuarios_Sistema')
            ->where('usuario', $request->usuario)
            ->update([
                'bloqueado' => $nuevoEstado,
                'intentos_fallidos' => 0 // Reiniciar intentos fallidos
            ]);

        return response()->json([
            'ok' => true,
            'bloqueado' => $nuevoEstado
        ]);
    }

    public function create()
    {
        $tipos = DB::table('Tipo_US')->get();
        return view('admin-usuarios-agregar', compact('tipos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_emp' => 'required|string|max:100',
                'Direccion' => 'required|string|max:200',
                'TELEFONO' => 'required|numeric|digits_between:1,11',
                'ID_Tipo' => 'required|exists:Tipo_US,ID_Tipo',
                'usuario' => 'required|string|max:16',
                'password' => 'required|string|max:12'
            ]);

            DB::beginTransaction();

            // Insertar en EMPLEADO
            $empleado = DB::table('EMPLEADO')->insertGetId([
                'nombre_emp' => $request->nombre_emp,
                'Direccion' => $request->Direccion,
                'TELEFONO' => $request->TELEFONO,
                'Foto' => null
            ]);

            // Insertar en Usuarios_Sistema
            DB::table('Usuarios_Sistema')->insert([
                'ID_Tipo' => $request->ID_Tipo,
                'ID_emp' => $empleado,
                'usuario' => $request->usuario,
                'password' => $request->password,
                'bloqueado' => false
            ]);

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarUsuario($id)
    {
        try {
            // Eliminación en Usuarios_Sistema
            \DB::table('Usuarios_Sistema')->where('ID_emp', $id)->delete();

            // Eliminación en empleado
            \DB::table('EMPLEADO')->where('ID_emp', $id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}