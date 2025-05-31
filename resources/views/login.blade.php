@extends('layouts.base-login')

@section('content')
<div class="section contenido">
    <h3 class="title is-2 has-text-centered">Iniciar Sesión</h3>
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                <div class="box is-fullwidth">
                    <form action="/login" id="login-form" method="POST">
                        @csrf
                        <div class="field">
                            <label class="label is-large">Usuario</label>
                            <div class="control has-icons-left">
                                <input class="input is-large" type="text" name="username" placeholder="username" required>
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-large">Contraseña</label>
                            <div class="control has-icons-left">
                                <input class="input is-large" type="password" name="password" placeholder="********" required>
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="field">
                            <button type="submit" class="button is-info is-fullwidth is-large color-button">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>&nbsp; Acceder
                            </button>
                        </div>

                        <div class="has-text-centered">
                            <p id="credentials-error" class="has-text-danger is-size-5"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de inicio de sesión -->
<div class="modal" id="modal-inicio-sesion">
    <div class="modal-background" onclick=""></div>
    <div class="modal-card">
        <header class="modal-card-head has-background-warning">
            <p class="modal-card-title has-text-weight-bold">Inicio de sesión</p>
        </header>
        <section class="modal-card-body">
            <p class="is-size-4">Has iniciado sesión correctamente</p>
        </section>
    </div>
</div>

<script>
document.getElementById('login-form').addEventListener('submit', async function(event) {
    document.getElementById("credentials-error").textContent = "";
    event.preventDefault();

    const form = event.target;
    const data = new FormData(form);

    try {
        const response = await fetch('/login', {
            method: 'POST',
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const json = await response.json();

        if (json.ok) {
            document.getElementById("modal-inicio-sesion").classList.add("is-active");
            await sleep(200);
            window.location.href = json.redirect;
        } else {
            document.getElementById("credentials-error").textContent = json.error || "Credenciales Incorrectas, ingresa los datos nuevamente";
        }
    } catch(err) {
        console.error("Error de red: ", err);
        document.getElementById("credentials-error").textContent = "Error de conexión, intenta nuevamente";
    }
});

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
</script>

@endsection
