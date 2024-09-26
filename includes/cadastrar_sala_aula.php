<?php
include 'db.php'; // Conexão com o banco

// Buscando séries cadastradas no banco
$sql_series = "SELECT id_serie, nome_serie FROM serie";
$result_series = mysqli_query($conn, $sql_series);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Sala de Aula</title>
</head>
<body>
    <h2>Cadastrar Sala de Aula</h2>
    <form action="../includes/salas.php" method="POST">
        <label for="ano_sala">Ano da Sala:</label>
        <input type="number" id="ano_sala" name="ano_sala" required>
        <br><br>

        <label for="serie_sala">Série:</label>
        <select id="serie_sala" name="serie_sala" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_series)) {
                echo "<option value='".$row['id_serie']."'>".$row['nome_serie']."</option>";
            }
            ?>
        </select>
        <br><br>

        <input type="submit" value="Cadastrar Sala">
    </form>
</body>
</html>
