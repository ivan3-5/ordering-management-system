<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: homepage.php');
    exit();
}

require_once __DIR__ . '/Services/DbConnector.php';

$userId = $_SESSION['id'];
$defaultAddress = '';

// Fetch user's default address
$sql = "SELECT address FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($defaultAddress);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="DeliveryTab.css">
</head>
<body>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/order-list.service.js"></script>
<script src="js/global-data.js"></script>

<a href="homepage.php">
    <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
</a>

<!-- Customer Service Header -->
<div class="header-text">
    Delivery Order
</div>

<!-- Profile Icon -->
<a href="UserProfile.php"> 
    <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
</a>

<!-- New Background Container -->
<div class="new-bg-container">
    <div class="row">
        <!-- Hidden Button (if required for layout) -->
        <button style="opacity: 0;" class="col choice"></button>
    </div>
    
    <!-- Display Delivery ID -->
    <div class="pickup-id" id="pickupIDContainer">
        <hr class="pickup-line">
        Delivery ID: <span id="pickupID"></span>
    </div>
    <div class="order-details">
        <table id="orderList" class="table">
            <thead>
                <tr>
                    <th style="width: 33%;">Product</th>
                    <th style="width: 33%; text-align: right;" class="quantity">Quantity</th>
                    <th style="width: 33%;" class="price">Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- Order items will be appended here via JavaScript -->
            </tbody>
        </table>
        <hr class="pickup-line">
        <div class="date-total d-flex justify-content-between">
            <span id="currentDate"></span> <!-- Display current date -->
            <span id="sumPrice" class="total-price"></span> <!-- Display total price -->
        </div>
        <!-- Estimated Time to Pickup Section -->
        <div class="estimated-time">
            Estimated Time to Pickup: <span id="pickupTime">8:00 am</span>
        </div>

        <!-- Customer Address Section -->
        <div class="customer-address">
            <label for="addressType">Customer Address:</label>
            <select id="addressType" name="addressType" class="form-select" onchange="toggleNewAddressInput()">
                <option value="default" selected>Saved Address: <?php echo htmlspecialchars($defaultAddress); ?></option>
                <option value="new">Different Address</option>
            </select>
            <textarea id="newAddress" name="newAddress" class="form-control" placeholder="Enter your new address" style="display: none; margin-top: 10px;"></textarea>
        </div>
            
    </div>
    
    <!-- Payment Section -->
    <div class="payment-section">
        <label for="paymentOptions" class="payment-label">Payment:</label>
        <select id="paymentOptions" name="paymentOptions" class="form-select">
            <option value="">Select</option>
            <option value="gcash">Gcash</option>
            <option value="creditCard">Credit Card</option>
            <option value="cash">COD</option>
        </select>
    </div>
    
    <!-- Order Now Button -->
    <button class="pickup-now-btn btn btn-primary" onclick="orderNow()">Order Now</button>
</div>

<!-- JavaScript for Processing the Order -->
<script>
    var transactionId = "<?php echo isset($_SESSION['transactionId']) ? $_SESSION['transactionId'] : ''; ?>";
    var orderId = "<?php echo isset($_SESSION['orderId']) ? $_SESSION['orderId'] : ''; ?>"; 
    var deliveryId = "<?php echo isset($_SESSION['deliveryId']) ? $_SESSION['deliveryId'] : ''; ?>"; 

    $(document).ready(function() {
        fetchOrders(false, (orders) => {
            console.log('orders: ', orders);
            if (orders && orders.length) {
                // Assuming orders[0] is the current order
                const currentOrder = orders[0];
                $('#pickupID').text(currentOrder.DeliveryID.toUpperCase());
                displayCurrentDate(new Date(currentOrder.order_date));
                // Additional processing as needed
            }
        });
        
        getDeliveryAddressList();
    });

    function addDeliveryAddress(address, callback) {
        $.ajax({
            type: 'POST',
            url: 'Services/AddDeliveryAddressService.php',
            data: {
                address: address,
                DeliveryID: deliveryId
            },
            success: function(response) {
                console.log('addDeliveryAddress: ', response);
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    callback(data.DeliveryAddressID);
                } else {
                    alert('Failed to add delivery address.');
                }
            }
        });
    }

    function updateTransaction(deliveryAddressId) {
        const paymentMethod = $('#paymentOptions').val();

        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }

        // Calculate amount_paid with 2% interest
        const totalAmountText = $('#sumPrice').text();
        const totalAmount = parseFloat(totalAmountText.replace('$', ''));
        const amountPaid = (totalAmount * 1.02).toFixed(2);

        $.ajax({
            type: 'POST',
            url: 'Services/UpdateTransactionService.php',
            data: {
                TransactionID: transactionId,
                deliveryAddressId: deliveryAddressId,
                paymentMethod: paymentMethod,
                transactionStatus: 'Delivering',
                orderId: orderId,
                amountPaid: amountPaid
            },
            success: function(response) {
                console.log('updateTransaction: ', response);
                const data = JSON.parse(response);

                if (data.status === 'success') {
                    window.location.href = "MenuList (1).php";
                } else {
                    alert('Failed to update transaction.');
                }
            }
        });
    }

    function orderNow() {
        const addressType = $('#addressType').val();
        let address = '';

        if (addressType === 'default') {
            // Use the default address from the server-side variable
            address = "<?php echo addslashes($defaultAddress); ?>";
        } else if (addressType === 'new') {
            address = $('#newAddress').val().trim();
            if (!address) {
                alert('Please enter your new delivery address.');
                return;
            }
        } else {
            alert('Please select an address option.');
            return;
        }

        addDeliveryAddress(address, (deliveryAddressId) => {
            updateTransaction(deliveryAddressId);
        });
    }

    function displayCurrentDate(dateObj) {
        const year = dateObj.getFullYear();
        const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
        const day = dateObj.getDate().toString().padStart(2, '0');
        const currentDate = `${year}-${month}-${day}`;
        $('#currentDate').text('Date: ' + currentDate);
    }

    function toggleNewAddressInput() {
        const addressType = $('#addressType').val();
        if (addressType === 'new') {
            $('#newAddress').show();
        } else {
            $('#newAddress').hide();
        }
    }

    // Implement fetchOrders and other necessary functions as needed
</script>
</body>
</html>
