@extends('layouts.base')

@section('content')
<div class="section">
    <div class="container">
        <h2 class="title is-2 mb-4">
             <i class="fa-solid fa-user-plus"></i>  Agregar Usuario
        </h2>
        <br>
        <a href="{{ url('/admin/usuarios') }}" class="button is-light is-medium mb-4">
            <span class="icon is-medium"><i class="fas fa-arrow-left fa-lg"></i></span>
            <span class="has-text-weight-semibold">Volver a Administración de Usuarios</span>
        </a>

        <div class="box" style="max-width: 600px; margin: 0 auto;">
            <form>
               <div class="field">
                    <label class="label is-large">Nombre</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="nombre_emp" required placeholder="Ingrese el nombre del nuevo usuario">
                        <span class="icon is-left">
                        <i class="fas fa-signature"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label is-large">Dirección</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="Direccion" required placeholder="Ingrese la dirección del nuevo usuario">
                        <span class="icon is-left">
                            <i class="fa-solid fa-map-location"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Teléfono</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="number" name="TELEFONO" required placeholder="Ingrese el número de teléfono del nuevo usuario">
                        <span class="icon is-left">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                    </div>
                </div>
               <div class="field">
                    <label class="label is-large">Tipo de Usuario</label>
                    <div class="control has-icons-left">
                        <div class="select is-fullwidth is-large">
                        <select name="ID_Tipo" required>
                            <option value="">Selecciona un tipo de usuario</option>
                            <option>Administrador</option>
                            <option>Mesero</option>
                            <option>Chef</option>
                        </select>
                        </div>
                        <span class="icon is-left is-large">
                        <i class="fas fa-user-tag"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label is-large">Usuario</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="text" name="Usuario" maxlength="16" required placeholder="Ingrese el usuario">
                        <span class="icon is-left is-large">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Contraseña</label>
                    <div class="control has-icons-left">
                        <input class="input is-large" type="password" name="Contraseña" maxlength="12" required placeholder="Ingrese la contraseña para el usuario">
                        <span class="icon is-left is-large">
                            <i class="fa-solid fa-key"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label is-large">Foto de Usuario</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label is-large">
                            <input class="file-input is-large" type="file" name="Foto" accept="image/*" required>
                            <span class="file-cta">
                                <span class="file-icon"><i class="fas fa-upload"></i></span>
                                <span class="file-label">Seleccionar foto</span>
                            </span>
                            <span class="file-name">Ningún archivo seleccionado</span>
                        </label>
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
@endsection

@push('scripts')
<script>
    // Mostrar el nombre del archivo seleccionado
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function(){
            let fileName = this.files[0]?.name || 'Ningún archivo seleccionado';
            this.closest('.file-label').querySelector('.file-name').textContent = fileName;
        });
    });
</script>
@endpush