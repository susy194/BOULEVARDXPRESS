@extends('layouts.base')

@section('content')
@php
// Datos de ejemplo para categorías
$categorias = [
    (object)['Cod_cat' => 1, 'Categoria' => 'Entradas'],
    (object)['Cod_cat' => 2, 'Categoria' => 'Platos Fuertes'],
    (object)['Cod_cat' => 3, 'Categoria' => 'Postres'],
    (object)['Cod_cat' => 4, 'Categoria' => 'Bebidas'],
];
@endphp
<div class="section">
    <h2 class="title is-2 mb-4">
        <i class="fa-solid fa-drumstick-bite"></i> Agregar Producto
    </h2>
    <div class="has-text-left mt-4 mb-5">
        <a href="{{ route('admin.menu') }}" class="button is-large is-light">
            <span class="icon"><i class="fas fa-arrow-left"></i></span>
            <span>Volver a administración de menú</span>
        </a>
    </div>
    <div class="container">
        <div class="column is-half is-offset-one-quarter">
            <div class="box">
                <form id="form-agregar-producto">
                    @csrf
                    <div class="field">
                        <label class="label is-large">Nombre</label>
                        <div class="control has-icons-left">
                            <input class="input is-large" type="text" name="Nombre" maxlength="100" required placeholder="Ingrese el nombre del nuevo producto">
                            <span class="icon is-left">
                                <i class="fa-solid fa-utensils"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-large">Descripción</label>
                        <div class="control has-icons-left">
                            <input class="input is-large" type="text" name="Descripcion" maxlength="1000" required placeholder="Ingrese la descripción del nuevo producto">
                            <span class="icon is-left">
                                <i class="fas fa-info-circle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label is-large">Precio</label>
                        <div class="control has-icons-left">
                            <input class="input is-large" type="number" name="PRECIO" min="0" max="9999" required placeholder="Ingrese el precio del nuevo producto">
                            <span class="icon is-left">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field is-large" style="font-size: 1.25rem;">
                        <label class="label is-large">Categoría</label>
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth is-large">
                                <select name="Cod_cat" required style="font-size: 1.2rem; height: 3rem;">
                                    <option value="">Selecciona una categoría para el producto</option>
                                    <option value="500">Mariscos</option>
                                    <option value="501">Menú infantil</option>
                                    <option value="502">Especialidades</option>
                                    <option value="503">Arroz</option>
                                    <option value="504">Postres</option>
                                    <option value="505">Cortes selectos y carnes asadas</option>
                                    <option value="506">Bebidas</option>
                                </select>
                            </div>
                            <span class="icon is-left is-large">
                                <i class="fa-solid fa-list fa-xl"></i>
                            </span>
                        </div>
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-success is-large"
                            style="background: #49c68f; color: white; width: 100%; font-size: 1.5rem; padding: 1.25rem 1.5rem;">
                            Agregar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal" id="modal-confirmar">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title  is-size-4" >Confirmar</p>
        </header>
        <section class="modal-card-body is-size-5">
            ¿Estás seguro de agregar el producto?
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success is-medium" style="background-color: #49c68f; color: white;margin-right: 12px;" id="btn-aceptar-confirmar">Aceptar</button>

            <button class="button is-medium" id="btn-cancelar-confirmar">Cancelar</button>
        </footer>
    </div>
</div>

<!-- Modal de éxito -->
<div class="modal" id="modal-exito">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title is-size-4">¡Éxito!</p>
        </header>
        <section class="modal-card-body is-size-5">
            El producto se ha agregado correctamente.
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success s-medium" style="background-color: #49c68f; color: white;" id="btn-aceptar-exito">Aceptar</button>
        </footer>
    </div>
</div>

<script>
let formData = null;

document.getElementById('form-agregar-producto').addEventListener('submit', function(e) {
    e.preventDefault();
    formData = new FormData(this);
    document.getElementById('modal-confirmar').classList.add('is-active');
});

document.getElementById('btn-cancelar-confirmar').onclick = function() {
    document.getElementById('modal-confirmar').classList.remove('is-active');
};

document.getElementById('btn-aceptar-confirmar').onclick = function() {
    fetch("{{ route('admin-menu.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
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
    window.location.href = "{{ route('admin.menu') }}";
};
</script>
@endsection