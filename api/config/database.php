<?php
class Database {
    private host = "localhost";
    privatedb_name = "your_db";
    private username = "root";
    privatepassword = "";
    public conn;

    public function connect()this->conn = null;
        try {
            this->conn = new PDO("mysql:host=this->host;dbname=this->db_name;charset=utf8",this->username, this->password);this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException e) 
            echo "Connection Error: " .e->getMessage();
        }
        return this->conn;
?>