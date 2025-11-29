<?php
require '../inc/Database.php';
require '../inc/Session.php';
Session::requireCashier();

$db = new Database();

// Mark as paid
if(isset($_GET['mark_paid'])){
    $id = intval($_GET['mark_paid']);
    $stmt = $db->pdo->prepare("UPDATE transactions SET status='Paid' WHERE id=?");
    $stmt->execute([$id]);
    header("Location: transactions.php");
    exit;
}

// Fetch transactions
$unpaid = $db->pdo->query("SELECT * FROM transactions WHERE status='Pending' ORDER BY created_at DESC")->fetchAll();
$paid = $db->pdo->query("SELECT * FROM transactions WHERE status='Paid' ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashier POS - Transactions</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include 'inc/sidebar.php'; ?>

<div class="main-content">
    <h1>Transactions</h1>

    <div class="card">
        <h2>Pending Payments</h2>
        <table>
            <tr>
                <th>ID</th><th>Customer</th><th>Services</th><th>Weight</th><th>Price</th><th>Status</th><th>Action</th>
            </tr>
            <?php foreach($unpaid as $t): ?>
            <tr>
                <td><?php echo $t['id']; ?></td>
                <td><?php echo htmlspecialchars($t['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($t['service_type']); ?></td>
                <td><?php echo $t['weight']; ?></td>
                <td>₱<?php echo number_format($t['price'],2); ?></td>
                <td><?php echo $t['status']; ?></td>
                <td>
                    <a href="?mark_paid=<?php echo $t['id']; ?>"><button class="mark-paid">Mark Paid</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2>Paid Transactions</h2>
        <table>
            <tr>
                <th>ID</th><th>Customer</th><th>Services</th><th>Weight</th><th>Price</th><th>Status</th>
            </tr>
            <?php foreach($paid as $t): ?>
            <tr>
                <td><?php echo $t['id']; ?></td>
                <td><?php echo htmlspecialchars($t['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($t['service_type']); ?></td>
                <td><?php echo $t['weight']; ?></td>
                <td>₱<?php echo number_format($t['price'],2); ?></td>
                <td><?php echo $t['status']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>
