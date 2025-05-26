@extends('layouts.base')

@section('content')
<div class="section">
  <h2 class="title is-3 mb-4">
        <i class="fa-solid fa-receipt"></i> Cerrar Cuenta
    </h2>
  <a href="/ver-mesa" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Volver a ver-mesa</span>
    </a>
  
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-half">
        
        <div class="box">
          <!-- Espacio para la cuenta -->
          <div class="box" style="min-height: 250px; display: flex; align-items: center; justify-content: center; background: #f5f5f5;">
            <span class="has-text-grey">Aquí se mostrará el detalle de la cuenta (productos, importes, total)...</span>
          </div>
          <div class="has-text-right mt-5">
            <button class="button is-info is-medium">
              <span class="icon"><i class="fas fa-print"></i></span>
              <span>Imprimir cuenta</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 