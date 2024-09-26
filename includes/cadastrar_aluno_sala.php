<?php
include 'db.php';

// Buscando alunos e salas cadastradas
$sql_alunos = "SELECT matricula_aluno, nome_aluno FROM aluno";
$result_alunos = mysqli_query($conn, $sql_alunos);

$sql_salas = "SELECT id_sala, ano_sala FROM salas";
$result_salas = mysqli_query($conn, $sql_salas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno na Sala</title>
</head>
<body>
    <h2>Cadastrar Aluno na Sala</h2>
    <form action="../includes/aluno_sala.php" method="POST">
        <label for="aluno_sa">Aluno:</label>
        <select id="aluno_sa" name="aluno_sa" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_alunos)) {
                echo "<option value='".$row['matricula_aluno']."'>".$row['nome_aluno']."</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="sala_sa">Sala:</label>
        <select id="sala_sa" name="sala_sa" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_salas)) {
                echo "<option value='".$row['id_sala']."'>Sala Ano: ".$row['ano_sala']."</option>";
            }
            ?>
        </select>
        <br><br>

        <input type="submit" value="Cadastrar Aluno na Sala">
    </form>
</body>
</html>
