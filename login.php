<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashedPassword);

if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Correo o contraseña incorrectos."]);
}

$conn->close();
?>
