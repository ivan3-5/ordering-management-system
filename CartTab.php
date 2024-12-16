<?php
session_start();
require_once __DIR__ . '/Services/DbConnector.php';

// Check if user is logged in
if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: homepage.php');
    exit();
}

$userId = $_SESSION['id'];

// Retrieve the current cart order
$getOrderSql = "SELECT OrderID, total_amount FROM orders WHERE UserID = ? AND order_status = 'cart' LIMIT 1";
$getOrderStmt = $conn->prepare($getOrderSql);
$getOrderStmt->bind_param("i", $userId);
$getOrderStmt->execute();
$getOrderResult = $getOrderStmt->get_result();

$cartItems = [];
$totalAmount = 0;

if ($orderRow = $getOrderResult->fetch_assoc()) {
    $orderId = $orderRow['OrderID'];
    $totalAmount = $orderRow['total_amount'];

    // Get items from order_item table
    $getItemsSql = "SELECT oi.*, m.item_name, m.price FROM order_item oi
                    JOIN menu m ON oi.ItemID = m.ItemID
                    WHERE oi.OrderID = ?";
    $getItemsStmt = $conn->prepare($getItemsSql);
    $getItemsStmt->bind_param("s", $orderId);
    $getItemsStmt->execute();
    $itemsResult = $getItemsStmt->get_result();

    while ($itemRow = $itemsResult->fetch_assoc()) {
        // Calculate totalPrice dynamically
        $itemRow['totalPrice'] = $itemRow['price'] * $itemRow['quantity'];
        $cartItems[] = $itemRow;
    }
    $getItemsStmt->close();
}
$getOrderStmt->close();

if (isset($_SESSION['order_success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['order_success'] . '</div>';
    unset($_SESSION['order_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Tab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="CartTab.css">
</head>
<body>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/cart-tab.js"></script>

<a href="homepage.php">
    <img src="Photos/image logo.png" alt="Logo" class="logo">
</a>

<div class="header-text">
    Cart Tab
</div>

<a href="UserProfile.php"> 
    <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
</a>

<div class="new-bg-container">
    <?php if (count($cartItems) > 0): ?>
    <div class="order-details">
        <table id="orderList" style="width: 100%;">
            <tr>
                <th style="width: 25%;">Product</th>
                <th style="width: 25%;" class="quantity">Quantity</th>
                <th style="width: 25%; text-align: center;" class="price">Price</th>
                <th style="width: 25%; text-align: right;">Remove</th>
            </tr>
            <?php foreach ($cartItems as $index => $item): ?>
            <tr>
                <td style="width: 25%;"><?php echo htmlspecialchars($item['item_name']); ?></td>
                <td style="width: 25%;"><?php echo $item['quantity']; ?> x</td>
                <td style="width: 25%; text-align: center;">₱<?php echo number_format($item['totalPrice'], 2); ?></td>
                <td style="width: 25%; text-align: right;">
                    <button onclick="removeFromCart(<?php echo $index; ?>)" style="border: none; background: none;">
                        <img src="System Pictures/Delete_icon-removebg-preview.png" alt="Remove" style="width: 20px; height: 20px;">
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else: ?>
    <p>Your cart is empty.</p>
    <?php endif; ?>
    <!-- Date and Total Section -->
    <hr style="border: 2px solid #000; width: 100%; margin: 20px auto;">
    <div class="date-total-section">
        <div class="date-text" id="dateToday">Date: </div>
        <div id="sumPrice" class="total-amount"></div>
    </div>
    <!-- Order Now Button -->
    <div class="checkout-container">
        <a href="ChooseOptionOrder.php" class="pickup-now-btn" id="orderNowBtn">Order Now</a>
    </div>
</div>

<script>
    document.getElementById('orderNowBtn').addEventListener('click', function(event) {
        var cartItems = <?php echo json_encode($cartItems); ?>;
        if (cartItems.length === 0) {
            event.preventDefault();
            alert('Your cart is empty. Please add items to your cart before proceeding.');
        }
    });
</script>
</body>
</html>
