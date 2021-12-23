<?php

class Database
{

    private $hostname;
    private $dbname;
    private $username;
    private $password;
    public function dbConnection()
    {

        $this->hostname = "localhost";
        $this->dbname = "crud_db";
        $this->username = "root";
        $this->password = "";

        try {
            $conn = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->dbname, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection error " . $e->getMessage();
            exit;
        }
    }
}
