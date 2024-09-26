<?php
// login.php
include 'db.php';
include '../includes/class/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $db = new Database();
    User::login($email, $senha, $tipo_usuario, $db->conn);
    $db->close();
}
?>
