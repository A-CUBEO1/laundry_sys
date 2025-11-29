<?php
class Price {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    /**
     * Get all prices with per-load weights
     * Returns array: ['Wash' => ['price'=>50, 'kg_per_load'=>7], ...]
     */
    public function getAllPrices(){
        $stmt = $this->db->pdo->query("SELECT service_type, price_per_load, kg_per_load FROM prices");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach($rows as $r){
            $result[$r['service_type']] = [
                'price' => $r['price_per_load'],
                'kg_per_load' => $r['kg_per_load']
            ];
        }
        return $result;
    }

    /**
     * Update price and kg_per_load for a service
     */
    public function updatePrice($service, $price, $kg_per_load = 7){
        $stmt = $this->db->pdo->prepare(
            "UPDATE prices SET price_per_load = ?, kg_per_load = ? WHERE service_type = ?"
        );
        $stmt->execute([$price, $kg_per_load, $service]);
    }

    /**
     * Get a single service price
     */
    public function getPrice($service){
        $stmt = $this->db->pdo->prepare(
            "SELECT price_per_load, kg_per_load FROM prices WHERE service_type = ?"
        );
        $stmt->execute([$service]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new service
     */
    public function addService($service, $price, $kg_per_load = 7){
        $stmt = $this->db->pdo->prepare(
            "INSERT INTO prices (service_type, price_per_load, kg_per_load) VALUES (?,?,?)"
        );
        $stmt->execute([$service, $price, $kg_per_load]);
    }

    /**
     * Delete a service
     */
    public function deleteService($service){
        $stmt = $this->db->pdo->prepare(
            "DELETE FROM prices WHERE service_type = ?"
        );
        $stmt->execute([$service]);
    }
}
?>
