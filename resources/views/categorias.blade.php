@extends('layouts.base')

@section('content')
    <br><br><br><br>
    <h2 class="title is-1">Iniciar pedido-Categorías</h2>
    <div class="has-text-left mb-4">
      <a href="/home-mesero" class="button is-light is-medium">
        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
        <span class="is-size-5">Cancelar</span>
      </a>
    </div>
    <div class="columns">
        <!-- CATEGORÍAS -->
        <div class="column is-two-thirds">
            <div class="box div-perso">
                <div class="content">
                    <div class="columns is-multiline">
                        @foreach ($categorias as $categoria)
                            <div class="column is-4-desktop is-12-tablet is-6-mobile">
                                <div class="box has-text-centered">
                                    <span class="icon is-large mb-2">
                                        <i class="fa-solid fa-utensils fa-2x"></i>
                                    </span>
                                    <h5 class="title is-4">{{ $categoria->Categoria }}</h5>
                                    <a href="{{ url('/categoria/' . $categoria->Cod_cat) }}" class="button is-info is-fullwidth mt-3">
                                        <i class="fa-solid fa-arrow-right"></i>&nbsp;Ver productos
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- COMANDA -->
        <div class="column is-one-third">
            <div class="box div-perso">
                <h3 class="title is-4">Resumen del pedido #</h3>
                <div class="box bg-soft" style="height: 300px;">
                    <!-- Aquí va la comanda en tiempo real -->
                </div>
                <button class="button is-warning is-fullwidth is-large mt-4">
                    Enviar Pedido&nbsp;<i class="fa-regular fa-file-lines"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- PRODUCTOS POR CATEGORÍA -->
    @foreach ($categorias as $categoria)
        <div class="categoria-productos mt-4" id="cat-{{ $categoria->Cod_cat }}" style="display: none;">
            <h3 class="subtitle is-6 mb-3">Productos | {{ $categoria->Cod_cat }}</h3>
            <div class="columns is-multiline">
                @foreach ( $categoria->productos as $producto )
                    <div class="column is-4-desktop is-6-tablet is-12-mobile">
                        <div class="box">
                            <div class="has-text-right">
                                <span class="tag is-success is-medium">
                                    ${{ number_format($producto->PRECIO, 2) }}
                                </span>
                            </div>
                            <h5 class="title is-5">
                                <i class="fa-solid fa-utensils"></i> {{ $producto->Nombre }}
                            </h5>
                            <p class="subtitle is-6">{{ $producto->Descripcion }}</p>
                            <button class="button is-success color-button is-fullwidth">
                                <i class="fa-solid fa-plus"></i>&nbsp;Agregar al Pedido
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- JS para mostrar productos según categoría -->
    <script>
        function mostrarProductos(codigo) {
            document.querySelectorAll('.categoria-productos').forEach(div => div.style.display = 'none');
            document.getElementById('cat-' + codigo).style.display = 'block';
        }
    </script>
@endsection