@extends('layouts.base')

@section('content')
<div class="section">
    <h2 class="title is-2 has-text-weight-bold mb-5">
        <i class="fa-solid fa-users"></i> Lista de Usuarios
    </h2>
    <div class="container">
        <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <a href="{{ route('home-admin') }}" class="button is-light is-medium mb-4">
                <span class="icon is-medium"><i class="fas fa-arrow-left fa-lg"></i></span>
                <span class="has-text-weight-semibold">Volver al Panel de Administrador</span>
            </a>
        </div>
        <div class="columns is-multiline">
            @foreach($usuarios as $usuario)
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box" style="position:relative;">
                    <div class="is-flex is-align-items-center mb-3" style="gap: 1rem;">
                        <figure class="image is-64x64" style="flex-shrink:0;">
                            <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre_emp) }}&background=ff5e9c&color=fff" alt="Foto de {{ $usuario->nombre_emp }}">
                        </figure>
                        <h2 class="title is-5 has-text-weight-bold mb-0" style="flex:1;">
                            {{ $usuario->nombre_emp }}
                            <span class="has-text-grey" style="font-weight:normal;">({{ strtolower($usuario->rol) }})</span>
                        </h2>
                    </div>
                    <div class="content ml-2">
                        <span class="tag is-medium estado-tag"
                              style="background: {{ $usuario->bloqueado ? '#ff5e9c' : '#38d996' }}; color: white; margin-bottom: 0.5rem;">
                            {{ $usuario->bloqueado ? 'Bloqueado' : 'Desbloqueado' }}
                        </span>
                        <p class="is-size-6"><strong>Tipo de usuario:</strong> {{ $usuario->rol }}</p>
                        <p class="is-size-6"><strong>Contraseña:</strong> {{ $usuario->password }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection