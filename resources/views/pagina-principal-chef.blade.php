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
                <!-- Comanda GÉNERICA -->
                <div class="column is-3">
                    <div class="box mb-5">
                        <p><strong>Pedido #{{ $pedido->id_pedido ?? 'N/A' }}</strong></p>

                    </div>
                </div>



        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        window.Echo.private("user.Chef")
            .listen('GetMesas', (e) => {
                console.log('Evento recibido:', e.data);
                for each
            });

        fetch('/api/getmesas')
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.error('Error:', error);
            });

        console.log('Evento enviado');
    });
</script>
@endsection
