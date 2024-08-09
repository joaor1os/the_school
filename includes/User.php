<?php
// User.php
class User {
    protected $email;
    protected $senha;
    protected $tipo_usuario;
    protected $conn;

    public function __construct($email, $senha, $tipo_usuario, $conn) {
        $this->email = $email;
        $this->senha = $senha;
        $this->tipo_usuario = $tipo_usuario;
        $this->conn = $conn;
    }

    public static function login($email, $senha, $tipo_usuario, $conn) {
        switch ($tipo_usuario) {
            case 1:
                $user = new Instituicao($email, $senha, $tipo_usuario, $conn);
                break;
            case 2:
                $user = new Professor($email, $senha, $tipo_usuario, $conn);
                break;
            case 3:
                $user = new Aluno($email, $senha, $tipo_usuario, $conn);
                break;
            default:
                header("location: ../login.html?error=1");
                exit();
        }
        return $user->authenticate();
    }

    protected function authenticate() {
        // Implementação específica em cada subclasse
    }
}

class Instituicao extends User {
    protected function authenticate() {
        $sql = "SELECT id_inst, email, senha FROM instituicao WHERE email = ?";
        return $this->executeQuery($sql);
    }

    protected function executeQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $db_email, $db_senha);
            $stmt->fetch();

            // Verificar a senha criptografada
            if (password_verify($this->senha, $db_senha)) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $this->email;
                $_SESSION['tipo_usuario'] = $this->tipo_usuario;
                $_SESSION['id_usuario'] = $id_usuario; // Adicionando o ID do usuário à sessão
                header("location: ../index.php");
            } else {
                header("location: ../login.html?error=1");
            }
        } else {
            header("location: ../login.html?error=1");
        }

        $stmt->close();
    }
}

class Professor extends User {
    protected function authenticate() {
        $sql = "SELECT id_professor, email, senha FROM professor WHERE email = ?";
        return $this->executeQuery($sql);
    }

    protected function executeQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $db_email, $db_senha);
            $stmt->fetch();

            // Verificar a senha criptografada
            if (password_verify($this->senha, $db_senha)) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $this->email;
                $_SESSION['tipo_usuario'] = $this->tipo_usuario;
                $_SESSION['id_usuario'] = $id_usuario; // Adicionando o ID do usuário à sessão
                header("location: ../index.php");
            } else {
                header("location: ../login.html?error=1");
            }
        } else {
            header("location: ../login.html?error=1");
        }

        $stmt->close();
    }
}

class Aluno extends User {
    protected function authenticate() {
        $sql = "SELECT matricula_aluno, email, senha FROM aluno WHERE email = ?";
        return $this->executeQuery($sql);
    }

    protected function executeQuery($sql) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $db_email, $db_senha);
            $stmt->fetch();

            // Verificar a senha criptografada
            if (password_verify($this->senha, $db_senha)) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $this->email;
                $_SESSION['tipo_usuario'] = $this->tipo_usuario;
                $_SESSION['id_usuario'] = $id_usuario; // Adicionando o ID do usuário à sessão
                header("location: ../index.php");
            } else {
                header("location: ../login.html?error=1");
            }
        } else {
            header("location: ../login.html?error=1");
        }

        $stmt->close();
    }
}
?>
