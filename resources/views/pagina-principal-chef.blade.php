@extends('layouts.base') 
@section('content')
<h2 class="title is-1">
        <i class="fa-solid fa-utensils"></i> Resumen de Pedidos
    </h2>
    <div class="column">
        <div class="comanda-box">


            <!-- Fila de tarjetas -->
            <div class="columns is-multiline">
                <!-- Comanda 1 -->
                <div class="column is-3">
                    <div class="box mb-5">
                        <p><strong>Mesa #1</strong></p>
                        <p>Comanda #1</p>
                        <br>
                        <ul>
                            <li><span class="status-pendiente">Pendiente&nbsp;&nbsp;&nbsp;&nbsp;</span> 1 × Camarones Fuente de Boulevard - <em>(Sin Picante)</em></li>
                            <li><span class="status-espera">En Espera&nbsp;&nbsp;&nbsp;&nbsp;</span> 1 × Nopales en Penca </li>
                            <li><span class="status-entregado">Entregado&nbsp;&nbsp;&nbsp;</span>  2 × Filete de Pescado - 
                                <em>[1× Sin ensalada, Sin Picante] [1× Sin Picante]</em>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Comanda 2 -->
                <div class="column is-3">
                    <div class="box mb-5">
                        <p><strong>Mesa #2</strong></p>
                        <p>Comanda #2</p>
                        <br>
                        <ul>
                            <li><span class="status-pendiente">Pendiente&nbsp;&nbsp;&nbsp;&nbsp;</span> 1 × Camarones Fuente de Boulevard - <em>(Sin Picante)</em></li>
                            <li><span class="status-espera">En Espera&nbsp;&nbsp;&nbsp;&nbsp;</span> 1 × Nopales en Penca </li>
                            <li><span class="status-entregado">Entregado&nbsp;&nbsp;&nbsp;</span>  2 × Filete de Pescado - 
                                <em>[1× Sin ensalada, Sin Picante] [1× Sin Picante]</em>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
@endsection
