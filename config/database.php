<?php
// config/database.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

class Database {
    // Database credentials
    private $host = "localhost";
    private $db_name = "university_db"; // We will create this in phpMyAdmin later
    private $username = "root";
    private $password = ""; // Default XAMPP password is empty
    public $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Set error mode to exception for easier debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo json_encode(array("message" => "Connection error: " . $exception->getMessage()));
        }

        return $this->conn;
    }
}
?>