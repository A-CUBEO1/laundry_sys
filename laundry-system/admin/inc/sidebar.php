<div class="sidebar">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="transactions.php">Transactions</a></li>
        <li><a href="cashiers.php">Cashiers</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>

<style>
.sidebar {
    width: 200px;
    background: #34495e;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 20px;
}
.sidebar ul { list-style:none; padding:0; }
.sidebar ul li { margin: 20px 0; }
.sidebar ul li a { color:white; text-decoration:none; display:block; padding:10px; transition:.2s; }
.sidebar ul li a:hover { background:#2c3e50; }
.main-content { margin-left:220px; padding:20px; }
</style>
