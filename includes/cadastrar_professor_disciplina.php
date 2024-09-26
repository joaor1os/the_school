<?php
include 'db.php';

// Buscando disciplinas, professores e salas
$sql_disciplinas = "SELECT id_disciplina, nome_disciplina FROM disciplinas";
$result_disciplinas = mysqli_query($conn, $sql_disciplinas);

$sql_professores = "SELECT id_professor, nome_professor FROM professor";
$result_professores = mysqli_query($conn, $sql_professores);

$sql_salas = "SELECT id_sala, ano_sala FROM salas";
$result_salas = mysqli_query($conn, $sql_salas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Vincular Professor à Disciplina</title>
</head>
<body>
    <h2>Vincular Professor à Disciplina</h2>
    <form action="../includes/class/ProfessorDisciplina.php" method="POST">
        <label for="disc_sala">Disciplina:</label>
        <select id="disc_sala" name="disc_sala" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_disciplinas)) {
                echo "<option value='".$row['id_disciplina']."'>".$row['nome_disciplina']."</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="disc_prof">Professor:</label>
        <select id="disc_prof" name="disc_prof" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_professores)) {
                echo "<option value='".$row['id_professor']."'>".$row['nome_professor']."</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="sala">Sala:</label>
        <select id="sala" name="sala" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_salas)) {
                echo "<option value='".$row['id_sala']."'>Sala Ano: ".$row['ano_sala']."</option>";
            }
            ?>
        </select>
        <br><br>

        <input type="submit" value="Vincular Professor">
    </form>
</body>
</html>
