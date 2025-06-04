@extends('layouts.base')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/js/app.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notifyjs-browser/dist/notify.js"></script>
@section('content')
<div class="section">
  <h2 class="title is-2 mb-4">
        <i class="fa-solid fa-receipt"></i> Cerrar cuenta - mesa #{{ $num_mesa }}
    </h2>
  <a href="/ver-mesa/{{ $num_mesa }}" class="button is-light is-large">
        <span class="icon is-large"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-3">Volver a mesa #{{ $num_mesa }}</span>
    </a>

  <div class="container">
    <style>
        table th {
          font-size: 1.4rem;
          font-weight: bold;
        }

        table td {
          font-size: 1.2rem;
        }

        tfoot th {
          font-size: 1.4rem;
          font-weight: bold;
        }

        .has-text-grey {
          font-size: 1.2rem;
        }
      </style>
    <div class="columns is-centered">
      <div class="column is-half">

        <div class="box">
          <div class="box" style="min-height: 250px; background: #f5f5f5;">
            @if(count($productos))
              <table class="table is-fullwidth">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($productos as $prod)
                    <tr>
                      <td>{{ $prod->Nombre }}</td>
                      <td>{{ $prod->cant_prod }}</td>
                      <td>${{ number_format($prod->PRECIO, 2) }}</td>
                      <td>${{ number_format($prod->importe, 2) }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="has-text-right">Total:</th>
                    <th>${{ number_format($total, 2) }}</th>
                  </tr>
                </tfoot>
              </table>
            @else
              <span class="has-text-grey">No hay productos en el pedido actual.</span>
            @endif
          </div>
          <div class="has-text-right mt-5">
            <a href="{{ route('cerrar-cuenta.pdf', ['num_mesa' => $num_mesa]) }}" class="button is-info is-medium">
              <span class="icon is-medium"><i class="fas fa-print"></i></span>
              <span>Imprimir cuenta</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
        window.Echo.private('user.Mesero')
            .listen('ProductoEntregado', (e) => {
                const data = e.data;

                const productoElement = document.querySelector(`[data-id-pedido="${data.id_pedido}"][data-id-prod="${data.id_prod}"]`);

                if ( productoElement ) {
                    $.notify(
                        `Producto ${data.nombre} entregado`,
                        "info"
                    );

                    productoElement.querySelector("span>span").innerHTML = "<span class='status-entregado'>entregado&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                    return;
                }

                $.notify(
                    `Producto ${data.nombre} entregado en Mesa #${data.N_mesa}`,
                    "info"
                );
            });
    });
    </script>
