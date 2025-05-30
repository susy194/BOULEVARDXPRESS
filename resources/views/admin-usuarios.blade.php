@extends('layouts.base')

@section('content')
<div class="section">
   <h2 class="title is-2 has-text-weight-bold mb-5">
             <i class="fa-solid fa-users"></i>Administrar Usuarios
        </h2>
    <div class="container">
        <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <a href="{{ route('home-admin') }}"class="button is-light is-medium mb-4">
              <span class="icon is-medium"><i class="fas fa-arrow-left fa-lg"></i></span>
              <span class="has-text-weight-semibold">Volver al Panel de Administrador</span>
           </a>
            <a href="{{ route('admin.usuarios.agregar') }}" class="button is-success is-medium mb-4" style="background-color: #ff5e9c; color: white;">
              <span class="icon is-medium"><i class="fas fa-plus"></i></span>
              <span>Agregar usuario</span>
            </a>
        </div>

        <div class="columns is-multiline">
            @foreach($usuarios as $usuario)
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box usuario-box" style="position:relative;" data-id="{{ $usuario->ID_emp }}">
                    <div class="is-flex is-align-items-center mb-3" style="gap: 1rem;">
                        <figure class="image is-64x64" style="flex-shrink:0;">
                            @if($usuario->Foto)
                                <img class="is-rounded" src="data:image/jpeg;base64,{{ base64_encode($usuario->Foto) }}" alt="Foto de {{ $usuario->nombre_emp }}">
                            @else
                                <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre_emp) }}&background=ff5e9c&color=fff" alt="Foto de {{ $usuario->nombre_emp }}">
                            @endif
                        </figure>
                        <h2 class="title is-4 has-text-weight-bold mb-0" style="flex:1;">{{ $usuario->nombre_emp }}</h2>
                        <button class="button is-danger" style="background-color: #ff5e9c; border: none;" onclick="confirmarEliminarUsuario({{ $usuario->ID_emp }}, this.closest('.usuario-box'))">
                            <span class="icon"><i class="fas fa-minus"></i></span>
                        </button>
                    </div>
                    <div class="content ml-2">
                        <p class="is-size-5"><strong>Dirección:</strong> {{ $usuario->Direccion }}</p>
                        <p class="is-size-5"><strong>Teléfono:</strong> {{ $usuario->TELEFONO }}</p>
                        <p class="is-size-5"><strong>Tipo de usuario:</strong> {{ $usuario->Tipo_Us }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar usuario -->
<div class="modal" id="modal-eliminar-usuario">
  <div class="modal-background" onclick="cerrarModalEliminarUsuario()"></div>
  <div class="modal-card" style="width: 700px; max-height: 80vh;">
    <header class="modal-card-head" style="background-color: #ff5e9c; color: white;">
      <p class="modal-card-title has-text-weight-bold" style="font-size: 1.6rem;">Confirmar eliminación</p>
      <button class="delete" aria-label="close" onclick="cerrarModalEliminarUsuario()"></button>
    </header>
    <section class="modal-card-body">
      <p style="font-size: 1.6rem;">¿Estás seguro de eliminar al usuario?</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end; gap: 1rem;">
      <button type="button" class="button is-danger is-medium" style="background-color: #ff5e9c; color: white;" onclick="eliminarUsuario()">Aceptar</button>
      <button class="button is-medium" onclick="cerrarModalEliminarUsuario()">Cancelar</button>
    </footer>
  </div>
</div>

<!-- Modal de éxito para eliminar usuario -->
<div class="modal" id="modal-exito-eliminar">
  <div class="modal-background" onclick="cerrarModalExitoEliminar()"></div>
  <div class="modal-card" style="width: 700px; max-height: 80vh;">
    <header class="modal-card-head" style="background-color: #ff5e9c; color: white;">
      <p class="modal-card-title has-text-weight-bold" style="font-size: 1.6rem;">¡Éxito!</p>
      <button class="delete" aria-label="close" onclick="cerrarModalExitoEliminar()"></button>
    </header>
    <section class="modal-card-body">
      <p style="font-size: 1.6rem;">El usuario se ha eliminado correctamente.</p>
    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end;">
      <button class="button is-success is-medium" style="background-color: #ff5e9c; color: white;" id="btn-aceptar-exito-eliminar">Aceptar</button>
    </footer>
  </div>
</div>

<script>
let usuarioEliminarId = null;
let usuarioEliminarElem = null;

function confirmarEliminarUsuario(id, elem) {
    usuarioEliminarId = id;
    usuarioEliminarElem = elem;
    document.getElementById('modal-eliminar-usuario').classList.add('is-active');
}

function cerrarModalEliminarUsuario() {
    document.getElementById('modal-eliminar-usuario').classList.remove('is-active');
    usuarioEliminarId = null;
    usuarioEliminarElem = null;
}

function cerrarModalExitoEliminar() {
    document.getElementById('modal-exito-eliminar').classList.remove('is-active');
}

async function eliminarUsuario() {
    if (!usuarioEliminarId) return;

    try {
        const response = await fetch(`/admin/usuarios/${usuarioEliminarId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            // Eliminar el elemento del DOM
            if (usuarioEliminarElem && usuarioEliminarElem.parentNode) {
                usuarioEliminarElem.parentNode.remove();
            }

            // Cerrar el modal de confirmación y mostrar el de éxito
            cerrarModalEliminarUsuario();
            document.getElementById('modal-exito-eliminar').classList.add('is-active');
        } else {
            const data = await response.json();
            alert('Error al eliminar el usuario: ' + (data.message || 'Error desconocido'));
        }
    } catch (error) {
        alert('Error al eliminar el usuario: ' + error.message);
    }
}

document.getElementById('btn-aceptar-exito-eliminar').onclick = function() {
    cerrarModalExitoEliminar();
};
</script>
@endsection