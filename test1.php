<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Kiosk - Main</title>
    <link rel="stylesheet" href="test1.css">
</head>
<body>
    <div class="pg1-container">

        <!-- Sidebar -->
        <aside class="pg1-sidebar">
            <div class="pg1-sidebar-logo">Laundry Kiosk</div>
            <ul class="pg1-sidebar-menu">
                <li><a href="#">Main</a></li>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Transactions</a></li>
                <li><a href="#">Edit</a></li>
                <li><a href="test0.php">Logout</a></li>
            </ul>
        </aside>

        <!-- Main content -->
       <div class="pg1-main-content">
    <header class="pg1-topbar">
        <h1>Main Operations</h1>
        <div class="pg1-user-info">Cashier/Admin</div>
    </header>

            <!-- Form -->
            <form class="pg1-form">
                <div class="pg1-form-group">
                    <label for="customer-name">Customer Name</label>
                    <input type="text" id="customer-name" placeholder="Enter customer name">
                </div>

                <div class="pg1-form-group">
                    <label for="phone-number">Phone Number</label>
                    <input type="text" id="phone-number" placeholder="Enter phone number">
                </div>

                <div class="pg1-form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" placeholder="Enter address">
                </div>

                <div class="pg1-form-group">
                    <label for="date-time">Date & Time</label>
                    <input type="datetime-local" id="date-time">
                </div>

                <div class="pg1-form-group">
                    <label for="payment-mode">Mode of Payment</label>
                    <select id="payment-mode">
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                        <option value="pay-later">Pay Later</option>
                    </select>
                </div>

                <div class="pg1-form-group">
                    <label>Service</label>
                    <div class="pg1-checkbox-group">
                        <input type="checkbox" id="wash"><label for="wash">Wash</label>
                        <input type="checkbox" id="dry"><label for="dry">Dry</label>
                        <input type="checkbox" id="fold"><label for="fold">Fold</label>
                    </div>
                </div>

                <div class="pg1-form-group">
                    <label for="kilos">Kilos</label>
                    <input type="number" id="kilos" placeholder="Enter kilos">
                </div>

                <div class="pg1-form-group">
    <label>Soap</label>
    <div class="pg1-checkbox-group">
        <input type="radio" id="own-soap" name="soap" value="own" onclick="toggleSoapDropdown()">
        <label for="own-soap">Own Soap</label>

        <input type="radio" id="buy-soap" name="soap" value="buy" onclick="toggleSoapDropdown()">
        <label for="buy-soap">Buy Soap</label>
    </div>
    <select id="soap-quantity" style="margin-top:10px; display:none;">
        <option value="">Select quantity</option>
        <option value="1">1 Bar</option>
        <option value="2">2 Bars</option>
        <option value="3">3 Bars</option>
        <option value="4">4 Bars</option>
        <option value="5">5 Bars</option>
    </select>
</div>

<script>
function toggleSoapDropdown() {
    const buySoap = document.getElementById('buy-soap');
    const quantity = document.getElementById('soap-quantity');

    if (buySoap.checked) {
        quantity.style.display = 'block';
    } else {
        quantity.style.display = 'none';
        quantity.value = ""; // reset if switching back
    }
}
</script>


                <button type="submit" class="pg1-submit-btn">Submit Order</button>
            </form>
        </div>

    </div>
</body>
</html>
