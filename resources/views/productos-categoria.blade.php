@extends('layouts.base')

@section('content')
    <div class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <a href="{{ url($back) }}" class="button is-light mb-4">
                        <span class="icon">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span>Volver a Categorías</span>
                    </a>
                </div>
            </div>

            <h2 class="title is-5 mb-4">Productos - {{ $categoria->Categoria }}</h2>

            <div class="box div-perso">
                <div class="content">
                    <div class="columns is-multiline">
                        @foreach ($productos as $producto)
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
                                    <button
                                        class="button is-success color-button is-fullwidth"
                                        data-nombre="{{ $producto->Nombre }}"
                                        data-descripcion="{{ $producto->Descripcion }}"
                                        data-precio="{{ $producto->PRECIO }}"
                                        onclick="abrirModalProductoDesdeAtributos(this, {{ $producto->id_prod }})">
                                        <i class="fa-solid fa-plus"></i>&nbsp;Agregar al Pedido
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de producto -->
    <div class="modal" id="modal-producto">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-background" onclick="cerrarModalProducto()"></div>
            <div class="modal-card">
              <header class="modal-card-head has-background-warning" style="justify-content: space-between; align-items: center;">
                <p class="modal-card-title has-text-weight-bold" id="modal-nombre"></p>
                <button class="delete" aria-label="close" onclick="cerrarModalProducto()"></button>
              </header>
              <section class="modal-card-body">
                <p id="modal-descripcion"></p>
                <div class="field mt-4">
                  <label class="label">Cantidad</label>
                  <div class="control has-addons">
                    <button class="button" onclick="cambiarCantidad(-1)">-</button>
                    <input class="input" type="number" id="modal-cantidad" value="1" min="1" style="width: 60px; text-align: center;">
                    <button class="button" onclick="cambiarCantidad(1)">+</button>
                  </div>
                </div>
                <div class="field mt-3">
                  <label class="label">Notas</label>
                  <div class="control">
                    <input class="input" type="text" id="modal-notas" placeholder="Notas para la cocina (opcional)">
                  </div>
                </div>

            </section>
            <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
              <button class="button is-info" onclick="agregarProducto()">Agregar a la Comanda</button>
              <button class="button" onclick="cerrarModalProducto()">Cancelar</button>
            </footer>
      </div>
    </div>


    <script>
      var id_actual = 0;

      function cerrarModalProducto() {
        document.getElementById('modal-producto').classList.remove('is-active');
      }


      function cambiarCantidad(delta) {
        let cantidad = parseInt(document.getElementById('modal-cantidad').value);
        cantidad = isNaN(cantidad) ? 1 : cantidad + delta;
        if (cantidad < 1) cantidad = 1;
        document.getElementById('modal-cantidad').value = cantidad;
      }


      function abrirModalProductoDesdeAtributos(btn, id) {
        document.getElementById('modal-nombre').textContent = btn.getAttribute('data-nombre');
        document.getElementById('modal-descripcion').textContent = btn.getAttribute('data-descripcion');
        document.getElementById('modal-cantidad').value = 1;
        document.getElementById('modal-notas').value = '';
        document.getElementById('modal-producto').classList.add('is-active');
        id_actual = id;
      }


      async function agregarProducto() {
        const cantidad = parseInt(document.getElementById('modal-cantidad').value);
        const notas    = document.getElementById('modal-notas').value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const payload = JSON.stringify({
          producto: id_actual,
          cantidad: cantidad,
          notas   : notas
        });

        try {
          const response = await fetch('/agregar-pedido/' + '{{ $Num_m }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            "X-CSRF-TOKEN": token,
            "Accept": "application/json"
          },
            body: payload
        });

          if (response.ok) {
            // Redirige siempre a la vista de categorías ocupada
            window.location.href = '/categorias2/{{ $Num_m }}';
          } else {
            const errorText = await response.text();
            alert('Error al agregar el producto: ' + errorText);
            return;
          }
        } catch (error) {
          alert('Error de red');
        }
      }
    </script>

@endsection
