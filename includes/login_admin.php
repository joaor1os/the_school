<?php
include_once 'db.php';
include_once 'Admin.php';

session_start();

$database = new Database();
$db = $database->conn;

$admin = new Admin($db);

$admin->email_admin = $_POST['email'];
$admin->senha_admin = $_POST['senha'];

if ($admin->login()) {
    // Definindo a variável de sessão
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $admin->id_admin; // Opcional, se precisar do ID do administrador
    $_SESSION['admin_name'] = $admin->nome_admin; // Opcional, se precisar do nome do administrador
    header("Location: admin_home.php");
    exit();
} else {
    echo "Email ou senha incorretos.";
}

$database->close();
?>
