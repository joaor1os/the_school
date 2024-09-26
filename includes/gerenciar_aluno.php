<?php
session_start();

// Verifica se o usuário está logado e é um administrador ou professor
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: login.php");
    exit;
}

include_once 'db.php';
include_once '../includes/class/Aluno.php';

$database = new Database();
$db = $database->conn;

$aluno = new Aluno($db);
$alunos = [];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        // Busca aluno pelo nome ou CPF
        $busca = $_POST['busca'];
        $alunos = $aluno->buscarPorNomeOuCpf($busca);
    } elseif (isset($_POST['editar'])) {
        // Atualiza aluno
        $id_aluno = $_POST['id_aluno'];
        $aluno->setNomeAluno($_POST['nome_aluno']);
        $aluno->setCpfAluno($_POST['cpf_aluno']);
        $aluno->setDataNascimentoAluno($_POST['data_nascimento_aluno']);
        $aluno->setSexoAluno($_POST['sexo_aluno']);
        $aluno->setSituacaoAluno($_POST['situacao_aluno']);
        $aluno->setContatoAluno($_POST['contato_aluno']);
        $aluno->setEmail($_POST['email']);

        if ($aluno->atualizar($id_aluno)) {
            $mensagem = "Aluno atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar aluno.";
        }
    } elseif (isset($_POST['deletar'])) {
        // Deleta aluno
        $id_aluno = $_POST['id_aluno'];

        if ($aluno->deletar($id_aluno)) {
            $mensagem = "Aluno deletado com sucesso!";
        } else {
            $mensagem = "Erro ao deletar aluno.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Alunos</title>
</head>
<body>
    <h1>Gerenciar Alunos</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <!-- Formulário de busca -->
    <form method="POST" action="gerenciar_aluno.php">
        <label for="busca">Nome ou CPF:</label>
        <input type="text" id="busca" name="busca" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <!-- Resultados da busca -->
    <?php if (!empty($alunos)) : ?>
        <h2>Resultados da Busca:</h2>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($alunos as $alu) : ?>
                <tr>
                    <td><?= $alu['nome_aluno']; ?></td>
                    <td><?= $alu['cpf_aluno']; ?></td>
                    <td><?= $alu['email']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_aluno" value="<?= $alu['id_aluno']; ?>">
                            <button type="submit" name="editar_form">Editar</button>
                            <button type="submit" name="deletar">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_POST['buscar'])) : ?>
        <p>Nenhum aluno encontrado.</p>
    <?php endif; ?>

    <!-- Botão para acessar a página de cadastro -->
    <br>
    <a href="cadastrar_aluno.php"><button>Cadastrar Novo Aluno</button></a>

    <br><br>
    <a href="../index.php">Voltar</a>
</body>
</html>
