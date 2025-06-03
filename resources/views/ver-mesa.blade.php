@extends('layouts.base')

@section('content')
@vite('resources/js/app.js')
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
            <p><strong>Pedido #{{ $pedido->id_pedido ?? 'N/A' }}</strong></p>
            <ul>


              @forelse($pedido->pedidoProductos as $productoPedido)
              <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;" data-id-pedido="{{ $productoPedido->id_pedido }}" data-id-prod="{{ $productoPedido->id_prod }}">
                  <span>
                    <span class=status-{{ $productoPedido->Estado_prod ?? 'pendiente' }}>{{ $productoPedido->Estado_prod }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    {{ $productoPedido->cant_prod }} × {{ $productoPedido->Nombre }}
                      - <em>{{ $productoPedido->getNombre() }}</em> @if( $productoPedido->Nota_prod )<em>({{ $productoPedido->Nota_prod }})</em>@endif
                  </span>
                  <div class="buttons">
                    <button class="button is-small is-info ml-2" onclick="editarProducto({{ $productoPedido->id_pedido }}, {{ $productoPedido->id_prod }}, {{ $productoPedido->cant_prod }}, '{{ $productoPedido->Nota_prod }}')">
                      <span class="icon"><i class="fas fa-edit"></i></span>
                    </button>
                    <button class="button is-small is-danger ml-2" onclick="confirmarEliminarProducto({{ $productoPedido->id_pedido }}, {{ $productoPedido->id_prod }})">
                      <span class="icon"><i class="fas fa-minus"></i></span>
                    </button>
                  </div>
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

<!-- Modal de edición de producto -->
<div class="modal" id="modal-editar-producto">
  <div class="modal-background" onclick="cerrarModalEditarProducto()"></div>
  <div class="modal-card">
    <header class="modal-card-head has-background-info">
      <p class="modal-card-title has-text-white">Editar Producto</p>
      <button class="delete" aria-label="close" onclick="cerrarModalEditarProducto()"></button>
    </header>
    <section class="modal-card-body">
      <div class="field">
        <label class="label">Cantidad</label>
        <div class="control has-addons">
          <button class="button" onclick="cambiarCantidadEdicion(-1)">-</button>
          <input class="input" type="number" id="editar-cantidad" value="1" min="1" style="width: 60px; text-align: center;">
          <button class="button" onclick="cambiarCantidadEdicion(1)">+</button>
        </div>
      </div>
      <div class="field mt-3">
        <label class="label">Notas</label>
        <div class="control">
          <input class="input" type="text" id="editar-notas" placeholder="Notas para la cocina (opcional)">
        </div>
      </div>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
      <button class="button is-info" onclick="guardarEdicion()">Guardar Cambios</button>
      <button class="button" onclick="cerrarModalEditarProducto()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
  let productoEliminar = {
    id_pedido: 0,
    id_prod: 0
  };

  // Escuchar eventos de actualización de estado
  document.addEventListener('DOMContentLoaded', function() {
    console.log('Iniciando escucha de eventos...');

    window.Echo.private('user.Mesero')
      .listen('.ProductoEntregado', (e) => {
        console.log('Evento recibido:', e);

        const li = document.querySelector(`[data-id-pedido="${e.id_pedido}"][data-id-prod="${e.id_prod}"]`);
        console.log('Elemento encontrado:', li);

        if (li) {
          // Remover la clase de estado anterior
          const oldStatusSpan = li.querySelector('[class^="status-"]');
          if (oldStatusSpan) {
            oldStatusSpan.remove();
          }

          // Crear y agregar el nuevo span de estado
          const statusSpan = document.createElement('span');
          statusSpan.className = `status-${e.estado}`;
          statusSpan.textContent = e.estado + '     ';
          statusSpan.style.color = e.estado === 'entregado' ? '#4caf50' : '#ff9800';

          // Insertar el nuevo span al inicio del contenido
          const contentSpan = li.querySelector('span');
          contentSpan.insertBefore(statusSpan, contentSpan.firstChild);

          // Agregar una animación suave
          li.style.transition = 'all 0.3s ease';
          li.style.backgroundColor = e.estado === 'entregado' ? '#f0fff0' : '#fff';
        }
      });
  });

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

  let idPedidoEditar = 0;
  let idProdEditar = 0;

  function editarProducto(idPedido, idProd, cantidad, notas) {
    idPedidoEditar = idPedido;
    idProdEditar = idProd;
    document.getElementById('editar-cantidad').value = cantidad;
    document.getElementById('editar-notas').value = notas || '';
    document.getElementById('modal-editar-producto').classList.add('is-active');
  }

  function cerrarModalEditarProducto() {
    document.getElementById('modal-editar-producto').classList.remove('is-active');
  }

  function cambiarCantidadEdicion(delta) {
    const input = document.getElementById('editar-cantidad');
    const nuevaCantidad = parseInt(input.value) + delta;
    if (nuevaCantidad >= 1) {
      input.value = nuevaCantidad;
    }
  }

  async function guardarEdicion() {
    if (idPedidoEditar === 0 || idProdEditar === 0) return;

    const cantidad = parseInt(document.getElementById('editar-cantidad').value);
    const notas = document.getElementById('editar-notas').value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
      const response = await fetch('/editar-producto', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          id_pedido: idPedidoEditar,
          id_prod: idProdEditar,
          cantidad: cantidad,
          notas: notas
        })
      });

      if (response.ok) {
        cerrarModalEditarProducto();
        window.location.reload();
      } else {
        const error = await response.json();
        alert('Error al editar el producto: ' + (error.error || 'Error desconocido'));
      }
    } catch (error) {
      alert('Error al editar el producto: ' + error.message);
    }
  }
</script>
@endsection
