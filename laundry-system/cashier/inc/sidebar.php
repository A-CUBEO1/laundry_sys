<div class="sidebar">
    <h2>Cashier POS</h2>
    <a href="home.php" <?php if(basename($_SERVER['PHP_SELF'])=='home.php') echo 'style="background:#34495e; border-left:5px solid #2980b9;"'; ?>>New Transaction</a>
    <a href="transactions.php" <?php if(basename($_SERVER['PHP_SELF'])=='transactions.php') echo 'style="background:#34495e; border-left:5px solid #2980b9;"'; ?>>Transactions</a>
    <a href="../logout.php">Logout</a>
</div>