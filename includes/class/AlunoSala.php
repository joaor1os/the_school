<?php

include_once 'db.php';

class AlunoSala {
    private $id_sa;
    private $aluno_sa;
    private $sala_sa;

    // Construtor
    public function __construct($aluno_sa, $sala_sa) {
        $this->aluno_sa = $aluno_sa;
        $this->sala_sa = $sala_sa;
    }

    // Getter e Setter para id_sa
    public function getIdSa() {
        return $this->id_sa;
    }

    public function setIdSa($id_sa) {
        $this->id_sa = $id_sa;
    }

    // Getter e Setter para aluno_sa
    public function getAlunoSa() {
        return $this->aluno_sa;
    }

    public function setAlunoSa($aluno_sa) {
        $this->aluno_sa = $aluno_sa;
    }

    // Getter e Setter para sala_sa
    public function getSalaSa() {
        return $this->sala_sa;
    }

    public function setSalaSa($sala_sa) {
        $this->sala_sa = $sala_sa;
    }

    // Método para salvar aluno na sala no banco
    public function salvar($conn) {
        $sql = "INSERT INTO sala_alunos (aluno_sa, sala_sa) VALUES ('$this->aluno_sa', '$this->sala_sa')";
        if (mysqli_query($conn, $sql)) {
            echo "Aluno cadastrado na sala com sucesso!";
        } else {
            echo "Erro: " . mysqli_error($conn);
        }
    }
}


?>