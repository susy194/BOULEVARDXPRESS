@extends('layouts.base')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/js/app.js')
<h2 class="title is-1">
        <i class="fa-solid fa-utensils"></i> Pantalla principal del Chef-Resumen de Pedidos
    </h2>
    <div class="column">
        <div class="comanda-box">

            <!-- Fila de tarjetas -->
            <div class="columns is-multiline">
                <!-- Comanda 1 -->
                <div class="column is-3">
                    <div class="box mb-5">
                        <p><strong>Mesa #</strong></p>
                        <p>Comanda #1</p>
                        <br>

                    </div>
                </div>

                <!-- Comanda 2 -->
                <div class="column is-3">
                    <div class="box mb-5">
                        <p><strong>Mesa #2</strong></p>
                        <p>Comanda #2</p>
                        <br>
                        <ul>

                        </ul>
                    </div>
                </div>

            </div>


        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        window.Echo.private(`App.Models.User.{{ auth()->user()->id }}`)
            .listen('GetMesas', (e) => {
                console.log('Evento recibido:', e);
            });

        fetch('/api/getmesas');
    });
</script>
@endsection
