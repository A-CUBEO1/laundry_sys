<?php
require '../inc/Database.php';
require '../inc/User.php';
require '../inc/Session.php';

Session::requireAdmin();
$db = new Database();
$userObj = new User($db);

$message = '';

// Handle creation
if(isset($_POST['create_cashier'])){
    $username = trim($_POST['username']);
    $pin = trim($_POST['pin']);
    if($username && $pin){
        $userObj->createCashier($username, $pin);
        $message = "Cashier '$username' created!";
    }
}

// Handle deletion
if(isset($_POST['delete_cashier'])){
    $userObj->deleteCashier($_POST['delete_id']);
    header("Location: cashiers.php");
    exit;
}

// Fetch all cashiers
$cashiers = $userObj->getCashiers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cashiers Management</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.main-content{margin-left:220px;padding:20px;}
.card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);margin-bottom:20px;}
.card input{width:100%;padding:8px;margin:5px 0;border-radius:5px;border:1px solid #ccc;}
.card button{padding:10px;border:none;border-radius:5px;background:#2980b9;color:white;cursor:pointer;}
.card button:hover{background:#1f6091;}
.cashier-list{margin-top:15px;}
.cashier-item{display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;}
button.delete{background:#c0392b;color:white;border:none;padding:5px 10px;border-radius:5px;cursor:pointer;}
button.delete:hover{background:#962d22;}
.message{color:green;font-weight:bold;margin-bottom:10px;text-align:center;}
</style>
</head>
<body>
<?php include 'inc/sidebar.php'; ?>
<div class="main-content">
    <h1>Cashiers Management</h1>

    <div class="card">
        <?php if($message) echo "<div class='message'>$message</div>"; ?>
        <h2>Create New Cashier</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="pin" placeholder="PIN" required>
            <button type="submit" name="create_cashier">Create</button>
        </form>
    </div>

    <div class="card">
        <h2>Existing Cashiers</h2>
        <div class="cashier-list">
            <?php foreach($cashiers as $c): ?>
                <div class="cashier-item">
                    <span><?php echo htmlspecialchars($c['username']); ?></span>
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="delete_id" value="<?php echo $c['id']; ?>">
                        <button type="submit" name="delete_cashier" class="delete">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
