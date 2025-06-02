<!DOCTYPE html>
<html>
<head>
    <title>Procesando cuenta...</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        p {
            color: #7f8c8d;
            margin-bottom: 1rem;
        }
    </style>
    <script>
        window.onload = function() {

            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = '{{ $pdfPath }}';
            document.body.appendChild(iframe);

            // Redirección a pagina principal del mesero después de 1.5 segundos
            setTimeout(function() {
                window.location.href = '/home-mesero';
            }, 1500);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Procesando cuenta</h1>
        <div class="spinner"></div>
        <p>Descargando cuenta y redirigiendo...</p>
    </div>
</body>
</html>