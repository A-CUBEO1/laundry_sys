<?php
require_once 'Database.php';

class AdminUser {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->pdo;
    }

    // Get all cashier accounts
    public function getCashiers() {
        $stmt = $this->pdo->query("SELECT id, username, created_at FROM users WHERE role='cashier'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new cashier account
    public function createCashier($username, $pin) {
        $hash = password_hash($pin, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, pin_hash, role, created_at) VALUES (?, ?, 'cashier', NOW())");
        $stmt->execute([$username, $hash]);
    }

    // Delete a cashier
    public function deleteCashier($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=? AND role='cashier'");
        $stmt->execute([$id]);
    }
}
