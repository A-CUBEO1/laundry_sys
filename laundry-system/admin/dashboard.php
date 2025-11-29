<?php
require '../inc/Database.php';
require '../inc/Session.php';
require '../inc/AdminUser.php';
require '../inc/Price.php';
require '../inc/Transaction.php';

Session::requireAdmin();

$db = new Database();
$adminUser = new AdminUser($db);
$price = new Price($db);
$transaction = new Transaction($db);

// Handle price updates
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_prices'])){
    foreach($_POST['price'] as $service => $value){
        $price->updatePrice($service, $value);
    }
    $message = "Prices updated!";
}

// Fetch data
$cashiers = $adminUser->getCashiers();
$prices = $price->getAllPrices();
$dailyIncome = $transaction->dailyIncome();
$monthlyIncome = $transaction->monthlyIncome();
$yesterdayIncome = $transaction->yesterdayIncome();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.card {padding:20px; background:#fff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); margin-bottom:20px;}
.card h2 {margin-top:0;}
.card input {padding:5px; margin:5px 0;}
.card button {padding:8px 12px; background:#2980b9;color:#fff;border:none;border-radius:5px; cursor:pointer;}
.card button:hover {background:#1f6091;}
table {width:100%; border-collapse: collapse; margin-top:10px;}
th, td {border:1px solid #ccc; padding:8px; text-align:left;}
tr:nth-child(even) {background:#f2f2f2;}
</style>
</head>
<body>
<?php include 'inc/sidebar.php'; ?>

<div class="main-content">
    <h1>Dashboard</h1>
    
   <div class="card">
    <h2>Income</h2>
    <p><strong>Yesterday:</strong> ₱<?php echo number_format($yesterdayIncome,2); ?></p>
    <p><strong>Today:</strong> ₱<?php echo number_format($dailyIncome,2); ?></p>
    <p><strong>Month-to-Date:</strong> ₱<?php echo number_format($monthlyIncome,2); ?></p>
</div>


    <div class="card">
        <h2>Manage Prices</h2>
        <form method="POST">
            <?php foreach($prices as $service => $val): ?>
                <label><?php echo $service; ?>:</label>
                <input type="number" name="price[<?php echo $service; ?>]" value="<?php echo $val; ?>" step="0.01"><br>
            <?php endforeach; ?>
            <button name="update_prices">Update Prices</button>
        </form>
    </div>

    <div class="card">
        <h2>Cashier Accounts</h2>
        <table>
            <tr><th>ID</th><th>Username</th><th>Created At</th><th>Action</th></tr>
            <?php foreach($cashiers as $c): ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['username']); ?></td>
                <td><?php echo $c['created_at']; ?></td>
                <td><a href="cashiers.php?delete=<?php echo $c['id']; ?>">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>
