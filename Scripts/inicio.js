$(document).ready(function () {
    // Mostrar el modal al hacer clic en "Subir"
    $('#subirX').click(function () {
        $('#subirModal').modal('show');
    });

    // Manejar el formulario de subida
    $('#subirForm').submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'http://creatorsync.com/ConexionesBBDD/PostsYEventos.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                //console.log('Respuesta del servidor:', data); // Ver la respuesta completa en consola

                if (data.success) {
                    $('#subirModal').modal('hide');
                    alert("Subida con éxito");
                    obtenerPublicacionesYEventos();
                } else {
                    alert(data.error || "Error desconocido");
                }
            },
            error: function (xhr, status, error) {
                //console.error('Error en la subida:', error);
                alert("Error en la subida");
            }
        });
    });

    // Obtener publicaciones y eventos al cargar la página
    obtenerPublicacionesYEventos();
});

// Obtener publicaciones y eventos combinados
function obtenerPublicacionesYEventos() {
    $.ajax({
        url: "http://creatorsync.com/ConexionesBBDD/PostsYEventos.php?tipo=publicaciones_y_eventos",
        method: "GET",
        dataType: "json",
        success: function (data) {
            $("#principal").empty(); // Limpiar antes de agregar nuevos elementos

            //console.log("✅ Total de elementos recibidos:", data.length);
            data.forEach(item => {
                if (item.tipo === 'publicacion') {
                    generarPost(item);
                } else if (item.tipo === 'evento') {
                    generarEvento(item);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("❌ Error al obtener publicaciones y eventos:", status, error);
        }
    });
}


// Define la URL base donde están almacenadas las imágenes
const BASE_URL_IMAGENES = "http://creatorsync.com/";

// Función para generar publicaciones en HTML
function generarPost(post) {
    //console.log("📌 Generando POST:", post);  // <-- Verifica si se llama la función

    let imagenRuta = post.imagen.startsWith("http") ? post.imagen : BASE_URL_IMAGENES + post.imagen;
    var postHtml = `
    <div class="card" style="width: 50%;">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <img src="${post.creador_imagen}" style="width: 75px; border-radius: 50%;" alt="Imagen de ${post.titulo}">
                <p class="card-text">${post.creador_nombre}</p>
            </div>
            <h5 class="card-title">${post.titulo}</h5>
            <p class="card-text">${post.descripcion}</p>
        </div>
        <img src="${imagenRuta}" class="card-img-bottom" alt="Imagen de ${post.titulo}">
        <div class="card-footer">
            <img src="../Imgs/Comentarios.png" style="width: 25px;" alt="Comentarios">
            <img src="../Imgs/Like.png" style="width: 25px;" alt="Me gusta">
        </div>
    </div>`;
    
    $("#principal").append(postHtml);
}

function generarEvento(evento) {
    //console.log("📌 Generando EVENTO:", evento);  // <-- Verifica si se llama la función

    let imagenRuta = evento.imagen.startsWith("http") ? evento.imagen : BASE_URL_IMAGENES + evento.imagen;
    var eventoHtml = `
    <div class="card" style="width: 50%;">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <img src="${evento.creador_imagen}" style="width: 75px; border-radius: 50%;" alt="Imagen de ${evento.titulo}">
                <p class="card-text">${evento.creador_nombre}</p>
            </div>
            <h5 class="card-title">${evento.titulo}</h5>
            <p class="card-text">${evento.descripcion}</p>
        </div>
        <img src="${imagenRuta}" class="card-img-bottom" alt="Imagen de ${evento.titulo}">
        <div class="card-footer">
            <img src="../Imgs/Comentarios.png" style="width: 25px;" alt="Comentarios">
            <img src="../Imgs/Like.png" style="width: 25px;" alt="Me gusta">
        </div>
    </div>`;
    
    $("#principal").append(eventoHtml);
}

