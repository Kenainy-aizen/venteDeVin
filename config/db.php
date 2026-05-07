<?php
require_once __DIR__ . "/config.php";

class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $dsn =
                "mysql:host={$this->host};dbname={$this->db_name};charset=" .
                DB_CHARSET;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION,
            );
            $this->conn->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC,
            );
        } catch (PDOException $e) {
            error_log("Erreur de connexion DB: " . $e->getMessage());
            die("Erreur de connexion à la base de données.");
        }
        return $this->conn;
    }
}
