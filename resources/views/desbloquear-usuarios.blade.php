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
                        <h2 class="title is-3 has-text-weight-bold mb-0" style="flex:1;">
                            {{ $usuario->nombre_emp }}
                            <span class="has-text-grey" style="font-weight:normal;">({{ $usuario->usuario }})</span>
                        </h2>
                        <button class="button is-medium estado-btn"
                            style="background-color: {{ $usuario->bloqueado ? '#ff5e9c' : '#ffe066' }}; border: none; color: black;"
                            onclick="toggleEstado(this, {{ $usuario->ID_emp }}, {{ $usuario->ID_Tipo }}, {{ $usuario->bloqueado ? 'true' : 'false' }})">
                            <span class="icon is-medium">
                                @if($usuario->bloqueado)
                                    <i class="fas fa-lock fa-lg"></i>
                                @else
                                    <i class="fas fa-lock-open fa-lg"></i>
                                @endif
                            </span>
                        </button>
                    </div>
                    <div class="content ml-2">
                        <span class="tag is-medium estado-tag"
                              style="background: {{ $usuario->bloqueado ? '#ff5e9c' : '#38d996' }}; color: white; margin-bottom: 0.5rem;">
                            {{ $usuario->bloqueado ? 'Bloqueado' : 'Desbloqueado' }}
                        </span>
                        <p class="is-size-5"><strong>Tipo de usuario:</strong> {{ $usuario->Tipo_Us }}</p>
                        <p class="is-size-5"><strong>Contraseña:</strong> {{ $usuario->password }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
async function toggleEstado(btn, idEmp, idTipo, bloqueadoActual) {
    try {
        const response = await fetch('/admin/toggle-bloqueo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_emp: idEmp,
                id_tipo: idTipo,
                bloqueado: !bloqueadoActual
            })
        });

        const data = await response.json();

        if (data.success) {
            const icon = btn.querySelector('i');
            const tag = btn.closest('.box').querySelector('.estado-tag');

            if (bloqueadoActual) {
                // Desbloquear
                icon.classList.remove('fa-lock');
                icon.classList.add('fa-lock-open');
                btn.style.backgroundColor = '#ffe066';
                tag.textContent = 'Desbloqueado';
                tag.style.background = '#38d996';
            } else {
                // Bloquear
                icon.classList.remove('fa-lock-open');
                icon.classList.add('fa-lock');
                btn.style.backgroundColor = '#ff5e9c';
                tag.textContent = 'Bloqueado';
                tag.style.background = '#ff5e9c';
            }


            btn.onclick = function() {
                toggleEstado(this, idEmp, idTipo, !bloqueadoActual);
            };
        } else {
            alert('Error al actualizar el estado: ' + (data.message || 'Error desconocido'));
        }
    } catch (error) {
        alert('Error al actualizar el estado: ' + error.message);
    }
}
</script>
@endsection