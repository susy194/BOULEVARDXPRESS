@extends('layouts.base')

@section('content')
<div class="section">
    <h2 class="title is-2 has-text-weight-bold mb-5">
                <i class="fa-solid fa-unlock"></i> Desbloquear Usuarios
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
            @php
                // Simulación: si el usuario empieza con "a" está desbloqueado, si no, bloqueado
                $desbloqueado = strtolower(substr($usuario->usuario, 0, 1)) === 'a';
            @endphp
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box" style="position:relative;">
                    <div class="is-flex is-align-items-center mb-3" style="gap: 1rem;">
                        <figure class="image is-64x64" style="flex-shrink:0;">
                            <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre_emp) }}&background=ff5e9c&color=fff" alt="Foto de {{ $usuario->nombre_emp }}">
                        </figure>
                        <h2 class="title is-5 has-text-weight-bold mb-0" style="flex:1;">
                            {{ $usuario->nombre_emp }}
                            <span class="has-text-grey" style="font-weight:normal;">({{ $usuario->usuario }})</span>
                        </h2>
                        <button class="button is-medium estado-btn"
                            style="background-color: {{ $desbloqueado ? '#ffe066' : '#ff5e9c' }}; border: none; color: black;"
                            onclick="toggleEstado(this)">
                            <span class="icon is-medium">
                                @if($desbloqueado)
                                    <i class="fas fa-lock-open fa-lg"></i>
                                @else
                                    <i class="fas fa-lock fa-lg"></i>
                                @endif
                            </span>
                        </button>
                    </div>
                    <div class="content ml-2">
                        <span class="tag is-medium estado-tag"
                              style="background: {{ $desbloqueado ? '#38d996' : '#ff5e9c' }}; color: white; margin-bottom: 0.5rem;">
                            {{ $desbloqueado ? 'Desbloqueado' : 'Bloqueado' }}
                        </span>
                        <p class="is-size-6"><strong>Tipo de usuario:</strong> {{ $usuario->Tipo_Us }}</p>
                        <p class="is-size-6"><strong>Contraseña:</strong> {{ $usuario->password }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function toggleEstado(btn) {
    // Cambia el color del botón y el ícono
    const icon = btn.querySelector('i');
    const tag = btn.closest('.box').querySelector('.estado-tag');

    // Si está bloqueado, desbloquea
    if (icon.classList.contains('fa-lock')) {
        icon.classList.remove('fa-lock');
        icon.classList.add('fa-lock-open');
        btn.style.backgroundColor = '#ffe066'; // Amarillo
        tag.textContent = 'Desbloqueado';
        tag.style.background = '#38d996'; // Verde
    } else {
        icon.classList.remove('fa-lock-open');
        icon.classList.add('fa-lock');
        btn.style.backgroundColor = '#ff5e9c'; // Rojo
        tag.textContent = 'Bloqueado';
        tag.style.background = '#ff5e9c'; // Rojo
    }
}
</script>
@endsection