@extends('layouts.base')

@section('content')

<div class="section">
  <div class="container">
    <div class="columns is-vcentered">

      <!-- Columna izquierda -->
      <div class="column is-one-quarter">
        <!-- Botón regresar -->
        <a href="/home-mesero" class="icon-button mb-4" title="Regresar a sección de mesas">
          <span class="icon is-large">
            <i class="fas fa-arrow-left fa-1.5x"></i>
          </span>
        </a>

        <!-- Select de mesas -->
        <div class="field mt-4">
          <label class="label is-size-3">Mesa #{{ $Num_m }}</label>
        </div>

        <!-- Botones -->
        <a href="/categorias2/{{ $Num_m }}" class="button is-warning is-fullwidth mb-2 is-large" title="Agregar productos al pedido">
          Agregar producto&nbsp;<i class="fas fa-plus"></i>
        </button>

        <a href="/cerrar-cuenta/{{ $Num_m }}" class="button is-warning is-fullwidth is-large" title="Cerrar cuenta-Ver detalles de la cuenta">
          Cerrar Cuenta&nbsp;<i class="fas fa-cash-register"></i>
        </a>
      </div>

      <!-- Columna derecha -->
      <div class="column">
        <div class="comanda-box">
          <h2 class="title is-3">Resumen de Pedidos</h2>

          <meta name="csrf-token" content="{{ csrf_token() }}">

          <!-- Comanda -->
          <div class="box" id="comanda">
            <p><strong>Comanda #{{ $pedido->id_pedido ?? 'N/A' }}</strong></p>
            <ul>
              @forelse($productosPedidos as $productoPedido)
              <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;" data-id="{{ $productoPedido->id_pedido }}">
                  <span>
                    <span class="status-{{ $pedido->Estado ?? 'pendiente' }}">{{ $pedido->Estado }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    {{ $productoPedido->cant_prod }} × {{ $productoPedido->Nombre }}
                      - <em>{{ $productoPedido->getNombre() }}</em> @if( $productoPedido->Nota_prod )<em>({{ $productoPedido->Nota_prod }})</em>@endif
                  </span>
                  <button class="button is-small is-danger ml-2" onclick="confirmarEliminarProducto({{ $productoPedido->id_pedido }}, {{ $productoPedido->id_prod }})">
                    <span class="icon"><i class="fas fa-minus"></i></span>
                  </button>
                </li>
              @empty
                <li>No hay productos en el pedido actual.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal de confirmación para eliminar producto -->
<div class="modal" id="modal-eliminar-producto">
  <div class="modal-background" onclick="cerrarModalEliminarProducto()"></div>
  <div class="modal-card">
    <header class="modal-card-head has-background-warning">
      <p class="modal-card-title has-text-weight-bold">Confirmar eliminación</p>
      <button class="delete" aria-label="close" onclick="cerrarModalEliminarProducto()"></button>
    </header>
    <section class="modal-card-body">
      <p>¿Estás seguro de eliminar el producto del cliente?</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
      <button type="submit" class="button is-danger" onclick="eliminarProducto()">Aceptar</button>
      <button class="button" onclick="elimincerrarModalEliminarProductoarProducto()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
  let productoEliminar = 0;

  function confirmarEliminarProducto(idPedido, idProd) {
    // const form = document.getElementById('form-eliminar-producto');
    // form.action = `/pedido/${idPedido}/producto/${idProd}`;
    document.getElementById('modal-eliminar-producto').classList.add('is-active');
    productoEliminar = idPedido;
  }
  function cerrarModalEliminarProducto() {
    document.getElementById('modal-eliminar-producto').classList.remove('is-active');
  }

  async function eliminarProducto() {
    if (  productoEliminar == 0 ) {
      return;
    }

    const response = await fetch(`/eliminar-pedido/{{ $Num_m }}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        id_pedido: productoEliminar
      })
    });

    const li = document.querySelector(`[data-id="${productoEliminar}"]`);
    li.remove();
    productoEliminar = 0;

    const comanda_length = document.getElementById('comanda').querySelectorAll('li').length;
    const comanda_ul = document.getElementById('comanda').querySelector('ul');

    if ( comanda_length == 0 ) {
      comanda_ul.innerHTML = '<li>No hay productos en el pedido actual.</li>';
    }
  }
</script>
@endsection
