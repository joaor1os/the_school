<?php
session_start();

// Verifica se o usuário está logado e é um administrador ou professor
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: login.php");
    exit;
}

include_once 'db.php';
include_once '../includes/class/Professor.php';

$database = new Database();
$db = $database->conn;

$professor = new Professor($db);
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cadastrar novo professor
    $professor->setNomeProfessor($_POST['nome_professor']);
    $professor->setCpfProfessor($_POST['cpf_professor']);
    $professor->setFormacaoProfessor($_POST['formacao_professor']);
    $professor->setDataNascimentoProfessor($_POST['data_nascimento_professor']);
    $professor->setSexoProfessor($_POST['sexo_professor']);
    $professor->setSituacaoProfessor($_POST['situacao_professor']);
    $professor->setContatoProfessor($_POST['contato_professor']);
    $professor->setEmail($_POST['email']);
    $professor->generateAndSetPassword(); // Gera e define a senha automaticamente

    if ($professor->cadastrar()) {
        $mensagem = "Professor cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar professor.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Professor</title>
    <script>
        // Função para validar CPF (exemplo simples, pode ser adaptado para uma validação completa)
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove qualquer caractere que não seja número
            if (cpf.length !== 11) {
                return false;
            }
            return true;
        }

        // Função para validar o formulário
        function validarFormulario() {
            var nome = document.getElementById("nome_professor").value;
            var cpf = document.getElementById("cpf_professor").value;
            var email = document.getElementById("email").value;
            var contato = document.getElementById("contato_professor").value;

            var errorMessage = "";

            // Verifica se o nome está preenchido
            if (nome === "") {
                errorMessage += "O campo Nome é obrigatório.\n";
            }

            // Valida o CPF
            if (!validarCPF(cpf)) {
                errorMessage += "CPF inválido. Deve conter 11 dígitos.\n";
            }

            // Verifica se o email está no formato correto
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage += "Formato de email inválido.\n";
            }

            // Verifica se o campo de contato está preenchido
            if (contato === "") {
                errorMessage += "O campo Contato é obrigatório.\n";
            }

            // Exibe os erros, se houver
            if (errorMessage !== "") {
                alert(errorMessage);  // Mostra os erros em um alert
                return false;  // Impede o envio do formulário
            }

            return true;  // Permite o envio do formulário se não houver erros
        }
    </script>
</head>
<body>
    <h1>Cadastrar Novo Professor</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="POST" action="cadastrar_professor.php" onsubmit="return validarFormulario();">
        <label for="nome_professor">Nome:</label>
        <input type="text" id="nome_professor" name="nome_professor" required><br><br>

        <label for="cpf_professor">CPF:</label>
        <input type="text" id="cpf_professor" name="cpf_professor" required><br><br>

        <label for="formacao_professor">Formação:</label>
        <input type="text" id="formacao_professor" name="formacao_professor" required><br><br>

        <label for="data_nascimento_professor">Data de Nascimento:</label>
        <input type="date" id="data_nascimento_professor" name="data_nascimento_professor" required><br><br>

        <label for="sexo_professor">Sexo:</label>
        <select id="sexo_professor" name="sexo_professor" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br><br>

        <label for="situacao_professor">Situação:</label>
        <select id="situacao_professor" name="situacao_professor" required>
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
        </select><br><br>

        <label for="contato_professor">Contato:</label>
        <input type="text" id="contato_professor" name="contato_professor" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="../includes/gerenciar_professor.php">Voltar para Gerenciamento de Professores</a>
</body>
</html>
