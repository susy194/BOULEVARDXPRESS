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
  <h2 class="title is-3 mb-4">Agregar Producto</h2>
    <div class="has-text-left mt-4">
    <a href="/admin-menu" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Volver a administración de menú</span>
    </a>
   </div> 
  <div class="container">
    <div class="column is-half is-offset-one-quarter">
      <div class="box">
        
        <form method="POST" action="#">
          @csrf
          <div class="field">
            <label class="label">Nombre</label>
            <div class="control">
              <input class="input" type="text" name="nombre" required>
            </div>
          </div>
          <div class="field">
            <label class="label">Descripción</label>
            <div class="control">
              <textarea class="textarea" name="descripcion" required></textarea>
            </div>
          </div>
          <div class="field">
            <label class="label">Precio</label>
            <div class="control">
              <input class="input" type="number" name="precio" min="0" step="0.01" required>
            </div>
          </div>
          <div class="field">
            <label class="label">Categoría</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select name="categoria" required>
                  <option value="">Selecciona una categoría</option>
                  @foreach($categorias as $cat)
                    <option value="{{ $cat->Cod_cat }}">{{ $cat->Categoria }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="field is-grouped is-grouped-right mt-5">
            <div class="control">
              <button type="submit" class="button is-success">Agregar</button>
            </div>
            <div class="control">
              <a href="/admin-menu" class="button is-light">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 