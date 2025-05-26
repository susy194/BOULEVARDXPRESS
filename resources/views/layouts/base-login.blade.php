
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boulevard-Xpress</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/92cc48fd18.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>
<body>
    <div class="container is-fluid">
        <div class="banner">
            <img src="{{ asset('img/fondo.jpg') }}" alt="Banner">
        </div>

        <section class="section mi-banner">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column has-text-centered">
                        <h2 class="title is-2">Fuente de Boulevard</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="section contenido">
            <div class="container">
                @yield('content')
            </div>
        </section>

        <footer class="footer custom-footer">
            <div class="container">
                <div class="columns">
                    <div class="column has-text-left">
                        <p class="label is-size-5 has-text-weight-semibold">BoulevardXpres&copy;</p>
                    </div>
                    <div class="column has-text-right">
                        {{-- <p class="is-size-5">Martes 25 de Febrero del 2025 - 15:00</p> --}}
                        <label id="datetime" class="label is-size-5 has-text-weight-semibold"></label>
                    </div>
                </div>
            </div>
        </footer>
    </div>



</body>
<script>
    function actualizarFechaHora() {
      const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
      const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

      const ahora = new Date();
      const diaSemana = dias[ahora.getDay()];
      const dia = ahora.getDate();
      const mes = meses[ahora.getMonth()];
      const año = ahora.getFullYear();

      const hora = ahora.getHours().toString().padStart(2, '0');
      const minutos = ahora.getMinutes().toString().padStart(2, '0');
      const segundos = ahora.getSeconds().toString().padStart(2, '0');

      const texto = `${diaSemana} ${dia} de ${mes} del ${año} - ${hora}:${minutos}:${segundos}`;
      document.getElementById('datetime').textContent = texto;
    }

    // Actualizar inmediatamente y cada segundo
    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000);
  </script>


</html>