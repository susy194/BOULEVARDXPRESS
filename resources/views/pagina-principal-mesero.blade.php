@extends('layouts.base')

@section('content')
<br><br><br>
<h2 class="title is-1">
    <i class="fa-solid fa-bell-concierge"></i> Mesas
</h2>

    <br><br><br>
<div class="box div-perso">
    <div class="content">
        <div class="columns is-multiline">


            <!-- Tarjeta 1 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-1'>

                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp ml-0" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #1
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/1'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>

                </div>
            </div>



            <!-- Tarjeta 2 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-2'>
                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp ml-0" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #2
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/2'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-3'>
                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp ml-0" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #3
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/3'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 4 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-4'>
                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #4
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/4'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 5 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-5'>
                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #5
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/5'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 6 -->
            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                <div class="box" id='mesa-6'>
                    <!-- Botón alineado a la derecha -->
                    <div class="has-text-right">
                    <button class="button is-large status-button-wp" title="Indica el estado de la mesa, rojo:ocupado,verde:vacio">
                        <i class="fa-solid fa-users"></i>
                    </button>
                    </div>

                    <!-- Contenido centrado -->
                    <div class="has-text-centered">
                    <h5 class="title is-2">
                        <i class="fa-solid fa-utensils"></i> Mesa #6
                    </h5>
                    <p class="subtitle is-4">Vacio</p>
                    <button onclick="window.location.href='/ver-mesa/6'" class="button is-info is-large color-button" title="Ir a la información de la mesa o toma un pedido">
                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    const VACIO         = 0;
    const CLASE_OCUPADO = 'status-button-wop';
    const CLASE_VACIO   = 'status-button-wp';
    const ICON_OCUPADO  = 'fa-users-slash';
    const ICON_VACIO    = 'fa-users';

    function actualizar_mesa(numMesa, estado) {
        const mesa   = document.getElementById(`mesa-${numMesa}`);
        const p_tag  = mesa.querySelector('p');
        const button = mesa.querySelector('button');
        const icon   = button.querySelector('i');

        const esVacia = estado === VACIO;

        if ( esVacia ) {
            p_tag.textContent = 'Vacio';
        } else {
            p_tag.textContent = 'Ocupado';
        }

        button.classList.toggle( CLASE_VACIO  ,  esVacia );
        button.classList.toggle( CLASE_OCUPADO, !esVacia );

        icon.classList.toggle( ICON_VACIO  , esVacia  );
        icon.classList.toggle( ICON_OCUPADO, !esVacia );
    }


    async function actualizar_mesas () {
        while ( true ) {
            try {
                const response = await fetch('/mesas');

                if ( ! response.ok ) {
                    console.error("Error al obtener las mesas");
                }

                const data = await response.json();

                for ( const { Num_m, Estado } of data ) {
                    actualizar_mesa(Num_m, Estado);
                }

            } catch (error) {
                console.error('Error al actualizar las mesas:', error);
            }

            await sleep(1000);
        }
    }

    async function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    document.addEventListener('DOMContentLoaded', actualizar_mesas);
</script>
@endsection
