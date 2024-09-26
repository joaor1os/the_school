<?php
include_once 'db.php';
include_once '../includes/class/Instituicao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->conn;

    $instituicao = new Instituicao($db);
    $instituicao->setNomeInst($_POST['nome_inst']);
    $instituicao->setCnpj($_POST['cnpj']);
    $instituicao->setEmail($_POST['email']);
    $instituicao->generateAndSetPassword(); // Gera e define a senha automaticamente

    if ($instituicao->cadastrar()) {
        echo "Instituição cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar instituição.";
    }

    $database->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Instituição</title>
</head>
<body>
    <h1>Cadastrar Nova Instituição</h1>
    <form action="cadastrar_instituicao.php" method="POST">
        <label for="nome_inst">Nome da Instituição:</label>
        <input type="text" id="nome_inst" name="nome_inst" required><br><br>

        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="cnpj" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
    <a href="admin_home.php">Voltar</a>
</body>
</html>

