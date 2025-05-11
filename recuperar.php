<?php
include 'db.php'; // Conexión con la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($contrasena);
        $stmt->fetch();
        echo "Tu contraseña es: $contrasena";
        // ⚠️ Solo para pruebas. En producción debes enviar un correo o usar tokens.
    } else {
        echo "Correo no registrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
