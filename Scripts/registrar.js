$(document).ready(function() {
    $("#registrar").on("click", function() {
        if (validarFormulario()) {
            const datos = conseguirDatos();
            postName(datos);
        } else {
            mostrarMensaje("Por favor, complete todos los campos correctamente.");
        }
    });

    const patrones = {
        nombre: /^[A-Z][a-z]+$/,
        correo: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,
        contrasena: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^\w\s]).{12,}$/
    };

    function conseguirDatos() {
        return {
            nombre: $("#nombre").val(),
            correo: $("#correo").val(),
            contrasena: $("#contrasena").val()
        };
    }

    function postName(x) {
        console.log(x);
        console.log('Asking server with POST method...');
    
        var formData = $.param(x);
    
        $.ajax({
            url: "http://creatorsync.com/ConexionesBBDD/Registro.php",
            method: "POST",
            data: formData,
            success: function(response) {
                console.log(response);
                try {
                    var jsonResponse = typeof response === "object" ? response : JSON.parse(response);
                    if (jsonResponse.success) {
                        mostrarMensaje(jsonResponse.success);
                    } else {
                        mostrarMensaje(jsonResponse.error);
                    }
                } catch (e) {
                    console.error("Error al parsear la respuesta JSON:", e);
                    mostrarMensaje("Error en la respuesta del servidor.");
                }
            },
            error: function(xhr) {
                console.error("Error en la solicitud. Código de estado:", xhr.status);
                console.error("Respuesta del servidor:", xhr.responseText);
                mostrarMensaje("Error en la solicitud. Por favor, inténtelo de nuevo.");
            }
        });
    }

    function validarCampo(campo, patron) {
        const valor = $(campo).val();
        const esValido = patron.test(valor);
        const mensajeError = $(campo).next(".mensaje_error");

        if (!esValido) {
            mensajeError.text("El valor ingresado no es válido.");
        } else {
            mensajeError.text("");
        }
        return esValido;
    }

    function validarFormulario() {
        let esFormularioValido = true;
        $("input").each(function() {
            const id = $(this).attr("id");
            const patron = patrones[id];

            if (patron) {
                const esValido = validarCampo(this, patron);
                if (!esValido) {
                    esFormularioValido = false;
                }
            }
        });
        return esFormularioValido;
    }

    $("input").on("input", function() {
        const id = $(this).attr("id");
        const patron = patrones[id];

        if (patron) {
            validarCampo(this, patron);
        }
    });

    function mostrarMensaje(mensaje) {
        console.log("Mostrando mensaje:", mensaje);
        const mensajeDiv = $('<div class="mensaje-exito"></div>').text(mensaje);
        $('body').append(mensajeDiv);
        setTimeout(() => {
            mensajeDiv.fadeOut(() => {
                mensajeDiv.remove();
            });
        }, 3000);
    }

    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .mensaje-exito {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border-radius: 5px;
                z-index: 1000;
            }
        `)
        .appendTo('head');
});