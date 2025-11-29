<?php
class Database {
    public $pdo;

    public function __construct(){
        $host = 'localhost';
        $db = 'laundry_system';
        $user = 'root';
        $pass = '';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        try{
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Database connection failed: ".$e->getMessage());
        }
    }
}
?>
