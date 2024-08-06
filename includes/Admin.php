<?php
class Admin {
    private $conn;
    private $table_name = "admin_bd";

    public $email_admin;
    public $senha_admin;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT id_admin, nome_admin, email_admin, senha_admin FROM " . $this->table_name . " WHERE email_admin = ? AND senha_admin = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("ss", $this->email_admin, $this->senha_admin);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->id_admin = $row['id_admin'];
                $this->nome_admin = $row['nome_admin'];
                return true;
            }
        }

        return false;
    }
}
?>
