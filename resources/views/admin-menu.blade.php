@extends('layouts.base')

@section('content')
<div class="section">
    <div class="container">
        <h2 class="title is-2 mb-4">
             <i class="fa-solid fa-bowl-food"></i> Administración del Menú
        </h2>
     <a href="{{ route('home-admin') }}"class="button is-light is-medium mb-4">
            <span class="icon is-medium"><i class="fas fa-arrow-left fa-lg"></i></span>
            <span class="has-text-weight-semibold">Volver al Panel de Administrador</span>
        </a>
        <a href="{{ route('admin-menu.agregar') }}" class="button is-success is-medium mb-4" style="float:right;">
        <span class="icon is-medium"><i class="fas fa-plus"></i></span>
            <span>Agregar producto</span>
      </a>
        <div style="clear:both"></div>

      @foreach($categorias as $categoria)
            <div class="box mb-5">
                <h2 class="title is-4 mb-3">{{ $categoria->Categoria }}</h2>
                @if($categoria->productos->count() > 0)
                    <div>
                        @foreach($categoria->productos as $producto)
                            <div class="is-flex is-align-items-center is-justify-content-space-between mb-3 producto-row" style="background: #fafbfc; border-radius: 12px; padding: 0.7rem 1.2rem;" data-id="{{ $producto->id_prod }}">
                                <div class="is-flex is-align-items-center" style="gap: 1rem;">
                                    <button class="button is-danger is-rounded" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                        onclick="confirmarEliminarProducto({{ $producto->id_prod }}, this.closest('.producto-row'))">
                                        <span class="icon"><i class="fas fa-minus"></i></span>
                </button>
                                    <span class="is-size-5 has-text-weight-semibold">{{ $producto->Nombre }}</span>
                                </div>
                                <span class="tag is-info is-medium" style="font-size: 1.1rem; min-width: 80px; text-align: right;">
                                    ${{ number_format($producto->PRECIO, 2) }}
                                </span>
                            </div>
                        @endforeach
              </div>
                @else
                    <p class="has-text-grey">No hay productos en esta categoría.</p>
                @endif
        </div>
      @endforeach
    </div>
</div>

<!-- Modal de confirmación para eliminar producto -->
<div class="modal" id="modal-eliminar-producto">
  <div class="modal-background" onclick="cerrarModalEliminarProducto()"></div>
  <div class="modal-card">
    <header class="modal-card-head has-background-danger">
      <p class="modal-card-title has-text-weight-bold">Confirmar eliminación</p>
      <button class="delete" aria-label="close" onclick="cerrarModalEliminarProducto()"></button>
    </header>
    <section class="modal-card-body">
      <p>¿Estás seguro de eliminar este producto del menú?</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
      <button type="button" class="button is-danger" onclick="eliminarProducto()">Eliminar</button>
      <button class="button" onclick="cerrarModalEliminarProducto()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
let productoEliminarId = null;
let productoEliminarElem = null;

function confirmarEliminarProducto(id, elem) {
    productoEliminarId = id;
    productoEliminarElem = elem;
    document.getElementById('modal-eliminar-producto').classList.add('is-active');
}

function cerrarModalEliminarProducto() {
    document.getElementById('modal-eliminar-producto').classList.remove('is-active');
    productoEliminarId = null;
    productoEliminarElem = null;
}

async function eliminarProducto() {
    if (!productoEliminarId) return;
    const token = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
    const response = await fetch(`/admin-menu/producto/${productoEliminarId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    });
    if (response.ok) {
        productoEliminarElem.remove();
        cerrarModalEliminarProducto();
    }
}
</script>
@endsection