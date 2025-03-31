$(document).ready(function () {
    $('#perfil').click(function () {
        modPerfil();
    });
    $('#seguridad').click(function () {
        modSeguridad();
    });
    $('#notificaciones').click(function () {
        modNotificaciones();
    });
});

var configuracion = document.getElementById("configuracion");

function modPerfil() {
    configuracion.innerHTML = `
        <div class="perfil-container">
            <h1>Perfil</h1>
            <form id="perfilForm" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Ingresa tu email">

                <label for="foto">Foto de perfil:</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <img id="preview" src="" alt="Vista previa">

                <input type="submit" value="Guardar">
            </form>
        </div>
    `;

    // Vista previa de la imagen antes de enviarla
    document.getElementById("foto").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById("preview");
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
}

function modSeguridad() {
    configuracion.innerHTML = `
        <div class="seguridad-container">
            <h1>Seguridad</h1>
            <form id="seguridadForm">
                <label for="password">Contraseña actual:</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña actual">

                <label for="newPassword">Nueva contraseña:</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Ingresa tu nueva contraseña">

                <label for="confirmPassword">Confirmar contraseña:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirma tu nueva contraseña">

                <input type="submit" value="Guardar">
            </form>
        </div>
    `;
}


function modNotificaciones() {
    configuracion.innerHTML = `
        <div class="notificaciones-container">
            <h1>Notificaciones</h1>
            <form id="notificacionesForm">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="notiLikes">Likes</label>
                    <input class="form-check-input" type="checkbox" role="switch" id="notiLikes">
                </div>
                <div class="form-check form-switch">
                    <label class="form-check-label" for="notiSeguidores">Seguidores</label>
                    <input class="form-check-input" type="checkbox" role="switch" id="notiSeguidores">
                </div>
                <div class="form-check form-switch">
                    <label class="form-check-label" for="notiComentarios">Comentarios</label>
                    <input class="form-check-input" type="checkbox" role="switch" id="notiComentarios">
                </div>

                <input type="submit" value="Guardar">
            </form>
        </div>
    `;
}
