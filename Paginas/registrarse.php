<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="registrar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>REGISTRAR CUENTA</h1>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>
    <p class="mensaje_error" id="nombre_error"></p><br>

    <label for="correo">Correo Electrónico:</label>
    <input type="email" name="correo" id="correo" required>
    <p class="mensaje_error" id="correo_error"></p><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" id="contrasena" required>
    <p class="mensaje_error" id="contrasena_error"></p><br>

    <br>
    <button id="registrar">Registrarse</button>

    <script src="../Scripts/registrar.js"></script>
</body>
</html>
