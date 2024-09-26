<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado e se é um professor
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    // Redireciona para a página de login ou exibe mensagem de erro
    header("Location: login.php");
    exit;
}

include_once 'db.php';
include_once '../includes/class/Aluno.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->conn;

    $aluno = new Aluno($db);
    $aluno->setNomeAluno($_POST['nome_aluno']);
    $aluno->setCpfAluno($_POST['cpf_aluno']);
    $aluno->setDataNascimentoAluno($_POST['data_nascimento_aluno']);
    $aluno->setSexoAluno($_POST['sexo_aluno']);
    $aluno->setContatoAluno($_POST['contato_aluno']);
    $aluno->setEmail($_POST['email']);
    $aluno->generateAndSetPassword(); // Gera a senha automaticamente

    if ($aluno->cadastrar()) {
        $mensagem = "Aluno cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar o aluno. Verifique os dados e tente novamente.";
    }

    $database->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
</head>
<body>
    <h1>Cadastrar Novo Aluno</h1>

    <?php
    // Exibe a mensagem de sucesso ou erro após o cadastro
    if (isset($mensagem)) {
        echo "<p>$mensagem</p>";
    }
    ?>
    
    <form action="cadastrar_aluno.php" method="POST">
        <label for="nome_aluno">Nome do Aluno:</label>
        <input type="text" id="nome_aluno" name="nome_aluno" required><br><br>

        <label for="cpf_aluno">CPF:</label>
        <input type="text" id="cpf_aluno" name="cpf_aluno" required><br><br>

        <label for="data_nascimento_aluno">Data de Nascimento:</label>
        <input type="date" id="data_nascimento_aluno" name="data_nascimento_aluno" required><br><br>

        <label for="sexo_aluno">Sexo:</label>
        <select id="sexo_aluno" name="sexo_aluno" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br><br>

        <label for="contato_aluno">Contato:</label>
        <input type="text" id="contato_aluno" name="contato_aluno" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="../includes/gerenciar_aluno.php">Voltar</a>
</body>
</html>
