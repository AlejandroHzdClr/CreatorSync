<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreatorSync</title>
    <link href="../Estilos/inicio.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include(__DIR__ . '/../Plantillas/logo.php'); ?>
    <div id="todo">
        <div id="opciones">
            <ul class="list-group">
                <li class="list-group-item" onclick=window.location.href="./inicio.php">Inicio</li>
                <li class="list-group-item">Posts</li>
                <li class="list-group-item">Eventos</li>
                <li class="list-group-item d-flex justify-content-between align-items-center" onclick=window.location.href="./notificaciones.php">
                    Notificaciones
                   <!--<span class="badge text-bg-primary rounded-pill">11</span> -->
                </li>
                <li class="list-group-item" onclick=window.location.href="./configuracion.php">Ajustes</li>
            </ul>
        </div>
        <div id="principal"></div>
        <div id="crear">
            <div id="subir">
                <button type="button" class="btn btn-primary btn-lg" id="subirX">Subir</button>
            </div>
            <div id="generos">
                <ul class="list-group">
                    <li class="list-group-item">Juegos</li>
                    <li class="list-group-item">Fitness</li>
                    <li class="list-group-item">Arte</li>
                    <li class="list-group-item">Just Talking</li>
                    <li class="list-group-item">Noticias</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="subirModal" tabindex="-1" aria-labelledby="subirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subirModalLabel">Subir Publicación o Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" method="post" enctype="multipart/form-data">
                    <form id="subirForm">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="publicacion">Publicación</option>
                                <option value="evento">Evento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="contenido">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Scripts/inicio.js"></script>
</body>
</html>
