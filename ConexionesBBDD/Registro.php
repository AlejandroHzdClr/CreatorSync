<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Validar datos
    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        echo json_encode(["error" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Hash de la contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Registro creado exitosamente"]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Método de solicitud no válido."]);
}

$conn->close();
?>