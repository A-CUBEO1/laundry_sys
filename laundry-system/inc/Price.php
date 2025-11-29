<?php
require_once 'Database.php';

class Price {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->pdo;
    }

    public function getAllPrices() {
        $stmt = $this->pdo->query("SELECT service_type, price_per_load FROM prices");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function updatePrice($service, $price) {
        $stmt = $this->pdo->prepare("UPDATE prices SET price_per_load=? WHERE service_type=?");
        $stmt->execute([$price, $service]);
    }
}
