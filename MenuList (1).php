<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
  header('Location: homepage.php');
  exit();
}

require_once __DIR__ . '/Services/DbConnector.php';

$userId = $_SESSION['id'];

$getCartQuantitySql = "SELECT SUM(oi.quantity) AS totalQuantity
                       FROM order_item oi
                       JOIN orders o ON oi.OrderID = o.OrderID
                       WHERE o.UserID = ? AND o.order_status = 'cart'";
$getCartQuantityStmt = $conn->prepare($getCartQuantitySql);
$getCartQuantityStmt->bind_param("i", $userId);
$getCartQuantityStmt->execute();
$getCartQuantityResult = $getCartQuantityStmt->get_result();
$totalQuantity = 0;
if ($cartRow = $getCartQuantityResult->fetch_assoc()) {
    $totalQuantity = $cartRow['totalQuantity'];
}
$getCartQuantityStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ninong Ry's</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
  <link rel="stylesheet" href="MenuList (1).css">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body style="background-color: #C6A988;">
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/menu-list.js"></script>

<div class="containerLogo">
  <a href="homepage.php">
    <button class="logo-button">
      <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" 
           style="width: 190px; height: 190px;" alt="Logo">
    </button>
  </a>
</div>

<div class="content-container">
  <h1 style="font-family: abel;">Fresh, Local and Thoughtful</h1>
  
  <div class="order-now-container">
    <a href="UserProfile.php" class="profile-button">
      <p><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?></p>
    </a>
    <!-- <a href="ChooseOptionOrder.php" class="order-now-button">Order Now</a> -->
    <a href="CartTab.php" class="Cart-button">
      <span id="orderCount" style="position: relative;left: 37px;top: -3px;color: black;"><?php echo $totalQuantity; ?></span>
      <img src="System Pictures/cart_icon-removebg-preview.png" alt="Cart Icon">
    </a>
  </div>
</div>

<div class="search-container">
  <div class="search-wrapper">
    <button class="search-button">
      <img src="System Pictures/serach_icon-removebg-preview.png" alt="Search Icon">  
    </button>
    <input type="text" id="search-input" placeholder="Search...">
  </div>
 
  <div class="pc-container">
    <a href="#pastries-section">
      <button class="pc-now-button">Pastries</button>
    </a>
    <a href="#coffee-section">
      <button class="pc-now-button">Coffee</button>
    </a>
  </div>
</div>

<button target="_blank" class="banner"> 
  <div class="banner-overlay" onclick="openOrderWindow('Mocha Frappe x Chocolate Croissant Banner', 125.85, 'a rich and creamy blend of coffee and chocolate, pairs perfectly with our flaky Chocolate Croissant.', 'System Pictures/Mocha Frappe x Chocolate Croissant .png')">
  </div>
</button>

<?php require_once 'function/GetAllItemsInDB.php'; ?>

<div class="row mt-4">
  <div class="col-md-4">
    <div class="additional-content text-center">
      <a href="homepage.php">
        <button class="logo-button">
          <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Additional Logo" class="logo-image">
        </button>
      </a>
    </div>
  </div>
</div>
  
<div class="container">
  <div class="row mt-4 justify-content-end">
    <div class="col-md-4 d-flex justify-content-end">
      <div class="additional-content text-center">
        <button class="icon-button">
          <img src="System Pictures/facebook logo.png" alt="Icon 1" class="logo-image">
        </button>
      </div>
      <div class="additional-content text-center">
        <button class="icon-button">
          <img src="System Pictures/Instagram logo.png" alt="Icon 2" class="logo-image">
        </button>
      </div>
      <div class="additional-content text-center">
        <button class="icon-button">
          <img src="System Pictures/Contact number logo.png" alt="Icon 3" class="logo-image">
        </button>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="horizontal-line"></div>
    </div>
  </div>
  <div class="icon-container">
    <div class="icon-item">
      <img src="System Pictures/COD-removebg-preview.png" alt="Icon 1" class="icon-image">
    </div>
    <div class="icon-item">
      <img src="System Pictures/gcash-removebg-preview.png" alt="Icon 2" class="icon-image">
    </div>
  </div>
  <div class="Pc2-container">
    <h1 style="font-family: abel;">Reach Us</h1>
  </div>

  <div class="input-container">
    <input type="text" placeholder="Type here..." class="text-box">
    <button class="signup-button">Sign Up</button>
  </div>
</div>

