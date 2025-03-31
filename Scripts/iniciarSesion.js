$(document).ready(function() {
    localStorage.clear();
    $("#iniciar").on("click", () => {
        const nombre = $("#nombre").val();
        const contrasena = $("#contrasena").val();

        $.ajax({
            url: "http://creatorsync.com/ConexionesBBDD/InicioSesion.php",
            method: "GET",
            data: { nombre: nombre, contrasena: contrasena },
            success: function(response) {
                console.log(response); // Verifica la respuesta del servidor
                if (response && response.nombre) {
                    // Si el usuario se autentica correctamente
                    window.location.href = "../Paginas/inicio.php";
                } else {
                    // Si hubo un error en el inicio de sesión
                    alert("Nombre de usuario o contraseña incorrectos");
                }
            },
            error: function(xhr) {
                console.error("Error en la solicitud. Código de estado:", xhr.status);
                console.error("Respuesta del servidor:", xhr.responseText);
            }
        });
    });
});
