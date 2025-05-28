@extends('layouts.base')

@section('content')
<div class="section">
    <div class="container">
        <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <a href="{{ route('home-admin') }}" class="button is-light">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Volver al Panel de Administrador</span>
            </a>
            <a href="{{ route('admin.usuarios.agregar') }}" class="button" style="background-color: #ff5e9c; color: white;">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Agregar usuario</span>
            </a>
        </div>
        <h2 class="title is-2 has-text-weight-bold mb-5">Administrar Usuarios</h2>
        <div class="columns is-multiline">
            @foreach($usuarios as $usuario)
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box" style="position:relative;">
                    <div class="is-flex is-align-items-center mb-3" style="gap: 1rem;">
                        <figure class="image is-64x64" style="flex-shrink:0;">
                            @if($usuario->Foto)
                                <img class="is-rounded" src="data:image/jpeg;base64,{{ base64_encode($usuario->Foto) }}" alt="Foto de {{ $usuario->nombre_emp }}">
                            @else
                                <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre_emp) }}&background=ff5e9c&color=fff" alt="Foto de {{ $usuario->nombre_emp }}">
                            @endif
                        </figure>
                        <h2 class="title is-4 has-text-weight-bold mb-0" style="flex:1;">{{ $usuario->nombre_emp }}</h2>
                        <button class="button is-danger" style="background-color: #ff5e9c; border: none;">
                            <span class="icon"><i class="fas fa-minus"></i></span>
                        </button>
                    </div>
                    <div class="content ml-2">
                        <p class="is-size-5"><strong>Usuario:</strong> {{ $usuario->Usuario }}</p>
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
@endsection