<?php
require '../inc/Database.php';
require '../inc/Session.php';
Session::requireCashier();

$db = new Database();

// Fetch prices
$stmt = $db->pdo->query("SELECT service_type, price_per_load, kg_per_load FROM prices");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$prices = [];
foreach($rows as $r){
    $prices[$r['service_type']] = [
        'price' => $r['price_per_load'],
        'kg_per_load' => $r['kg_per_load']
    ];
}

$message = '';

// Handle new transaction
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_transaction'])){
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['customer_phone']);
    $weight = floatval($_POST['weight']);
    $services = $_POST['services'] ?? [];

    if(empty($services)){
        $message = "Select at least one service!";
    } else {
        $total = 0;
        $services_str = implode(',', $services);

        foreach($services as $service){
            $loads = ceil($weight / $prices[$service]['kg_per_load']);
            $total += $loads * $prices[$service]['price'];
        }

        $stmt = $db->pdo->prepare(
            "INSERT INTO transactions 
            (customer_name, customer_phone, service_type, weight, price, status, created_at) 
            VALUES (?,?,?,?,?,'Pending',NOW())"
        );
        $stmt->execute([$name, $phone, $services_str, $weight, $total]);

        $message = "Transaction saved! Total: ₱$total";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashier POS - New Transaction</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.card {background:#fff;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);margin-bottom:20px;}
.card input, .card button {width:100%;padding:8px;margin:5px 0;border-radius:5px;border:1px solid #ccc;}
.card button {background:#2980b9;color:#fff;border:none;cursor:pointer;}
.card button:hover {background:#1f6091;}
.service-checkbox {margin-right:5px;}
#totalPrice {font-weight:bold;}
.main-content {margin-left:220px;padding:20px;}
</style>
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
    <?php foreach($prices as $service => $info): ?>
        <input type="checkbox" name="services[]" 
               value="<?php echo $service; ?>" 
               class="service-checkbox" 
               data-price="<?php echo $info['price']; ?>"
               data-kg="<?php echo $info['kg_per_load']; ?>"> 
        <?php echo $service; ?> (₱<?php echo $info['price']; ?>/<?php echo $info['kg_per_load']; ?>kg)<br>
    <?php endforeach; ?>

    <input type="number" name="weight" id="weightInput" placeholder="Weight (kg)" step="0.01" required>
    <input type="text" id="totalPrice" readonly placeholder="Total Price">
    <button type="submit" name="save_transaction">Save Transaction</button>
</form>

<!-- JS -->
<script>
const checkboxes = document.querySelectorAll('.service-checkbox');
const weightInput = document.getElementById('weightInput');
const totalPriceInput = document.getElementById('totalPrice');

function calculateTotal(){
    const weight = parseFloat(weightInput.value) || 0;
    let total = 0;

    checkboxes.forEach(cb => {
        if(cb.checked){
            const price = parseFloat(cb.dataset.price);
            const kgPerLoad = parseFloat(cb.dataset.kg);
            const loads = Math.ceil(weight / kgPerLoad);
            total += price * loads;
        }
    });

    totalPriceInput.value = "₱" + total.toFixed(2);
}

weightInput.addEventListener('input', calculateTotal);
checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
</script>

</body>
</html>
