<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "1234"; 
    private $db   = "user_system";
    public $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
    public function disconnect() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    public function query($sql) {
        return $this->connection->query($sql);
    }
}
?>