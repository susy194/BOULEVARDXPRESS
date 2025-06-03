@extends('layouts.base')
@section('content')

<meta name="csrf-token" content=" csrf_token() ">
@vite('resources/js/app.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notifyjs-browser/dist/notify.js"></script>
<h2 class="title is-1">
    <i class="fa-solid fa-utensils"></i> Pantalla principal del Chef-Resumen de Pedidos
</h2>

<div class="column">
<div class="columns is-multiline is-variable" id="comanda-box">
    <!--TARJETAS-->
</div>

    <template id="target-template">
                <div class="column is-4-desktop is-12-tablet is-6-mobile">
                    <div class="box mb-5" style="background-color: #e5e5e5;">
                        <h2 class="title is-5">
                             <p class="Num_m" style="has-text-weight-bold" ></p>
                        </h2>

                        <ul style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;" data-id-pedido="">
                            <li class="has-text-weight-bold has-text-grey  is-size-4" style="list-style: none; display: flex; gap: 1rem;">
                                <i>No hay productos en el pedido actual.</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </template>
</div>

<script src="{{ asset('js/chef.js') }}"></script>
@endsection
