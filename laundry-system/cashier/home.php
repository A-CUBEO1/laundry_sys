<?php
require '../inc/Database.php';
require '../inc/Session.php';
Session::requireCashier();

$db = new Database();

// Fetch prices
$stmt = $db->pdo->query("SELECT service_type, price_per_load FROM prices");
$prices = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$message = '';

// Handle new transaction
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['customer_phone']);
    $weight = floatval($_POST['weight']);
    $services = $_POST['services'] ?? [];

    if(empty($services)){
        $message = "Select at least one service!";
    } else {
        $loads = ceil($weight/7);
        $total = 0;
        foreach($services as $s) $total += $prices[$s] * $loads;
        $services_str = implode(',', $services);

        $stmt = $db->pdo->prepare("INSERT INTO transactions (customer_name, customer_phone, service_type, weight, price, status, created_at) VALUES (?,?,?,?,?,'Pending',NOW())");
        $stmt->execute([$name,$phone,$services_str,$weight,$total]);

        $message = "Transaction saved! Total: ₱$total for $loads load(s)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashier POS - New Transaction</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include 'inc/sidebar.php'; ?>

<div class="main-content">
    <h1>New Transaction</h1>
    <div class="card">
        <?php if($message) echo "<p style='color:green;font-weight:bold;'>$message</p>"; ?>
        <form method="POST">
            <input type="text" name="customer_name" placeholder="Customer Name" required>
            <input type="text" name="customer_phone" placeholder="Phone Number" required>

            <label>Services:</label><br>
            <?php foreach($prices as $service => $price): ?>
                <input type="checkbox" name="services[]" value="<?php echo $service; ?>" class="service-checkbox" data-price="<?php echo $price; ?>"> 
                <?php echo $service; ?> (₱<?php echo $price; ?>/load)<br>
            <?php endforeach; ?>

            <input type="number" name="weight" id="weightInput" placeholder="Weight (kg)" step="0.01" required>
            <input type="text" id="totalPrice" readonly placeholder="Total Price">
            <button type="submit">Save Transaction</button>
        </form>
    </div>
</div>

<script>
const checkboxes = document.querySelectorAll('.service-checkbox');
const weightInput = document.getElementById('weightInput');
const totalPriceInput = document.getElementById('totalPrice');

function calculateTotal(){
    const weight = parseFloat(weightInput.value) || 0;
    const loads = Math.ceil(weight/7);
    let total = 0;
    checkboxes.forEach(cb => { if(cb.checked) total += parseFloat(cb.dataset.price); });
    totalPriceInput.value = "₱" + (total*loads).toFixed(2);
}

weightInput.addEventListener('input', calculateTotal);
checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
</script>
</body>
</html>
