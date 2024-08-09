<?php
include_once 'db.php';
include_once 'EmailSender.php';

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
        if ($this->emailExists()) {
            echo "Erro: O e-mail já está cadastrado.";
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (nome_inst, cnpj, tipo_usuario, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $senha_criptografada = password_hash($this->senha, PASSWORD_DEFAULT);
        $tipo_usuario = 1; // Tipo de usuário para Instituição

        $stmt->bind_param("ssiss", $this->nome_inst, $this->cnpj, $tipo_usuario, $this->email, $senha_criptografada);

        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            echo "Erro ao cadastrar a instituição.";
            return false;
        }
    }

    private function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    private function generatePassword($length = 16) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    private function sendEmail() {
        $subject = 'Cadastro de Instituição';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->senha;
        sendEmail($this->email, $subject, $body);
    }

    public function generateAndSetPassword() {
        $this->senha = $this->generatePassword();
    }
}
?>
