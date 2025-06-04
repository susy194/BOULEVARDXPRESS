<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\GetMesas;
use PDF;

class CerrarCuentaController extends Controller
{
    public function cerrarCuenta($num_mesa)
    {
        $pedido = DB::table('PEDIDOS')
            ->where('Num_m', $num_mesa)
            ->where('Estado', 'Pendiente')
            ->orderByDesc('id_pedido')
            ->first();

        $productos = [];
        $total = 0;

        if ($pedido) {
            $productos = DB::table('PEDIDOS_PRODUCTOS as pp')
                ->join('PRODUCTOS as p', 'pp.id_prod', '=', 'p.id_prod')
                ->where('pp.id_pedido', $pedido->id_pedido)
                ->select('p.Nombre', 'p.PRECIO', 'pp.cant_prod', DB::raw('(p.PRECIO * pp.cant_prod) as importe'))
                ->get();

            $total = $productos->sum('importe');
        }

        event( new GetMesas([
            "Num_m"       => $num_mesa,
            "id_pedido"   => null,
            "id_prod"     => null,
            "producto"    => null,
            "cantidad"    => null,
            "nota"        => null,
            "estado"      => "Completado"
        ]));

        return view('cerrar-cuenta', [
            'num_mesa' => $num_mesa,
            'productos' => $productos,
            'total' => $total
        ]);
    }

    public function generarPDF($num_mesa)
    {
        $pedido = DB::table('PEDIDOS')
            ->where('Num_m', $num_mesa)
            ->where('Estado', 'Pendiente')
            ->orderByDesc('id_pedido')
            ->first();

        if (!$pedido) {
            return redirect()->back()->with('error', 'No hay pedido pendiente para esta mesa.');
        }

        // PRODUCTOS DEL PEDIDO
        $productos = DB::table('PEDIDOS_PRODUCTOS as pp')
            ->join('PRODUCTOS as p', 'pp.id_prod', '=', 'p.id_prod')
            ->where('pp.id_pedido', $pedido->id_pedido)
            ->select('p.Nombre', 'p.PRECIO', 'pp.cant_prod', DB::raw('(p.PRECIO * pp.cant_prod) as importe'))
            ->get();

        $total = $productos->sum('importe');

        //ACTUALIZACION DE PEDIDOS A  'Completado'
        DB::table('PEDIDOS')
            ->where('id_pedido', $pedido->id_pedido)
            ->update(['Estado' => 'Completado']);

        // INSERT EN TABLA CUENTA
        $num_cuenta = DB::table('CUENTA')->insertGetId([
            'id_pedido' => $pedido->id_pedido
        ]);

        // ACTUALIZACION DE MESA EN (0)
        DB::table('MESA')
            ->where('Num_m', $num_mesa)
            ->update(['Estado' => 0]);

        // CONTENIDO DEL PDF
        $html = '
        <html>
        <head>
            <meta charset="utf-8">
            <title>Cuenta</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
                .header { text-align: center; margin-bottom: 20px; }
                .restaurant-name { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
                .address { font-size: 12px; margin-bottom: 20px; }
                .info { display: flex; justify-content: space-between; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f5f5f5; }
                .total { text-align: right; font-weight: bold; margin-top: 20px; }
                .payment { margin-top: 20px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="restaurant-name">* * * F-U-E-N-T-E  D-E-L  B-O-U-L-E-V-A-R-D * * *</div>
                <div class="address">Carretera a Querétaro, Adolfo López Mateos, 76750 Tequisquiapan, Qro.</div>
            </div>

            <div class="info">
                <div>No. Cuenta: ' . $num_cuenta . '</div>
                <div>Fecha: ' . now()->format('d/m/Y') . '</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($productos as $producto) {
            $html .= '
                <tr>
                    <td>' . $producto->Nombre . '</td>
                    <td>' . $producto->cant_prod . '</td>
                    <td>$' . number_format($producto->PRECIO, 2) . '</td>
                    <td>$' . number_format($producto->importe, 2) . '</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>

            <div class="total">
                Total: $' . number_format($total, 2) . '
            </div>

            <div class="payment">
                Pago: Efectivo
            </div>
        </body>
        </html>';


        $pdf = PDF::loadHTML($html);


        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }


        $pdfPath = $tempDir . '/cuenta-' . $num_cuenta . '.pdf';
        $pdf->save($pdfPath);

        return view('download-redirect', [
            'pdfPath' => url('storage/app/temp/cuenta-' . $num_cuenta . '.pdf')
        ]);
    }
}