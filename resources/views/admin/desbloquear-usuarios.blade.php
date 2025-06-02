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
                        @if($usuario->rol !== 'Administrador')
                        <button class="button is-medium estado-btn"
                            style="background-color: {{ $usuario->bloqueado ? '#ff5e9c' : '#ffe066' }}; border: none; color: black;"
                            onclick="toggleEstado(this, '{{ $usuario->usuario }}', {{ $usuario->bloqueado ? 'true' : 'false' }})">
                            <span class="icon is-medium">
                                @if($usuario->bloqueado)
                                    <i class="fas fa-lock fa-lg"></i>
                                @else
                                    <i class="fas fa-lock-open fa-lg"></i>
                                @endif
                            </span>
                        </button>
                        @else
                        <span class="icon is-medium" title="No se puede bloquear un administrador">
                            <i class="fas fa-user-shield fa-lg" style="color:#ffe066;"></i>
                        </span>
                        @endif
                    </div>
                    <div class="content ml-2">
                        <span class="tag is-medium estado-tag"
                              style="background: {{ $usuario->bloqueado ? '#ff5e9c' : '#38d996' }}; color: white; margin-bottom: 0.5rem;">
                            {{ $usuario->bloqueado ? 'Bloqueado' : 'Desbloqueado' }}
                        </span>
                        <p class="is-size-6"><strong>Tipo de usuario:</strong> {{ $usuario->rol }}</p>
                        <p class="is-size-6"><strong>Usuario:</strong> {{ $usuario->usuario }}</p>
                        <p class="is-size-6"><strong>Contraseña:</strong> {{ $usuario->password }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function toggleEstado(btn, usuario, bloqueadoActual) {
    fetch('/admin/toggle-bloqueo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ usuario })
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            // Cambiar visualmente el estado
            const icon = btn.querySelector('i');
            const tag = btn.closest('.box').querySelector('.estado-tag');
            if (data.bloqueado) {
                btn.style.backgroundColor = '#ff5e9c';
                icon.classList.remove('fa-lock-open');
                icon.classList.add('fa-lock');
                tag.textContent = 'Bloqueado';
                tag.style.background = '#ff5e9c';
            } else {
                btn.style.backgroundColor = '#ffe066';
                icon.classList.remove('fa-lock');
                icon.classList.add('fa-lock-open');
                tag.textContent = 'Desbloqueado';
                tag.style.background = '#38d996';
            }
            // Cambiar el onclick para el nuevo estado
            btn.setAttribute('onclick', `toggleEstado(this, '${usuario}', ${data.bloqueado})`);
        } else {
            alert(data.error || 'Error al cambiar el estado del usuario');
        }
    })
    .catch(() => alert('Error al cambiar el estado del usuario'));
}
</script>
@endsection