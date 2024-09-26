<?php

include_once 'db.php';
include_once 'EmailSender.php';

class Aluno {
    private $conn;
    private $table_name = "aluno";

    private $matricula_aluno;
    private $cpf_aluno;
    private $nome_aluno;
    private $data_nascimento_aluno;
    private $sexo_aluno;
    private $situacao_aluno = 1; // Padrão ativo
    private $contato_aluno;
    private $tipo_usuario = 3; // Tipo de usuário para Aluno
    private $email;
    private $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getters e Setters
    public function getMatriculaAluno() { return $this->matricula_aluno; }
    public function setMatriculaAluno($matricula_aluno) { $this->matricula_aluno = $matricula_aluno; }

    public function getCpfAluno() { return $this->cpf_aluno; }
    public function setCpfAluno($cpf_aluno) { $this->cpf_aluno = $cpf_aluno; }

    public function getNomeAluno() { return $this->nome_aluno; }
    public function setNomeAluno($nome_aluno) { $this->nome_aluno = $nome_aluno; }

    public function getDataNascimentoAluno() { return $this->data_nascimento_aluno; }
    public function setDataNascimentoAluno($data_nascimento_aluno) { $this->data_nascimento_aluno = $data_nascimento_aluno; }

    public function getSexoAluno() { return $this->sexo_aluno; }
    public function setSexoAluno($sexo_aluno) { $this->sexo_aluno = $sexo_aluno; }

    public function getSituacaoAluno() { return $this->situacao_aluno; }
    public function setSituacaoAluno($situacao_aluno) { $this->situacao_aluno = $situacao_aluno; }

    public function getContatoAluno() { return $this->contato_aluno; }
    public function setContatoAluno($contato_aluno) { $this->contato_aluno = $contato_aluno; }

    public function getTipoUsuario() { return $this->tipo_usuario; }
    public function setTipoUsuario($tipo_usuario) { $this->tipo_usuario = $tipo_usuario; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; }

    // Verificação se o CPF já existe no banco de dados
    private function cpfExists() {
        $query = "SELECT cpf_aluno FROM " . $this->table_name . " WHERE cpf_aluno = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $cpf = $this->getCpfAluno(); // Pega o valor do CPF
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    // Verificação se o e-mail já existe no banco de dados
    private function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $email = $this->getEmail(); // Pega o valor do email
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    // Método para cadastrar o aluno
    public function cadastrar() {
        // Verifica se o CPF já está cadastrado
        if ($this->cpfExists()) {
            echo "Erro: O CPF já está cadastrado.";
            return false;
        }

        // Verifica se o email já está cadastrado
        if ($this->emailExists()) {
            echo "Erro: O e-mail já está cadastrado.";
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (cpf_aluno, nome_aluno, data_nascimento_aluno, sexo_aluno, situacao_aluno, contato_aluno, tipo_usuario, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Armazenar valores em variáveis
        $cpf_aluno = $this->getCpfAluno();
        $nome_aluno = $this->getNomeAluno();
        $data_nascimento_aluno = $this->getDataNascimentoAluno();
        $sexo_aluno = $this->getSexoAluno();
        $situacao_aluno = $this->getSituacaoAluno();
        $contato_aluno = $this->getContatoAluno();
        $tipo_usuario = $this->tipo_usuario;
        $email = $this->getEmail();
        $senha_criptografada = password_hash($this->getSenha(), PASSWORD_DEFAULT);

        // Passar variáveis para o bind_param
        $stmt->bind_param("ssssssiss", 
            $cpf_aluno, 
            $nome_aluno, 
            $data_nascimento_aluno, 
            $sexo_aluno, 
            $situacao_aluno, 
            $contato_aluno, 
            $tipo_usuario, 
            $email, 
            $senha_criptografada
        );

        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            echo "Erro ao cadastrar o aluno.";
            return false;
        }
    }

    public function buscarPorNomeOuCpf($busca) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome_aluno LIKE ? OR cpf_aluno = ?";
        $stmt = $this->conn->prepare($query);
        
        // Adiciona % para busca parcial
        $buscaParam = "%$busca%";
        $stmt->bind_param('ss', $buscaParam, $busca); // vincula os parâmetros
        
        $stmt->execute();
        $result = $stmt->get_result(); // Obtém o resultado da execução
        return $result->fetch_all(MYSQLI_ASSOC); // Retorna todos os resultados como um array associativo
    }

    // Método para atualizar aluno
    public function atualizar($id_aluno) {
        $query = "UPDATE " . $this->table_name . " SET nome_aluno = ?, cpf_aluno = ?, data_nascimento_aluno = ?, sexo_aluno = ?, situacao_aluno = ?, contato_aluno = ?, email = ? WHERE id_aluno = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Binding dos parâmetros
        $stmt->bind_param(
            'sssssssi',
            $this->nome_aluno,
            $this->cpf_aluno,
            $this->data_nascimento_aluno,
            $this->sexo_aluno,
            $this->situacao_aluno,
            $this->contato_aluno,
            $this->email,
            $id_aluno
        );
        
        return $stmt->execute();
    }

    // Método para deletar aluno
    public function deletar($id_aluno) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_aluno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id_aluno); // Assume que id_aluno é um inteiro
        
        return $stmt->execute();
    }

    // Função para enviar o e-mail
    private function sendEmail() {
        $subject = 'Cadastro de Aluno';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->getSenha();
        sendEmail($this->getEmail(), $subject, $body);
    }

    // Geração da senha automática
    public function generateAndSetPassword() {
        $this->setSenha($this->generatePassword());
    }

    private function generatePassword($length = 16) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }
}
?>
