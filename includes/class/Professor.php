<?php
include_once 'db.php';
include_once 'EmailSender.php';

class Professor {
    private $conn;
    private $table_name = "professor";

    private $nome_professor;
    private $cpf_professor;
    private $formacao_professor;
    private $data_nascimento_professor;
    private $sexo_professor;
    private $situacao_professor;
    private $contato_professor;
    private $tipo_usuario = 2; // Tipo de usuário para Professor
    private $email;
    private $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Setters
    public function setNomeProfessor($nome_professor) {
        $this->nome_professor = $nome_professor;
    }

    public function setCpfProfessor($cpf_professor) {
        $this->cpf_professor = $cpf_professor;
    }

    public function setFormacaoProfessor($formacao_professor) {
        $this->formacao_professor = $formacao_professor;
    }

    public function setDataNascimentoProfessor($data_nascimento_professor) {
        $this->data_nascimento_professor = $data_nascimento_professor;
    }

    public function setSexoProfessor($sexo_professor) {
        $this->sexo_professor = $sexo_professor;
    }

    public function setSituacaoProfessor($situacao_professor) {
        $this->situacao_professor = $situacao_professor;
    }

    public function setContatoProfessor($contato_professor) {
        $this->contato_professor = $contato_professor;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    // Getters
    public function getNomeProfessor() {
        return $this->nome_professor;
    }

    public function getCpfProfessor() {
        return $this->cpf_professor;
    }

    public function getFormacaoProfessor() {
        return $this->formacao_professor;
    }

    public function getDataNascimentoProfessor() {
        return $this->data_nascimento_professor;
    }

    public function getSexoProfessor() {
        return $this->sexo_professor;
    }

    public function getSituacaoProfessor() {
        return $this->situacao_professor;
    }

    public function getContatoProfessor() {
        return $this->contato_professor;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    private function cpfExists() {
        $query = "SELECT cpf_professor FROM " . $this->table_name . " WHERE cpf_professor = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $cpf = $this->getCpfProfessor(); // Pega o valor do CPF
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    // Método para cadastrar o professor
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

        $query = "INSERT INTO " . $this->table_name . " (cpf_professor, nome_professor, formacao_professor, data_nascimento_professor, sexo_professor, situacao_professor, contato_professor, tipo_usuario, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Armazenar valores em variáveis
        $cpf_professor = $this->getCpfProfessor();
        $nome_professor = $this->getNomeProfessor();
        $formacao_professor = $this->getFormacaoProfessor();
        $data_nascimento_professor = $this->getDataNascimentoProfessor();
        $sexo_professor = $this->getSexoProfessor();
        $situacao_professor = $this->getSituacaoProfessor();
        $contato_professor = $this->getContatoProfessor();
        $tipo_usuario = $this->tipo_usuario;
        $email = $this->getEmail();
        $senha_criptografada = password_hash($this->getSenha(), PASSWORD_DEFAULT);

        // Passar variáveis para o bind_param
        $stmt->bind_param("ssssssisss", 
            $cpf_professor, 
            $nome_professor, 
            $formacao_professor, 
            $data_nascimento_professor, 
            $sexo_professor, 
            $situacao_professor, 
            $contato_professor, 
            $tipo_usuario, 
            $email, 
            $senha_criptografada
        );

        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            echo "Erro ao cadastrar o professor.";
            return false;
        }
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

    // Função para enviar o e-mail
    private function sendEmail() {
        $subject = 'Cadastro de Professor';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->getSenha();
        sendEmail($this->getEmail(), $subject, $body);
    }

    public function buscarPorId($id_professor) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_professor = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_professor);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function buscarPorNomeOuCpf($busca) {
        // Consulta SQL para buscar pelo nome ou CPF
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE nome_professor LIKE ? 
                  OR cpf_professor = ?";

        // Preparar a consulta
        if ($stmt = $this->conn->prepare($query)) {
            // Adiciona os percentuais para a busca parcial com LIKE
            $busca_como = "%" . $busca . "%";

            // Bind dos parâmetros (nome com LIKE e CPF exato)
            $stmt->bind_param("ss", $busca_como, $busca);

            // Executa a consulta
            $stmt->execute();

            // Obtém o resultado
            $result = $stmt->get_result();

            // Verifica se houve resultados
            if ($result->num_rows > 0) {
                // Retorna os resultados como array associativo
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                // Caso não encontre nenhum resultado
                return [];
            }
        } else {
            echo "Erro ao preparar a consulta: " . $this->conn->error;
            return false;
        }
    }
    

    public function atualizar($id_professor) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome_professor = ?, cpf_professor = ?, formacao_professor = ?, data_nascimento_professor = ?, sexo_professor = ?, situacao_professor = ?, contato_professor = ?, email = ?
                  WHERE id_professor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssi", 
            $this->nome_professor, 
            $this->cpf_professor, 
            $this->formacao_professor, 
            $this->data_nascimento_professor, 
            $this->sexo_professor, 
            $this->situacao_professor, 
            $this->contato_professor, 
            $this->email,
            $id_professor
        );
        return $stmt->execute();
    }
    

    public function deletar($id_professor) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_professor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_professor);
        return $stmt->execute();
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

