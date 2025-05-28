@extends('layouts.base')

<!-- CSRF Token para AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <br><br><br><br>
    <h2 class="title is-1">Agregar productos-Categorías de Mesa #{{ $Num_m }}</h2>
    <div class="has-text-left mb-4">
      <a href="{{ $ref }}" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Cancelar</span>
      </a>
    </div>
    <div class="columns">
        <!-- CATEGORÍAS -->
        <div class="column is-two-thirds">
            <div class="box div-perso">
                <div class="content">
                    <div class="columns is-multiline">
                        @foreach ($categorias as $categoria)
                            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                                <div class="box has-text-centered">
                                    <span class="icon is-large mb-2">
                                        <i class="fa-solid fa-utensils fa-2x"></i>
                                    </span>
                                    <h5 class="title is-4">{{ $categoria->Categoria }}</h5>
                                    <a href="{{ url($goto . '/' . $categoria->Cod_cat) }}" class="button is-info is-fullwidth mt-3">
                                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver productos
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- COMANDA -->
        <div class="column is-one-third">
            <div class="box div-perso">
                <h3 class="title is-4">Resumen del pedido</h3>
                <div class="box bg-soft" style="height: 300px; overflow-y: auto;">
                    <div id="resumen-pedido">
                        @php
                            $pedido = App\Models\Pedido::where('Num_m', $Num_m)
                                ->where('Estado', 'Pendiente')
                                ->first();
                            $productosPedidos = $pedido
                                ? App\Models\PedidoProductos::with('productos')->where('id_pedido', $pedido->id_pedido)->get()
                                : collect();
                        @endphp

                        @if($pedido && $productosPedidos->count())
                            <p><strong>Comanda #{{ $pedido->id_pedido }}</strong></p>
                            <ul>
                                @foreach($productosPedidos as $productoPedido)
                                    <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;" data-id-pedido="{{ $productoPedido->id_pedido }}" data-id-prod="{{ $productoPedido->id_prod }}">
                                        <span>
                                            {{ $productoPedido->cant_prod }} × {{ $productoPedido->productos->Nombre }}
                                            @if($productoPedido->Nota_prod)
                                                <em>({{ $productoPedido->Nota_prod }})</em>
                                            @endif
                                        </span>
                                        <button class="button is-small is-danger ml-2" onclick="confirmarEliminarProducto({{ $productoPedido->id_pedido }}, {{ $productoPedido->id_prod }})">
                                            <span class="icon"><i class="fas fa-minus"></i></span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay productos en el pedido actual.</p>
                        @endif
                    </div>
                </div>
                <button class="button is-warning is-fullwidth is-large mt-4" onclick="enviarPedido()">
                    Enviar Pedido&nbsp;<i class="fa-regular fa-file-lines"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- PRODUCTOS POR CATEGORÍA -->
    @foreach ($categorias as $categoria)
        <div class="categoria-productos mt-4" id="cat-{{ $categoria->Cod_cat }}" style="display: none;">
            <h3 class="subtitle is-6 mb-3">Productos | {{ $categoria->Cod_cat }}</h3>
            <div class="columns is-multiline">
                @foreach ( $categoria->productos as $producto )
                    <div class="column is-4-desktop is-6-tablet is-12-mobile">
                        <div class="box">
                            <div class="has-text-right">
                                <span class="tag is-success is-medium">
                                    ${{ number_format($producto->PRECIO, 2) }}
                                </span>
                            </div>
                            <h5 class="title is-5">
                                <i class="fa-solid fa-utensils"></i> {{ $producto->Nombre }}
                            </h5>
                            <p class="subtitle is-6">{{ $producto->Descripcion }}</p>
                            <button class="button is-success color-button is-fullwidth">
                                <i class="fa-solid fa-plus"></i>&nbsp;Agregar al Pedido
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- JS para mostrar productos según categoría -->
    <script>
        function mostrarProductos(codigo) {
            document.querySelectorAll('.categoria-productos').forEach(div => div.style.display = 'none');
            document.getElementById('cat-' + codigo).style.display = 'block';
        }
    </script>

    <script>
        // Función para cargar el resumen del pedido
        async function cargarResumenPedido() {
            try {
                const response = await fetch('/ver-mesa/{{ $Num_m }}');
                if (response.ok) {
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const comanda = doc.querySelector('#comanda');

                    if (comanda) {
                        document.getElementById('resumen-pedido').innerHTML = comanda.innerHTML;
                    }
                }
            } catch (error) {
                console.error('Error al cargar el resumen:', error);
            }
        }

        // Cargar el resumen inicial
        cargarResumenPedido();

        // Recargar el resumen cada 5 segundos
        setInterval(cargarResumenPedido, 5000);

        // Función para enviar el pedido
        function enviarPedido() {
            window.location.href = '/ver-mesa/{{ $Num_m }}';
        }
    </script>

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
        let idPedidoEliminar = 0;
        let idProdEliminar = 0;

        function confirmarEliminarProducto(idPedido, idProd) {
          document.getElementById('modal-eliminar-producto').classList.add('is-active');
          idPedidoEliminar = idPedido;
          idProdEliminar = idProd;
        }

        function cerrarModalEliminarProducto() {
          document.getElementById('modal-eliminar-producto').classList.remove('is-active');
        }

        async function eliminarProducto() {
          if (idPedidoEliminar == 0 || idProdEliminar == 0) return;

          try {
            const response = await fetch(`/eliminar-pedido/{{ $Num_m }}`, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
              },
              body: JSON.stringify({
                id_pedido: idPedidoEliminar,
                id_prod: idProdEliminar
              })
            });

            if (response.ok) {
              // Eliminar el elemento del DOM
              const li = document.querySelector(`[data-id-pedido="${idPedidoEliminar}"][data-id-prod="${idProdEliminar}"]`);
              if (li) li.remove();

              // Verificar si quedan productos
              const ul = document.querySelector('#resumen-pedido ul');
              if (ul && !ul.querySelector('li')) {
                ul.innerHTML = '<li>No hay productos en el pedido actual.</li>';
              }

              cerrarModalEliminarProducto();
              cargarResumenPedido();
            } else {
              const error = await response.text();
              alert('Error al eliminar el producto: ' + error);
            }
          } catch (error) {
            alert('Error al eliminar el producto: ' + error.message);
          }
        }
    </script>
@endsection
