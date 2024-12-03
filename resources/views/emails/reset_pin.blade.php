<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN de Reinicio de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .pin {
            font-weight: bold;
            font-size: 24px;
            color: #007bff;
        }
        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola!</h1>
        <p>Tu PIN de reinicio de contraseña es:</p>
        <p class="pin">{{ $pin }}</p>
        <p>Utiliza este PIN para acceder a tu cuenta. Si no solicitaste este reinicio, ignora este correo.</p>
    </div>
    <footer>
        <p>© {{ date('Y') }} Tu Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
