<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .mesa-header {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .pedido-header {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 10px;
            margin-top: 10px;
        }
        .total-mesa {
            text-align: right;
            font-weight: bold;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .total-pedido {
            text-align: right;
            font-weight: bold;
            padding: 10px;
            background-color: #e9ecef;
        }
        .gran-total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Ventas - Fuente del Boulevard</div>
        <div class="subtitle">Ventas del día: {{ $fecha }}</div>
    </div>

    @foreach($ventasPorMesa as $mesa => $productos)
        <h3>Mesa {{ $mesa }}</h3>
        @php
            $pedidosMesa = $productos->groupBy('id_pedido');
        @endphp

        @foreach($pedidosMesa as $pedidoId => $productosPedido)
            @php
                $primerProducto = $productosPedido->first();
                $totalPedido = $productosPedido->sum('subtotal');
            @endphp
            <div class="pedido-header">
                Pedido #{{ $pedidoId }} - Mesero: {{ $primerProducto->nombre_emp }} - Hora: {{ $primerProducto->Hora }}
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosPedido as $producto)
                        <tr>
                            <td>{{ $producto->Nombre }}</td>
                            <td>{{ $producto->cant_prod }}</td>
                            <td>${{ number_format($producto->PRECIO, 2) }}</td>
                            <td>${{ number_format($producto->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total-pedido">
                Total Pedido #{{ $pedidoId }}: ${{ number_format($totalPedido, 2) }}
            </div>
        @endforeach
        <div class="total-mesa">
            Total Mesa {{ $mesa }}: ${{ number_format($totalesPorMesa[$mesa], 2) }}
        </div>
    @endforeach

    <div class="gran-total">
        Gran Total: ${{ number_format($granTotal, 2) }}
    </div>
</body>
</html>