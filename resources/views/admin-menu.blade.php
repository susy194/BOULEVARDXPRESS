@extends('layouts.base')

@section('content')
@php
$categorias = [
    (object)[
        'Categoria' => 'Entradas',
        'productos' => [
            (object)['Nombre' => 'Guacamole', 'PRECIO' => 60],
            (object)['Nombre' => 'Queso Fundido', 'PRECIO' => 80],
        ]
    ],
    (object)[
        'Categoria' => 'Platos Fuertes',
        'productos' => [
            (object)['Nombre' => 'Tacos al Pastor', 'PRECIO' => 120],
            (object)['Nombre' => 'Enchiladas', 'PRECIO' => 110],
        ]
    ],
    (object)[
        'Categoria' => 'Menú Infantil',
        'productos' => [
            
        ]
    ],
];
@endphp
<div class="section">
   <h2 class="title is-2 has-text-weight-bold mb-4">Administración del Menú</h2>
   <div class="has-text-left mt-4">
    <a href="/pagina-principal-admin" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Volver al Panel de Administrador</span>
    </a>
   </div>
  <div class="container">
    <div class="is-flex is-justify-content-flex-end mb-4">
      <a href="/admin-menu/agregar" class="button" style="background-color: #38c172; color: #fff; font-weight: 600; font-size: 1.1rem;">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span class="is-size-5">Agregar producto</span>
      </a>
    </div>
    
    <div class="box" style="box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
      @foreach($categorias as $categoria)
        <h3 class="title is-4 mt-5 mb-3">{{ $categoria->Categoria }}</h3>
        <div class="box" style="background: #f9f9f9; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
          @forelse($categoria->productos as $producto)
            <div class="is-flex is-align-items-center is-justify-content-space-between mb-3" style="gap: 1.2rem;">
              <div class="is-flex is-align-items-center" style="gap: 0.7rem;">
                <button class="button is-medium" style="background-color: #ff4f81; color: #fff; font-weight: bold; border: none; font-size: 1.3rem;">
                  <span class="icon is-medium"><i class="fas fa-minus"></i></span>
                </button>
                <span class="has-text-weight-semibold is-size-4">{{ $producto->Nombre }}</span>
              </div>
              <span class="tag is-info is-large" style="font-size: 1.3rem;">${{ number_format($producto->PRECIO, 2) }}</span>
            </div>
          @empty
            <p class="has-text-grey is-size-5">No hay productos en esta categoría.</p>
          @endforelse
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection 