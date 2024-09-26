<?php

include_once 'db.php';

class ProfessorDisciplina {
    private $id_disc_sala;
    private $disc_sala;
    private $disc_prof;
    private $sala;

    // Construtor
    public function __construct($disc_sala, $disc_prof, $sala) {
        $this->disc_sala = $disc_sala;
        $this->disc_prof = $disc_prof;
        $this->sala = $sala;
    }

    // Getter e Setter para id_disc_sala
    public function getIdDiscSala() {
        return $this->id_disc_sala;
    }

    public function setIdDiscSala($id_disc_sala) {
        $this->id_disc_sala = $id_disc_sala;
    }

    // Getter e Setter para disc_sala
    public function getDiscSala() {
        return $this->disc_sala;
    }

    public function setDiscSala($disc_sala) {
        $this->disc_sala = $disc_sala;
    }

    // Getter e Setter para disc_prof
    public function getDiscProf() {
        return $this->disc_prof;
    }

    public function setDiscProf($disc_prof) {
        $this->disc_prof = $disc_prof;
    }

    // Getter e Setter para sala
    public function getSala() {
        return $this->sala;
    }

    public function setSala($sala) {
        $this->sala = $sala;
    }

    // Método para salvar professor da disciplina no banco
    public function salvar($conn) {
        $sql = "INSERT INTO sala_disciplinas (disc_sala, disc_prof, sala) VALUES ('$this->disc_sala', '$this->disc_prof', '$this->sala')";
        if (mysqli_query($conn, $sql)) {
            echo "Professor vinculado à disciplina com sucesso!";
        } else {
            echo "Erro: " . mysqli_error($conn);
        }
    }
}


?>