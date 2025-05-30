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
              <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;" data-id-pedido="{{ $productoPedido->id_pedido }}" data-id-prod="{{ $productoPedido->id_prod }}">
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
      <button class="button" onclick="cerrarModalEliminarProducto()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
  let productoEliminar = {
    id_pedido: 0,
    id_prod: 0
  };

  function confirmarEliminarProducto(idPedido, idProd) {
    document.getElementById('modal-eliminar-producto').classList.add('is-active');
    productoEliminar.id_pedido = idPedido;
    productoEliminar.id_prod = idProd;
  }

  function cerrarModalEliminarProducto() {
    document.getElementById('modal-eliminar-producto').classList.remove('is-active');
    productoEliminar.id_pedido = 0;
    productoEliminar.id_prod = 0;
  }

  async function eliminarProducto() {
    if (productoEliminar.id_pedido === 0 || productoEliminar.id_prod === 0) {
      alert('Error: No se ha seleccionado un producto para eliminar');
      return;
    }

    try {
      console.log('Enviando datos:', {
        id_pedido: productoEliminar.id_pedido,
        id_prod: productoEliminar.id_prod
      });

    const response = await fetch(`/eliminar-pedido/{{ $Num_m }}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: JSON.stringify({
          id_pedido: productoEliminar.id_pedido,
          id_prod: productoEliminar.id_prod
      })
    });

      const data = await response.json();
      console.log('Respuesta del servidor:', data);

      if (response.ok) {
        // Eliminar el elemento del DOM
        const li = document.querySelector(`[data-id-pedido="${productoEliminar.id_pedido}"][data-id-prod="${productoEliminar.id_prod}"]`);
        if (li) li.remove();

        // Verificar si quedan productos
    const comanda_length = document.getElementById('comanda').querySelectorAll('li').length;
    const comanda_ul = document.getElementById('comanda').querySelector('ul');

        if (comanda_length === 0) {
      comanda_ul.innerHTML = '<li>No hay productos en el pedido actual.</li>';
        }

        cerrarModalEliminarProducto();
      } else {
        alert('Error al eliminar el producto: ' + (data.message || 'Error desconocido'));
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Error al eliminar el producto: ' + error.message);
    }
  }
</script>
@endsection
