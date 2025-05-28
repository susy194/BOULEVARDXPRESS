@extends('layouts.base')

@section('content')
@php
// Datos de ejemplo para usuarios bloqueados y desbloqueados
$usuarios = [
    (object)['id' => 1, 'nombre' => 'Juan Pérez', 'usuario' => 'juanp', 'email' => 'juan@example.com', 'estado' => 'bloqueado'],
    (object)['id' => 2, 'nombre' => 'Ana López', 'usuario' => 'analo', 'email' => 'ana@example.com', 'estado' => 'desbloqueado'],
];
@endphp
<div class="section">
  <div class="container">
    <h2 class="title is-4 mb-4">Desbloquear Usuarios</h2>
   </div>
   <div class="has-text-left mt-4 mb-5">
    <a href="/home-admin" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Volver al Panel de Administrador</span>
    </a>
   </div>

    <div class="columns is-multiline">
      @forelse($usuarios as $usuario)
        <div class="column is-4-desktop is-6-tablet is-12-mobile">
          <div class="box">
            <div class="is-flex is-align-items-center is-justify-content-space-between mb-3" style="gap: 1rem;">
              <div>
                <span class="has-text-weight-semibold">{{ $usuario->nombre }}</span>
                <span class="ml-2">({{ $usuario->usuario }})</span>
                <span class="ml-2 has-text-grey">{{ $usuario->email }}</span>
                <span class="ml-4 tag {{ $usuario->estado == 'bloqueado' ? 'is-danger has-text-white' : 'is-success has-text-white' }} is-medium">
                  {{ ucfirst($usuario->estado) }}
                </span>
              </div>
              <button class="button is-large {{ $usuario->estado == 'bloqueado' ? 'is-warning' : 'is-success' }}" style="height: 3.5rem; width: 3.5rem;" onclick="toggleCandado(this)">
                <span class="icon is-large">
                  <i class="fa-solid {{ $usuario->estado == 'bloqueado' ? 'fa-lock' : 'fa-lock-open' }} fa-2x"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
      @empty
        <p class="has-text-grey">No hay usuarios bloqueados.</p>
      @endforelse
    </div>
  </div>
</div>
<script>
function toggleCandado(btn) {
  const icon = btn.querySelector('i');
  const tag = btn.parentElement.querySelector('.tag');
  if (icon.classList.contains('fa-lock')) {
    icon.classList.remove('fa-lock');
    icon.classList.add('fa-lock-open');
    btn.classList.remove('is-warning');
    btn.classList.add('is-success');
    if(tag) { tag.textContent = 'Desbloqueado'; tag.classList.remove('is-danger'); tag.classList.add('is-success'); }
  } else {
    icon.classList.remove('fa-lock-open');
    icon.classList.add('fa-lock');
    btn.classList.remove('is-success');
    btn.classList.add('is-warning');
    if(tag) { tag.textContent = 'Bloqueado'; tag.classList.remove('is-success'); tag.classList.add('is-danger'); }
  }
}
</script>
@endsection