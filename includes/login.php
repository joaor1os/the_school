<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Verificar a tabela correspondente com base no tipo de usuário
    switch ($tipo_usuario) {
        case 1: // Instituição
            $sql = "SELECT id_inst, email, senha FROM instituicao WHERE email = ? AND senha = ?";
            break;
        case 2: // Professor
            $sql = "SELECT id_professor, email, senha FROM professor WHERE email = ? AND senha = ?";
            break;
        case 3: // Aluno
            $sql = "SELECT matricula_aluno, email, senha FROM aluno WHERE email = ? AND senha = ?";
            break;
        default:
            header("location: ../login.html?error=1");
            exit();
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $db_email, $db_senha);
        $stmt->fetch();

        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['tipo_usuario'] = $tipo_usuario;
        $_SESSION['id_usuario'] = $id_usuario; // Adicionando o ID do usuário à sessão
        header("location: ../index.php");
    } else {
        header("location: ../login.html?error=1");
    }

    $stmt->close();
    $conn->close();
}
?>
