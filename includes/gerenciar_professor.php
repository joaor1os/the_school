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
$professores = [];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        // Busca professor pelo nome ou CPF
        $busca = $_POST['busca'];
        $professores = $professor->buscarPorNomeOuCpf($busca);
    } elseif (isset($_POST['editar'])) {
        // Atualiza professor
        $id_professor = $_POST['id_professor'];
        $professor->setNomeProfessor($_POST['nome_professor']);
        $professor->setCpfProfessor($_POST['cpf_professor']);
        $professor->setFormacaoProfessor($_POST['formacao_professor']);
        $professor->setDataNascimentoProfessor($_POST['data_nascimento_professor']);
        $professor->setSexoProfessor($_POST['sexo_professor']);
        $professor->setSituacaoProfessor($_POST['situacao_professor']);
        $professor->setContatoProfessor($_POST['contato_professor']);
        $professor->setEmail($_POST['email']);

        if ($professor->atualizar($id_professor)) {
            $mensagem = "Professor atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar professor.";
        }
    } elseif (isset($_POST['deletar'])) {
        // Deleta professor
        $id_professor = $_POST['id_professor'];

        if ($professor->deletar($id_professor)) {
            $mensagem = "Professor deletado com sucesso!";
        } else {
            $mensagem = "Erro ao deletar professor.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Professor</title>
</head>
<body>
    <h1>Gerenciar Professor</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <!-- Formulário de busca -->
    <form method="POST" action="gerenciar_professor.php">
        <label for="busca">Nome ou CPF:</label>
        <input type="text" id="busca" name="busca" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <!-- Resultados da busca -->
    <?php if (!empty($professores)) : ?>
        <h2>Resultados da Busca:</h2>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($professores as $prof) : ?>
                <tr>
                    <td><?= $prof['nome_professor']; ?></td>
                    <td><?= $prof['cpf_professor']; ?></td>
                    <td><?= $prof['email']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_professor" value="<?= $prof['id_professor']; ?>">
                            <button type="submit" name="editar_form">Editar</button>
                            <button type="submit" name="deletar">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_POST['buscar'])) : ?>
        <p>Nenhum professor encontrado.</p>
    <?php endif; ?>

    <!-- Botão para acessar a página de cadastro -->
    <br>
    <a href="cadastrar_professor.php"><button>Cadastrar Novo Professor</button></a>

    <br><br>
    <a href="../index.php">Voltar</a>
</body>
</html>
