<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$nombre = $data['nombre'];
$email = $data['email'];
$pass = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["error" => "El correo ya está registrado."]);
} else {
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $pass);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al registrar."]);
    }
}
$conn->close();
?>
