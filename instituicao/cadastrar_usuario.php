<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] != 1) {
    header('Location: ../login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <a href="../index.php">Início</a>
        <a href="../includes/logout.php" style="float:right">Logout</a>
    </div>
    <div class="container">
        <h1>Cadastrar Usuário</h1>
        <form action="processar_cadastro_usuario.php" method="post">
            <label for="tipo_usuario">Tipo de Usuário:</label>
            <select id="tipo_usuario" name="tipo_usuario">
                <option value="2">Professor</option>
                <option value="3">Aluno</option>
            </select>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <input type="submit" value="Cadastrar">
        </form>
        <a href="../index.php">Voltar</a>
    </div>
</body>
</html>
