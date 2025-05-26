@extends('layouts.base')

@section('content')
@php
// Datos de ejemplo para usuarios
$usuarios = [
    (object)[
        'id' => 1,
        'nombre' => 'Juan Pérez',
        'usuario' => 'juanp',
        'email' => 'juan@example.com',
        'direccion' => 'Calle 123',
        'telefono' => '555-1234',
        'tipo_usuario' => 'Mesero',
        'foto' => 'https://randomuser.me/api/portraits/men/1.jpg',
    ],
    (object)[
        'id' => 2,
        'nombre' => 'Ana López',
        'usuario' => 'analo',
        'email' => 'ana@example.com',
        'direccion' => 'Avenida 456',
        'telefono' => '555-5678',
        'tipo_usuario' => 'Chef',
        'foto' => 'https://randomuser.me/api/portraits/women/2.jpg',
    ],
];
@endphp
<div class="section">
  <div class="container">
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
      <h1 class="title is-2 has-text-weight-bold mb-2">Administrar Usuarios</h1>
      <a href="/admin/usuarios/agregar" class="button is-large" style="background-color: #ff4f81; color: white; border: none;">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Agregar usuario</span>
      </a>
    </div>
    <div class="has-text-left mt-4 mb-5">
      <a href="/pagina-principal-admin" class="button is-large is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Volver al Panel de Administrador</span>
      </a>
    </div>

    <div class="columns is-multiline">
      @foreach($usuarios as $usuario)
        <div class="column is-4-desktop is-6-tablet is-12-mobile">
          <div class="box">
            <div class="is-flex is-align-items-center mb-3" style="gap: 1rem;">
              <figure class="image is-64x64" style="flex-shrink:0;">
                <img class="is-rounded" src="{{ $usuario->foto }}" alt="Foto de {{ $usuario->nombre }}">
              </figure>
              <h2 class="title is-4 has-text-weight-bold mb-0" style="flex:1;">{{ $usuario->nombre }}</h2>
              <button class="button is-danger is-medium" style="background-color: #ff4f81; border: none;">
                <span class="icon"><i class="fas fa-minus"></i></span>
              </button>
            </div>
            <div class="content ml-2">
              <p class="is-size-5"><strong>Usuario:</strong> {{ $usuario->usuario }}</p>
              <p class="is-size-5"><strong>Email:</strong> {{ $usuario->email }}</p>
              <p class="is-size-5"><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
              <p class="is-size-5"><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
              <p class="is-size-5"><strong>Tipo de usuario:</strong> {{ $usuario->tipo_usuario }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
  </div>
</div>
@endsection 