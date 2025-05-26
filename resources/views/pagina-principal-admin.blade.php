@extends('layouts.base')

@section('content')
<div class="section">
  <div class="container">
    <h2 class="title is-1">
        <i class="fa-solid 	fa-tools"></i> Panel de Administrador
    </h2>
    <div class="box div-perso">
      <div class="content">
        <div class="columns is-multiline">
          <!-- Fila 1 -->
          <div class="column is-6-desktop is-12-tablet">
            <div class="box p-4" style="min-height: 170px;">
              <div class="has-text-right mb-2">
                <button class="button is-info is-medium">
                  <i class="fa-solid fa-chart-line fa-lg"></i></button>
              </div>
              <h5 class="title is-5"><i class="fa-solid fa-receipt"></i> Reporte de Ventas</h5>
              <p class="subtitle is-6">Genera informes detallados de ventas</p>
              <a href="/admin/reporte-ventas" class="button is-info is-medium mt-2" title="Botón para generar un pdf con el reporte de ventas"><i class="fa-solid fa-file-invoice"></i>&nbsp; Generar</a>
            </div>
          </div>
          <div class="column is-6-desktop is-12-tablet">
            <div class="box p-4" style="min-height: 170px;">
              <div class="has-text-right mb-2">
                <button class="button is-warning is-medium"><i class="fa-solid fa-user-lock fa-lg"></i></button>
              </div>
              <h5 class="title is-5"><i class="fa-solid fa-unlock-keyhole"></i> Desbloquear Usuarios</h5>
              <p class="subtitle is-6">Gestiona accesos bloqueados</p>
              <a href="/admin/desbloquear-usuarios" class="button is-warning is-medium mt-2" title="Botón para cesbloquear a los usuarios que lo necesiten"><i class="fa-solid fa-unlock"></i>&nbsp; Desbloquear</a>
            </div>
          </div>
          <!-- Fila 2 -->
          <div class="column is-6-desktop is-12-tablet">
            <div class="box p-4" style="min-height: 170px;">
              <div class="has-text-right mb-2">
                <button class="button is-danger is-medium"><i class="fa-solid fa-user-gear fa-lg"></i></button>
              </div>
              <h5 class="title is-5"><i class="fa-solid fa-users-gear"></i> Alta / Baja de Usuarios</h5>
              <p class="subtitle is-6">Agrega o elimina usuarios del sistema</p>
              <a href="/admin/usuarios" class="button is-danger is-medium mt-2"title="Botón para ir a la administración de usuarios"><i class="fa-solid fa-user-plus"></i>&nbsp; Administrar</a>
            </div>
          </div>
          <div class="column is-6-desktop is-12-tablet">
            <div class="box p-4" style="min-height: 170px;">
              <div class="has-text-right mb-2">
                <button class="button is-success is-medium"><i class="fa-solid fa-utensils fa-lg"></i></button>
              </div>
              <h5 class="title is-5"><i class="fa-solid fa-utensils"></i> Administración del Menú</h5>
              <p class="subtitle is-6">Gestiona los productos y su información</p>
              <a href="/admin-menu" class="button is-success is-medium mt-2" title="Botón para ir a la administración del menú"><i class="fa-solid fa-utensils"></i>&nbsp; Administrar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection