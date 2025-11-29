<?php
require 'inc/Database.php';
require 'inc/User.php';
require 'inc/Session.php';

Session::requireGuest();

$db = new Database();
$user = new User($db);

$message = '';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($user->login($username, $password)){
        if($_SESSION['role']==='admin') header("Location: admin/dashboard.php");
        else header("Location: cashier/home.php");
        exit;
    } else {
        $message = "Invalid username or PIN";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laundry System Login</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body{font-family:Arial;background:#f2f2f2;display:flex;justify-content:center;align-items:center;height:100vh;}
.container{text-align:center;}
.role-btn{padding:20px 40px;margin:20px;font-size:20px;border:none;border-radius:10px;cursor:pointer;background:#2980b9;color:white;transition:.3s;}
.role-btn:hover{background:#1f6091;}
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;}
.modal-content{background:#fff;padding:30px;border-radius:10px;width:300px;position:relative;text-align:center;}
.modal-content input{width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;}
.modal-content button{width:100%;padding:10px;margin-top:10px;border:none;border-radius:5px;cursor:pointer;background:#2980b9;color:white;}
.close{position:absolute;top:10px;right:15px;font-size:20px;cursor:pointer;}
.message{color:red;font-weight:bold;margin-bottom:10px;}
</style>
</head>
<body>
<div class="container">
    <h1>Laundry System Login</h1>
    <?php if($message) echo "<div class='message'>$message</div>"; ?>
    <button class="role-btn" onclick="openModal()">Login</button>
</div>

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="PIN" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<script>
function openModal(){document.getElementById('loginModal').style.display='flex';}
function closeModal(){document.getElementById('loginModal').style.display='none';}
window.onclick=function(e){if(e.target==document.getElementById('loginModal')) closeModal();}
</script>
</body>
</html>
