<?php
class Instituicao {
    private $conn;
    private $table_name = "instituicao";

    public $nome_inst;
    public $cnpj;
    public $email;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " (nome_inst, cnpj, tipo_usuario, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $senha_criptografada = password_hash($this->senha, PASSWORD_DEFAULT);
        $tipo_usuario = 1; // Tipo de usuário para Instituição

        $stmt->bind_param("ssiss", $this->nome_inst, $this->cnpj, $tipo_usuario, $this->email, $senha_criptografada);

        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            return false;
        }
    }

    private function generatePassword($length = 8) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    private function sendEmail() {
        $subject = "Cadastro de Instituição";
        $message = "Sua conta foi criada com sucesso. Sua senha é: " . $this->senha;
        $headers = 'From: bdtcc@email.com' . "\r\n" .
                   'Reply-To: bdtcc@email.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($this->email, $subject, $message, $headers);
    }

    public function generateAndSetPassword() {
        $this->senha = $this->generatePassword();
    }
}
?>