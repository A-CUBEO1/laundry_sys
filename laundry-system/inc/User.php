<?php
class User {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function login($username, $pin){
        $stmt = $this->db->pdo->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($pin, $user['pin_hash'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function createCashier($username, $pin){
        $pin_hash = password_hash($pin, PASSWORD_DEFAULT);
        $stmt = $this->db->pdo->prepare("INSERT INTO users (username, pin_hash, role) VALUES (?, ?, 'cashier')");
        $stmt->execute([$username, $pin_hash]);
    }

    public function deleteCashier($id){
        $stmt = $this->db->pdo->prepare("DELETE FROM users WHERE id=? AND role='cashier'");
        $stmt->execute([$id]);
    }

    public function getCashiers(){
        $stmt = $this->db->pdo->query("SELECT id, username FROM users WHERE role='cashier' ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
