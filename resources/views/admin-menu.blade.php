@extends('layouts.base')

@section('content')
<div class="section">
    <div class="container">
        <h2 class="title is-2 mb-4">
             <i class="fa-solid fa-bowl-food"></i>Modificar producto- Administración del Menú
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
                                    <button class="button is-warning is-rounded" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                        onclick="mostrarInputPrecio({{ $producto->id_prod }})">
                                        <span class="icon"><i class="fas fa-dollar-sign"></i></span>
                                    </button>
                                    <span class="is-size-5 has-text-weight-semibold">{{ $producto->Nombre }}</span>
                                </div>
                                <div class="is-flex is-align-items-center" style="gap: 1rem;">
                                    <span class="tag is-info is-medium" style="font-size: 1.1rem; min-width: 80px; text-align: right;" id="precio-prod-{{ $producto->id_prod }}">
                                        ${{ number_format($producto->PRECIO, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="input-precio-row" id="input-precio-row-{{ $producto->id_prod }}" style="display:none; margin-bottom: 1rem;">
                            <input
                                type="number"
                                class="input"
                                id="nuevo-precio-{{ $producto->id_prod }}"
                                placeholder="Nuevo precio"
                                min="0"
                                max="9999"
                                step="1"
                                style="width: 150px; height: 55px; font-size: 1.1rem; margin-right: 0.5rem;">

                            <button
                                class="button is-success"
                                style="height: 65px;"
                                onclick="actualizarPrecio({{ $producto->id_prod }})">
                                Actualizar
                            </button>

                            <button
                                class="button is-danger"
                                style="height: 65px;"
                                onclick="cancelarActualizacionPrecio({{ $producto->id_prod }})">
                                Cancelar
                            </button>
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
  <div class="modal-card" style="width: 700px; max-height: 80vh;">
    <header class="modal-card-head"style="background-color: #49c68f; color: white;">
      <p class="modal-card-title has-text-weight-bold" style="font-size: 1.6rem;">Confirmar eliminación</p>
      <button class="delete" aria-label="close" onclick="cerrarModalEliminarProducto()"></button>
    </header>
    <section class="modal-card-body">
      <p style="font-size: 1.6rem;">¿Estás seguro de eliminar el producto?</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
      <button type="button" class="button is-danger is-medium" style="background-color: #49c68f; color: white;" onclick="eliminarProducto()">Aceptar</button>
      <button class="button is-medium " onclick="cerrarModalEliminarProducto()">Cancelar</button>
    </footer>
  </div>
</div>

<!-- Modal de éxito para eliminar producto -->
<div class="modal" id="modal-exito-eliminar">
  <div class="modal-background" onclick="cerrarModalExitoEliminar()"></div>
  <div class="modal-card" style="width: 700px; max-height: 80vh;">
    <header class="modal-card-head" style="background-color: #49c68f; color: white;">
      <p class="modal-card-title has-text-weight-bold" style="font-size: 1.6rem;">¡Éxito!</p>
      <button class="delete" aria-label="close" onclick="cerrarModalExitoEliminar()"></button>
    </header>
    <section class="modal-card-body">
      <p style="font-size: 1.6rem;">El producto se ha eliminado correctamente.</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end;">
      <button class="button is-success is-medium" style="background-color: #49c68f; color: white;" id="btn-aceptar-exito-eliminar">Aceptar</button>
    </footer>
  </div>
</div>

<!-- Modal de éxito para actualizar precio -->
<div class="modal" id="modal-exito-precio">
  <div class="modal-background" onclick="cerrarModalExitoPrecio()"></div>
  <div class="modal-card" style="width: 700px; max-height: 80vh;">
    <header class="modal-card-head has-background-success">
      <p class="modal-card-title has-text-weight-bold" style="font-size: 1.6rem;">¡Éxito!</p>
      <button class="delete" aria-label="close" onclick="cerrarModalExitoPrecio()"></button>
    </header>
    <section class="modal-card-body">
      <p style="font-size: 1.5rem;">El precio se ha actualizado correctamente.</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end;">
      <button class="button is-success is-medium" id="btn-aceptar-exito-precio">Aceptar</button>
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

function cerrarModalExitoEliminar() {
    document.getElementById('modal-exito-eliminar').classList.remove('is-active');
}

async function eliminarProducto() {
    if (!productoEliminarId) return;

    try {
        const response = await fetch(`/admin-menu/producto/${productoEliminarId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            // Eliminar la fila del producto y su input de precio
            const productoRow = document.querySelector(`.producto-row[data-id="${productoEliminarId}"]`);
            const inputPrecioRow = document.getElementById(`input-precio-row-${productoEliminarId}`);

            if (productoRow && productoRow.parentNode) {
                // Verificar si quedan productos en la categoría antes de eliminar
                const categoriaBox = productoRow.closest('.box');
                if (categoriaBox) {
                    const productosRestantes = categoriaBox.querySelectorAll('.producto-row');
                    if (productosRestantes.length === 1) { // Si solo queda este producto
                        const mensajeNoProductos = document.createElement('p');
                        mensajeNoProductos.className = 'has-text-grey';
                        mensajeNoProductos.textContent = 'No hay productos en esta categoría.';
                        categoriaBox.appendChild(mensajeNoProductos);
                    }
                }
                productoRow.remove();
            }

            if (inputPrecioRow && inputPrecioRow.parentNode) {
                inputPrecioRow.remove();
            }

            // Cerrar el modal de confirmación y mostrar el de éxito
            cerrarModalEliminarProducto();
            document.getElementById('modal-exito-eliminar').classList.add('is-active');
        } else {
            const data = await response.json();
            alert('Error al eliminar el producto: ' + (data.message || 'Error desconocido'));
        }
    } catch (error) {
        alert('Error al eliminar el producto: ' + error.message);
    }
}

function mostrarInputPrecio(id) {
    document.getElementById('input-precio-row-' + id).style.display = 'block';
}

function actualizarPrecio(id) {
    const nuevoPrecio = document.getElementById('nuevo-precio-' + id).value;
    if (nuevoPrecio === '' || isNaN(nuevoPrecio)) {
        alert('Por favor ingresa un precio válido.');
        return;
    }
    fetch(`/admin-menu/producto/${id}/precio`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ precio: parseInt(nuevoPrecio) })
    })
    .then(res => {
        if (!res.ok) {
            alert('Error en la petición: ' + res.status);
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('precio-prod-' + id).innerText = '$' + parseInt(nuevoPrecio).toFixed(2);
            document.getElementById('modal-exito-precio').classList.add('is-active');
            document.getElementById('input-precio-row-' + id).style.display = 'none';
        } else {
            alert('Error al actualizar el precio: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(err => {
        alert('Error en la petición: ' + err);
    });
}

function cerrarModalExitoPrecio() {
    document.getElementById('modal-exito-precio').classList.remove('is-active');
}

document.getElementById('btn-aceptar-exito-eliminar').onclick = function() {
    cerrarModalExitoEliminar();
};

function cancelarActualizacionPrecio(id) {
    document.getElementById('input-precio-row-' + id).style.display = 'none';
}
</script>
@endsection