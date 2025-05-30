@extends('layouts.base')

@section('content')
<div class="section">
  <h2 class="title is-3 mb-4">
        <i class="fa-solid fa-receipt"></i> Cerrar cuenta - mesa #{{ $num_mesa }}
    </h2>
  <a href="/ver-mesa/{{ $num_mesa }}" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Volver a mesas</span>
    </a>

  <div class="container">
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
            <button class="button is-info is-medium">
              <span class="icon"><i class="fas fa-print"></i></span>
              <span>Imprimir cuenta</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
