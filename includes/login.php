<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $sql = "SELECT id_usuario, tipo_usuario FROM usuarios WHERE email = ? AND senha = ? AND tipo_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $email, $senha, $tipo_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['tipo_usuario'] = $tipo_usuario;
        header("location: ../index.php");
    } else {
        header("location: ../login.html?error=1");
    }

    $stmt->close();
    $conn->close();
}
?>
