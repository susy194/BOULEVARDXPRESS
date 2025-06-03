<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReporteVentasController extends Controller
{
    public function generarPDF()
    {
        // Obtener la fecha actual
        $fecha = now()->format('d/m/Y');

        // Consulta para obtener las ventas del día
        $ventas = DB::table('PEDIDOS as p')
            ->join('PEDIDOS_PRODUCTOS as pp', 'p.id_pedido', '=', 'pp.id_pedido')
            ->join('PRODUCTOS as prod', 'pp.id_prod', '=', 'prod.id_prod')
            ->join('EMPLEADO as emp', 'p.ID_emp', '=', 'emp.ID_emp')
            ->whereDate('p.Fecha', now())
            ->where('p.Estado', 'Completado')
            ->select(
                'p.Num_m',
                'p.id_pedido',
                'p.Hora',
                'emp.nombre_emp',
                'prod.Nombre',
                'prod.PRECIO',
                'pp.cant_prod',
                DB::raw('prod.PRECIO * pp.cant_prod as subtotal')
            )
            ->orderBy('p.Num_m')
            ->orderBy('p.id_pedido')
            ->get();

        // Agrupar ventas por mesa y pedido
        $ventasPorMesa = $ventas->groupBy('Num_m');
        $ventasPorPedido = $ventas->groupBy('id_pedido');

        // Calcular totales
        $totalesPorMesa = [];
        $totalesPorPedido = [];
        $granTotal = 0;

        foreach ($ventasPorMesa as $mesa => $productos) {
            $totalMesa = $productos->sum('subtotal');
            $totalesPorMesa[$mesa] = $totalMesa;
            $granTotal += $totalMesa;
        }

        foreach ($ventasPorPedido as $pedido => $productos) {
            $totalPedido = $productos->sum('subtotal');
            $totalesPorPedido[$pedido] = $totalPedido;
        }

        $pdf = PDF::loadView('reporte-ventas-pdf', [
            'fecha' => $fecha,
            'ventasPorMesa' => $ventasPorMesa,
            'ventasPorPedido' => $ventasPorPedido,
            'totalesPorMesa' => $totalesPorMesa,
            'totalesPorPedido' => $totalesPorPedido,
            'granTotal' => $granTotal
        ]);

        return $pdf->download('reporte-ventas-' . now()->format('Y-m-d') . '.pdf');
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
}