<!-- Order Cart Hover-->
<div class="order-window" id="orderWindow">
  <div class="order-content">
      
    <button class="close-btn" onclick="closeOrderWindow()">×</button>
    <img id="orderImg" src="" alt="Product Image" class="order-img">
    <h2 class="order-name" id="orderName">Product Name</h2>
    <p class="order-price">Price: ₱<span id="totalPrice">0.00</span></p>
    <p class="order-description" id="orderDescription">Description</p>
    <div class="quantity">
      <p style="position: relative;top: 8px;right: 3px;background-color: white;padding: 2px 7px;height: 24px;" onclick="adjustQuantity(-1)">−</p>
      <input name="quantity" type="number" id="quantity" value="1">
      <p style="position: relative;top: 8px;left: 3px;background-color: white;padding: 2px 7px;height: 24px;" onclick="adjustQuantity(1)">+</p>
    </div>

    <input type="hidden" id="itemId" name="itemId" value="">

    <p><input id="orderBtn" type="button" value="Add to Cart" onclick="addToCart()"/></p>

  </div>
</div>

<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');
ob_start();

session_start();

require_once __DIR__ . '/DbConnector.php';
require_once __DIR__ . '/../function/GenerateRandomStringID.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    if (!isset($_SESSION['id'])) {
        throw new Exception('User not logged in');
    }

    $userId = $_SESSION['id'];

    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $orderName = isset($_POST['orderName']) ? trim($_POST['orderName']) : '';
    $totalPrice = isset($_POST['totalPrice']) ? (float)$_POST['totalPrice'] : 0.0;
    $orderDescription = isset($_POST['orderDescription']) ? trim($_POST['orderDescription']) : '';
    $orderImg = isset($_POST['orderImg']) ? trim($_POST['orderImg']) : '';
    $itemId = isset($_POST['itemId']) ? trim($_POST['itemId']) : '';

    if (empty($itemId)) {
        throw new Exception('Invalid Item ID');
    }

    $checkOrderSql = "SELECT OrderID FROM orders WHERE UserID = ? AND order_status = 'cart' LIMIT 1";
    $checkOrderStmt = $conn->prepare($checkOrderSql);
    if (!$checkOrderStmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $checkOrderStmt->bind_param("i", $userId);
    if (!$checkOrderStmt->execute()) {
        throw new Exception('Execute failed: ' . $checkOrderStmt->error);
    }
    $checkOrderStmt->store_result();

    if ($checkOrderStmt->num_rows > 0) {
        $checkOrderStmt->bind_result($orderId);
        $checkOrderStmt->fetch();
    } else {
        $orderId = generateRandomStringID('ORD');
        $deliveryId = generateRandomStringID('DLV');
        $transactionId = generateRandomStringID('TRN');
        $pickup = 0; 
        $orderStatus = 'cart';
        $orderDate = date('Y-m-d');
        $totalAmount = 0.0;

        $insertOrderSql = "INSERT INTO orders (OrderID, UserID, DeliveryID, TransactionID, pickup, order_date, order_status, total_amount)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertOrderStmt = $conn->prepare($insertOrderSql);
        if (!$insertOrderStmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $insertOrderStmt->bind_param("siissssd", $orderId, $userId, $deliveryId, $transactionId, $pickup, $orderDate, $orderStatus, $totalAmount);
        if (!$insertOrderStmt->execute()) {
            throw new Exception('Execute failed: ' . $insertOrderStmt->error);
        }
        $insertOrderStmt->close();
    }
    $checkOrderStmt->close();

    $orderItemId = generateRandomStringID('ORI');
    $subtotal = $totalPrice * $quantity;

    $insertItemSql = "INSERT INTO order_item (OrderItemID, OrderID, ItemID, quantity, subtotal)
                      VALUES (?, ?, ?, ?, ?)";
    $insertItemStmt = $conn->prepare($insertItemSql);
    if (!$insertItemStmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $insertItemStmt->bind_param("sssid", $orderItemId, $orderId, $itemId, $quantity, $subtotal);
    if (!$insertItemStmt->execute()) {
        throw new Exception('Execute failed: ' . $insertItemStmt->error);
    }
    $insertItemStmt->close();

    $updateTotalSql = "UPDATE orders SET total_amount = total_amount + ? WHERE OrderID = ?";
    $updateTotalStmt = $conn->prepare($updateTotalSql);
    if (!$updateTotalStmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $updateTotalStmt->bind_param("ds", $subtotal, $orderId);
    if (!$updateTotalStmt->execute()) {
        throw new Exception('Execute failed: ' . $updateTotalStmt->error);
    }
    $updateTotalStmt->close();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = [
        'orderId' => $orderId,
        'orderItemId' => $orderItemId,
        'orderName' => $orderName,
        'totalPrice' => $totalPrice,
        'quantity' => $quantity,
        'orderDescription' => $orderDescription,
        'orderImg' => $orderImg,
        'itemId' => $itemId
    ];

    $response = ['status' => 'success', 'orderId' => $orderId];

} catch (Exception $e) {
    error_log($e->getMessage(), 3, __DIR__ . '/error_log.txt');
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

ob_clean();

echo json_encode($response);
$conn->close();
?>

</body>
</html>
