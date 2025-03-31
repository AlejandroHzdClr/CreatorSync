<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion - CreatorSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../Estilos/iniciar_sesion.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include(__DIR__ . '/../Plantillas/logo.php'); ?>
    <div id="contenedor">
        <div class="card" style="width: 70vw;">
            <img src="../Imgs/CreatorsSyncLogo.png" class="card-img-top" alt="..." style="width: 30%; margin: 0 auto;">
            <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Nombre de usuario: </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" placeholder="PedroElMaquinote222">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Contraseña: </label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="contrasena">
                </div>
            </div>
                <button class="btn btn-primary" id="iniciar">Iniciar Sesion</button>
                <button class="btn btn-primary" id="registro" onclick="window.location.href='./registrarse.php'">Registrarse</button>
            </div>
        </div>
    </div>
    <script src="../Scripts/iniciarSesion.js"></script>
</body>
</html>