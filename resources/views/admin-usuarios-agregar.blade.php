@extends('layouts.base')

@section('content')
<div class="section">
    <h2 class="title is-2 mb-4">
            <i class="fa-solid fa-user-plus"></i> Agregar Usuario
        </h2>
        <a href="{{ route('admin.usuarios') }}" class="button is-light is-large mb-4">
            <span class="icon is-large"><i class="fas fa-arrow-left fa-lg"></i></span>
            <span class="has-text-weight-semibold">Volver a Administración de Usuarios</span>
        </a>
    <div class="container" style="max-width: 800px;">
        <div class="box">
            <form id="form-agregar-usuario" autocomplete="off">
                @csrf
                <div class="field">
                    <label class="label is-large">Nombre</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="nombre_emp" maxlength="100" required placeholder="Ingrese el nombre del usuario">
                        <span class="icon is-left"><i class="fas fa-signature"></i></span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Dirección</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="Direccion" maxlength="200" required placeholder="Ingrese la dirección del usuario">
                        <span class="icon is-left"><i class="fa-solid fa-map-location"></i></span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Teléfono</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="number" name="TELEFONO" min="0" max="99999999999" required placeholder="Ingrese el teléfono del usuario">
                        <span class="icon is-left"><i class="fa-solid fa-phone"></i></span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Tipo de Usuario</label>
                    <div class="control has-icons-left">
                        <div class="select is-fullwidth is-large">
                            <select name="ID_Tipo" required>
                                <option value="">Selecciona un tipo de usuario</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->ID_Tipo }}">{{ $tipo->Tipo_Us }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="icon is-left is-large"><i class="fas fa-user-tag"></i></span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Usuario</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="usuario" maxlength="16" required placeholder="Ingrese el usuario">
                        <span class="icon is-left is-large"><i class="fas fa-user"></i></span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Contraseña</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="password" name="password" maxlength="12" required placeholder="Ingrese la contraseña para el usuario">
                        <span class="icon is-left is-large"><i class="fa-solid fa-key"></i></span>
                    </div>
                </div>
                <div class="field mt-5">
                    <button type="submit" class="button is-large"
                        style="background: #ff5e9c; color: white; width: 100%; font-size: 1.5rem; padding: 1.25rem 1.5rem;">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal" id="modal-confirmar">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title is-size-4">Confirmar</p>
    </header>
    <section class="modal-card-body is-size-5">
      ¿Estás seguro de agregar el usuario?
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success is-medium" style="background-color: #ff5e9c; color: white;margin-right: 12px;" id="btn-aceptar-confirmar">Aceptar</button>
      <button class="button is-medium" id="btn-cancelar-confirmar">Cancelar</button>
    </footer>
  </div>
</div>


<!-- Modal de éxito -->
<div class="modal" id="modal-exito">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title is-size-4">¡Éxito!</p></header>
        <section class="modal-card-body is-size-5">
            El usuario se ha agregado correctamente.
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" style="background-color: #ff5e9c; color: white;" id="btn-aceptar-exito">Aceptar</button>
        </footer>
    </div>
</div>

<script>
let formData = null;

document.getElementById('form-agregar-usuario').addEventListener('submit', function(e) {
    e.preventDefault();
    formData = new FormData(this);
    document.getElementById('modal-confirmar').classList.add('is-active');
});

document.getElementById('btn-cancelar-confirmar').onclick = function() {
    document.getElementById('modal-confirmar').classList.remove('is-active');
};

document.getElementById('btn-aceptar-confirmar').onclick = function() {
    fetch("{{ route('admin-usuarios.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('modal-confirmar').classList.remove('is-active');
        if (data.success) {
            document.getElementById('modal-exito').classList.add('is-active');
        } else {
            alert('Error al guardar: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(err => {
        alert('Error en la petición: ' + err);
    });
};

document.getElementById('btn-aceptar-exito').onclick = function() {
    window.location.href = "{{ route('admin.usuarios') }}";
};
</script>
@endsection