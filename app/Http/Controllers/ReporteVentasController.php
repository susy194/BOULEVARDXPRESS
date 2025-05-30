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
            ->whereDate('p.Fecha', now())
            ->where('p.Estado', 'Completado')
            ->select(
                'p.Num_m',
                'p.id_pedido',
                'prod.Nombre',
                'prod.PRECIO',
                'pp.cant_prod',
                DB::raw('prod.PRECIO * pp.cant_prod as subtotal')
            )
            ->orderBy('p.Num_m')
            ->get();

        // Agrupar ventas por mesa
        $ventasPorMesa = $ventas->groupBy('Num_m');

        // Calcular totales
        $totalesPorMesa = [];
        $granTotal = 0;

        foreach ($ventasPorMesa as $mesa => $productos) {
            $totalMesa = $productos->sum('subtotal');
            $totalesPorMesa[$mesa] = $totalMesa;
            $granTotal += $totalMesa;
        }

        // Generar el PDF
        $pdf = PDF::loadView('reporte-ventas-pdf', [
            'fecha' => $fecha,
            'ventasPorMesa' => $ventasPorMesa,
            'totalesPorMesa' => $totalesPorMesa,
            'granTotal' => $granTotal
        ]);

        // Descargar el PDF
        return $pdf->download('reporte-ventas-' . now()->format('Y-m-d') . '.pdf');
    }
}