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
             <i class="fa-solid fa-drumstick-bite"></i>Agregar Producto
        </h2>
  <div class="has-text-left mt-4 mb-5">
    <a href="/admin-menu" class="button is-large is-light">
      <span class="icon"><i class="fas fa-arrow-left"></i></span>
      <span>Volver a administración de menú</span>
    </a>
  </div>
  <div class="container">
    <div class="column is-half is-offset-one-quarter">
      <div class="box">

        <form method="POST" action="#">
          @csrf
          <div class="field">
              <label class="label is-large">Nombre</label>
              <div class="control has-icons-left">
                  <input class="input is-large" type="text" name="nombre_emp" required placeholder="Ingrese el nombre del nuevo producto">
                  <span class="icon is-left">
                  <i class="fa-solid fa-utensils"></i>
                  </span>
              </div>
          </div>
          <div class="field">
            <label class="label is-large">Descripción</label>
            <div class="control has-icons-left">
              <input class="input is-large" type="text" name="descripcion" required placeholder="Ingrese la descripción del nuevo producto">
                  <span class="icon is-left">
                  <i class="fas fa-info-circle"></i>
                  </span>
            </div>
          </div>
          <div class="field">
            <label class="label is-large">Precio</label>
            <div class="control has-icons-left">
              <input class="input is-large" type="number" name="precio" min="0" step="0.01" required placeholder="Ingrese el precio del nuevo producto">
                  <span class="icon is-left">
                  <i class="fa-solid fa-money-check-dollar"></i>
                  </span>
            </div>
          </div>
          <div class="field is-large" style="font-size: 1.25rem;">
              <label class="label is-large">Categoría</label>
              <div class="control has-icons-left">
                <div class="select is-fullwidth is-large">
                  <select name="categoria" required style="font-size: 1.2rem; height: 3rem;">
                    <option value=" "> Selecciona una categoría para el producto</option>
                    @foreach($categorias as $cat)
                      <option value="{{ $cat->Cod_cat }}">{{ $cat->Categoria }}</option>
                    @endforeach
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

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection