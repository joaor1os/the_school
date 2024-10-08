<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Início</a>
        <a href="includes/logout.php" style="float:right">Logout</a>
    </div>
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['email']; ?>!</h1>

        <?php
        if ($_SESSION['tipo_usuario'] == 1) {
            // Área da Instituição
            echo '
            <h2>Área da Instituição</h2>
            <ul>
                <li><a href="instituicao/cadastrar_usuario.php">Cadastrar Usuários</a></li>
                <li><a href="instituicao/cadastrar_serie.php">Cadastrar Séries</a></li>
                <li><a href="instituicao/cadastrar_disciplina.php">Cadastrar Disciplinas</a></li>
                <li><a href="instituicao/cadastrar_aula.php">Cadastrar Aulas</a></li>
                <li><a href="instituicao/cadastrar_sala.php">Cadastrar Salas de Aula</a></li>
            </ul>';
        } elseif ($_SESSION['tipo_usuario'] == 2) {
            // Área do Professor
            echo '
            <h2>Área do Professor</h2>
            <ul>
                <li><a href="professor/acessar_sala.php">Acessar Salas de Aula</a></li>
                <li><a href="professor/cadastrar_presenca.php">Cadastrar Presença</a></li>
            </ul>';
        } elseif ($_SESSION['tipo_usuario'] == 3) {
            // Área do Aluno (opcional)
            echo '
            <h2>Área do Aluno</h2>
            <p>Bem-vindo, aluno!</p>';
        }
        ?>
    </div>
</body>
</html>
