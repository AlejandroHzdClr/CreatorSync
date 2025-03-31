<?php
ob_start(); // Evita que se envíen caracteres antes de la respuesta JSON
session_start(); // Inicia la sesión

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Conexión a la base de datos
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

// Función para obtener el perfil del usuario
function obtenerPerfil($conn) {
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        ob_clean();
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $usuario_id = $_SESSION['id'];
    $sql = "SELECT nombre, correo, avatar, descripcion FROM usuarios WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    
    $resultado = $stmt->get_result()->fetch_assoc();
    ob_clean();
    echo json_encode($resultado);
    
    $stmt->close();
}

// Función para guardar imágenes
function guardarImagen($imagen) {
    $directorio = __DIR__ . "/../uploads/"; 
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = time() . "_" . basename($imagen['name']);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        return "http://creatorsync.com/uploads/" . $nombreArchivo;
    }
    return null;
}

// Función para actualizar el perfil
function personalizarPerfil($conn, $nombre, $correo, $descripcion, $avatar) {
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        ob_clean();
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $usuario_id = $_SESSION['id'];
    $rutaImagen = null;

    if ($avatar && $avatar['error'] === 0) {
        $rutaImagen = guardarImagen($avatar);
        if (!$rutaImagen) {
            ob_clean();
            echo json_encode(["error" => "No se pudo guardar la imagen"]);
            exit;
        }
    }

    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, descripcion = ?";
    if ($rutaImagen) {
        $sql .= ", avatar = ?";
    }
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($rutaImagen) {
        $stmt->bind_param("ssssi", $nombre, $correo, $descripcion, $rutaImagen, $usuario_id);
    } else {
        $stmt->bind_param("sssi", $nombre, $correo, $descripcion, $usuario_id);
    }

    if ($stmt->execute()) {
        ob_clean();
        echo json_encode(["success" => "Perfil actualizado correctamente"]);
    } else {
        ob_clean();
        echo json_encode(["error" => "Error al actualizar el perfil: " . $stmt->error]);
    }

    $stmt->close();
}

// Funciones para subir publicaciones y eventos
function subirPublicacion($conn, $usuario_id, $titulo, $contenido, $imagen) {
    $rutaImagen = null;
    if ($imagen && $imagen['error'] === 0) {
        $rutaImagen = guardarImagen($imagen);
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

function subirEvento($conn, $usuario_id, $titulo, $contenido, $imagen) {
    $rutaImagen = null;
    if ($imagen && $imagen['error'] === 0) {
        $rutaImagen = guardarImagen($imagen);
    }

    $sql = "INSERT INTO eventos (usuario_id, titulo, descripcion, imagen, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $usuario_id, $titulo, $contenido, $rutaImagen);

    if ($stmt->execute()) {
        ob_clean();
        echo json_encode(["success" => "Evento creado correctamente"]);
    } else {
        ob_clean();
        echo json_encode(["error" => "Error al crear el evento: " . $stmt->error]);
    }

    $stmt->close();
}

// Manejo de peticiones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id'])) {
        ob_clean();
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $usuario_id = $_SESSION['id'];
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $avatar = $_FILES['avatar'] ?? null;

    if (empty($nombre) || empty($correo) || empty($descripcion)) {
        ob_clean();
        echo json_encode(["error" => "Todos los campos son obligatorios"]);
        exit;
    }

    personalizarPerfil($conn, $nombre, $correo, $descripcion, $avatar);
} elseif (isset($_GET['tipo']) && $_GET['tipo'] === 'perfil') {
    obtenerPerfil($conn);
} else {
    ob_clean();
    echo json_encode(["error" => "Tipo no proporcionado"]);
}

$conn->close();
ob_end_flush();
?>
