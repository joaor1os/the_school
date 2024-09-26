<?php

include_once 'db.php';

class Disciplina {
    private $id_disciplina;
    private $nome_disciplina;

    // Construtor
    public function __construct($nome_disciplina) {
        $this->nome_disciplina = $nome_disciplina;
    }

    // Getter e Setter para id_disciplina
    public function getIdDisciplina() {
        return $this->id_disciplina;
    }

    public function setIdDisciplina($id_disciplina) {
        $this->id_disciplina = $id_disciplina;
    }

    // Getter e Setter para nome_disciplina
    public function getNomeDisciplina() {
        return $this->nome_disciplina;
    }

    public function setNomeDisciplina($nome_disciplina) {
        $this->nome_disciplina = $nome_disciplina;
    }

    // Método para salvar disciplina no banco
    public function salvar($conn) {
        $sql = "INSERT INTO disciplinas (nome_disciplina) VALUES ('$this->nome_disciplina')";
        if (mysqli_query($conn, $sql)) {
            echo "Disciplina cadastrada com sucesso!";
        } else {
            echo "Erro: " . mysqli_error($conn);
        }
    }
}

?>
