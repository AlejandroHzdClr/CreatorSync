<?php
session_start(); // Iniciar sesión
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "Alex_Hdez";
$password = "Alex_1234";
$dbname = "creatorsync";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if (isset($_GET['nombre']) && isset($_GET['contrasena'])) {
    $nombre = $_GET['nombre'];
    $contrasena = $_GET['contrasena'];

    // Consulta SQL para obtener los datos del usuario
    $sql = "SELECT nombre, contrasena, avatar, id FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_assoc();

        // Verificar la contraseña usando password_verify
        if (password_verify($contrasena, $datos['contrasena'])) {
            // La contraseña es correcta, guardar los datos en la sesión
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['id'] = $datos['id'];
            $_SESSION['avatar'] = $datos['avatar'];

            echo json_encode([
                "nombre" => $datos['nombre'],
                "id" => $datos['id']
            ]);
        } else {
            // Contraseña incorrecta
            echo json_encode(["error" => "Nombre de usuario o contraseña incorrectos"]);
        }
    } else {
        // Usuario no encontrado
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
} else {
    // Parámetros no proporcionados
    echo json_encode(["error" => "Nombre o contraseña no proporcionados"]);
}

$conn->close();
?>
