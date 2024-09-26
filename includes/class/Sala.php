<?php

include_once 'db.php';

class Sala {
    private $id_sala;
    private $ano_sala;
    private $serie_sala;

    // Construtor
    public function __construct($ano_sala, $serie_sala) {
        $this->ano_sala = $ano_sala;
        $this->serie_sala = $serie_sala;
    }

    // Getter e Setter para id_sala
    public function getIdSala() {
        return $this->id_sala;
    }

    public function setIdSala($id_sala) {
        $this->id_sala = $id_sala;
    }

    // Getter e Setter para ano_sala
    public function getAnoSala() {
        return $this->ano_sala;
    }

    public function setAnoSala($ano_sala) {
        $this->ano_sala = $ano_sala;
    }

    // Getter e Setter para serie_sala
    public function getSerieSala() {
        return $this->serie_sala;
    }

    public function setSerieSala($serie_sala) {
        $this->serie_sala = $serie_sala;
    }

    // Método para salvar sala no banco
    public function salvar($conn) {
        $sql = "INSERT INTO salas (ano_sala, serie_sala) VALUES ('$this->ano_sala', '$this->serie_sala')";
        if (mysqli_query($conn, $sql)) {
            echo "Sala cadastrada com sucesso!";
        } else {
            echo "Erro: " . mysqli_error($conn);
        }
    }
}


?>