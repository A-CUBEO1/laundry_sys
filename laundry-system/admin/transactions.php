 
<?php
require '../inc/Database.php';
require '../inc/Session.php';

Session::requireAdmin();
$db = new Database();

// Optional filter
$filter = $_GET['filter'] ?? '';

$query = "SELECT * FROM transactions";
$params = [];
if($filter==='paid'){
    $query .= " WHERE status='Paid'";
}elseif($filter==='unpaid'){
    $query .= " WHERE status='Pending'";
}
$query .= " ORDER BY created_at DESC";

$stmt = $db->pdo->prepare($query);
$stmt->execute($params);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transactions</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
table{width:100%;border-collapse:collapse;margin-top:20px;}
th, td{padding:10px;border:1px solid #ccc;text-align:left;}
tr:nth-child(even){background:#f2f2f2;}
.filter a{margin-right:10px;text-decoration:none;color:#2980b9;}
.filter a:hover{text-decoration:underline;}
</style>
</head>
<body>
<?php include 'inc/sidebar.php'; ?>
<div class="main-content">
    <h1>Transactions</h1>

    <div class="filter">
        <strong>Filter:</strong>
        <a href="transactions.php">All</a>
        <a href="transactions.php?filter=paid">Paid</a>
        <a href="transactions.php?filter=unpaid">Unpaid</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Services</th>
            <th>Weight (kg)</th>
            <th>Price (₱)</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        <?php foreach($transactions as $t): ?>
        <tr>
            <td><?php echo $t['id']; ?></td>
            <td><?php echo htmlspecialchars($t['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($t['customer_phone']); ?></td>
            <td><?php echo htmlspecialchars($t['service_type']); ?></td>
            <td><?php echo $t['weight']; ?></td>
            <td><?php echo number_format($t['price'],2); ?></td>
            <td><?php echo $t['status']; ?></td>
            <td><?php echo $t['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
