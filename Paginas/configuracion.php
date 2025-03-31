<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - CreatorSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../Estilos/configuracion.css">
</head>
<body>
    <?php include(__DIR__ . '/../Plantillas/logo.php'); ?>
    <div id="contenedor">
        <div class="list-group" style="width: 30vw;">
            <button type="button" class="list-group-item list-group-item-action" id="perfil">Perfil</button>
            <button type="button" class="list-group-item list-group-item-action" id="seguridad">Seguridad</button>
            <button type="button" class="list-group-item list-group-item-action" id="notificaciones">Notificaciones</button>
        </div>
        <div id="configuracion">
        </div>
    </div>
    <script src="../Scripts/configuracion.js"></script>
</body>
</html>