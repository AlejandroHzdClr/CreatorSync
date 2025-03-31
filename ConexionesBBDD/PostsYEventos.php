<?php
ob_start(); // Evita que se envíen caracteres antes de la respuesta JSON
session_start(); // Inicia la sesión

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "Alex_Hdez";
$password = "Alex_1234";
$dbname = "creatorsync";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    ob_clean();
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

// Función para obtener publicaciones y eventos combinados
function obtenerPublicacionesYEventos($conn) {
    $sql = "
        SELECT 'publicacion' AS tipo, p.id, p.usuario_id AS creador_id, u.nombre AS creador_nombre, u.avatar AS creador_imagen, 
               p.titulo, p.contenido AS descripcion, p.imagen, p.fecha
        FROM publicaciones p
        JOIN usuarios u ON p.usuario_id = u.id
        UNION
        SELECT 'evento' AS tipo, e.id, e.creador_id, u.nombre AS creador_nombre, u.avatar AS creador_imagen, 
               e.titulo, e.descripcion, e.imagen, e.fecha
        FROM eventos e
        JOIN usuarios u ON e.creador_id = u.id
        ORDER BY fecha DESC
    ";

    $result = $conn->query($sql);
    if ($result) {
        $datos = $result->fetch_all(MYSQLI_ASSOC);
        ob_clean();
        echo json_encode($datos ?: []); // Asegurar un array JSON válido
    } else {
        ob_clean();
        echo json_encode(["error" => "Error al obtener publicaciones y eventos: " . $conn->error]);
    }
}


// Función para guardar imágenes en el servidor
function guardarImagen($imagen) {
    $directorio = __DIR__ . "/../uploads/"; // Si 'uploads' está fuera de 'ConexionesBBDD'
    
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = time() . "_" . basename($imagen['name']);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        return "http://creatorsync.com/uploads/" . $nombreArchivo; // Devolver la URL completa
    }
    return null;
}

// Función para subir una publicación
function subirPublicacion($conn, $usuario_id, $titulo, $contenido, $imagen) {
    $rutaImagen = null;
    if ($imagen && $imagen['error'] === 0) {
        $rutaImagen = guardarImagen($imagen);
        if (!$rutaImagen) {
            ob_clean();
            echo json_encode(["error" => "No se pudo guardar la imagen"]);
            exit;
        }
    }

    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido, imagen, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $usuario_id, $titulo, $contenido, $rutaImagen);

    if ($stmt->execute()) {
        ob_clean();
        echo json_encode(["success" => "Publicación subida correctamente"]);
    } else {
        ob_clean();
        echo json_encode(["error" => "Error al subir la publicación: " . $stmt->error]);
    }

    $stmt->close();
}

// Función para subir un evento
function subirEvento($conn, $usuario_id, $titulo, $contenido, $imagen) {
    $rutaImagen = null;
    if ($imagen && $imagen['error'] === 0) {
        $rutaImagen = guardarImagen($imagen);
        if (!$rutaImagen) {
            ob_clean();
            echo json_encode(["error" => "No se pudo guardar la imagen"]);
            exit;
        }
    }

    $sql = "INSERT INTO eventos (creador_id, titulo, descripcion, imagen, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $usuario_id, $titulo, $contenido, $rutaImagen);

    if ($stmt->execute()) {
        ob_clean();
        echo json_encode(["success" => "Evento subido correctamente"]);
    } else {
        ob_clean();
        echo json_encode(["error" => "Error al subir el evento: " . $stmt->error]);
    }

    $stmt->close();
}

// Manejo de peticiones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el usuario ha iniciado sesión para las operaciones de subida
    if (!isset($_SESSION['id'])) {
        ob_clean();
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $usuario_id = $_SESSION['id']; // Obtener la ID del usuario

    $tipo = $_POST['tipo'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $imagen = $_FILES['imagen'] ?? null;

    if (empty($titulo) || empty($contenido) || empty($tipo)) {
        ob_clean();
        echo json_encode(["error" => "Todos los campos son obligatorios"]);
        exit;
    }

    if ($tipo == 'publicacion') {
        subirPublicacion($conn, $usuario_id, $titulo, $contenido, $imagen);
    } elseif ($tipo == 'evento') {
        subirEvento($conn, $usuario_id, $titulo, $contenido, $imagen);
    } else {
        ob_clean();
        echo json_encode(["error" => "Tipo no válido"]);
    }
} elseif (isset($_GET['tipo'])) {
    $tipo = trim($_GET['tipo']); // Limpia espacios extra

    if ($tipo === 'publicaciones_y_eventos') {
        obtenerPublicacionesYEventos($conn);
    } else {
        ob_clean();
        echo json_encode(["error" => "Tipo no válido: " . $tipo]);
    }
} else {
    ob_clean();
    echo json_encode(["error" => "Tipo no proporcionado"]);
}

$conn->close();
ob_end_flush();
?>