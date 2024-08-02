<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] != 2) {
    header('Location: ../login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acessar Sala</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <a href="../index.php">Início</a>
        <a href="../includes/logout.php" style="float:right">Logout</a>
    </div>
    <div class="container">
        <h1>Acessar Sala</h1>
        <p>Conteúdo para acessar salas de aula.</p>
        <a href="../index.php">Voltar</a>
    </div>
</body>
</html>
