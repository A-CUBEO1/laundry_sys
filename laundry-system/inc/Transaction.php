 <?php
require_once 'Database.php';

class Transaction {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->pdo;
    }

    // Fetch transactions by status
    public function getByStatus($status) {
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE status=? ORDER BY created_at DESC");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all transactions
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM transactions ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mark transaction as paid
    public function markPaid($id) {
        $stmt = $this->pdo->prepare("UPDATE transactions SET status='Paid' WHERE id=?");
        $stmt->execute([$id]);
    }

    // Daily total income
    public function dailyIncome() {
        $stmt = $this->pdo->query("SELECT SUM(price) as total FROM transactions WHERE DATE(created_at)=CURDATE()");
        return $stmt->fetchColumn() ?? 0;
    }

    // Monthly total income
    public function monthlyIncome() {
        $stmt = $this->pdo->query("SELECT SUM(price) as total FROM transactions WHERE MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())");
        return $stmt->fetchColumn() ?? 0;
    }

    public function yesterdayIncome() {
    $stmt = $this->pdo->query("
        SELECT SUM(price) as total 
        FROM transactions 
        WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY
    ");
    return $stmt->fetchColumn() ?? 0;
    }

}

