<?php
session_start();

// Verifique se a sessão está definida e se o administrador está autenticado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial do Administrador</title>
</head>
<body>
    <h1>Bem-vindo, Administrador!</h1>
    <a href="cadastrar_instituicao.php">Cadastrar Nova Instituição</a>
</body>
</html>
