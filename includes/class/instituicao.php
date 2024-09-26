<?php
include_once 'db.php';
include_once 'EmailSender.php';

class Instituicao {
    private $conn;
    private $table_name = "instituicao";

    private $nome_inst;
    private $cnpj;
    private $email;
    private $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Setters
    public function setNomeInst($nome_inst) {
        $this->nome_inst = $nome_inst;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    // Getters
    public function getNomeInst() {
        return $this->nome_inst;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function cadastrar() {
        if ($this->emailExists()) {
            echo "Erro: O e-mail já está cadastrado.";
            return false;
        }
    
        $query = "INSERT INTO " . $this->table_name . " (nome_inst, cnpj, tipo_usuario, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        // Armazenar valores em variáveis antes de passá-las para o bind_param
        $senha_criptografada = password_hash($this->getSenha(), PASSWORD_DEFAULT);
        $tipo_usuario = 1; // Tipo de usuário para Instituição
        $nome_inst = $this->getNomeInst();
        $cnpj = $this->getCnpj();
        $email = $this->getEmail();
    
        // Passar variáveis por referência para bind_param
        $stmt->bind_param("ssiss", $nome_inst, $cnpj, $tipo_usuario, $email, $senha_criptografada);
    
        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            echo "Erro ao cadastrar a instituição.";
            return false;
        }
    }
    

    public function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        // Armazenar o valor do email em uma variável antes de passá-lo ao bind_param
        $email = $this->getEmail();
    
        // Passar a variável $email por referência
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        return $stmt->num_rows > 0;
    }
    
    private function generatePassword($length = 16) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    private function sendEmail() {
        $subject = 'Cadastro de Instituição';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->getSenha();
        sendEmail($this->getEmail(), $subject, $body);
    }

    public function generateAndSetPassword() {
        $this->setSenha($this->generatePassword());
    }
}
?>

