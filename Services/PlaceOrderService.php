<?php



require_once __DIR__ . '/DbConnector.php'; 
require_once __DIR__ . '/CommonQueryService.php';
require_once __DIR__ . '/../function/GenerateRandomStringID.php'; 




if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: ../homepage.php');
    exit();
}


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['order_error'] = 'Your cart is empty.';
    header('Location: ../CartTab.php');
    exit();
}


if (!isset($_SESSION['orderOption']) || !isset($_SESSION['orderId'])) {
    $_SESSION['order_error'] = 'Order information is missing.';
    header('Location: ../CartTab.php');
    exit();
}

$orderOption = $_SESSION['orderOption'];
$orderId = $_SESSION['orderId'];
$userId = $_SESSION['id'];
$pickup = ($orderOption === 'pickup') ? 1 : 0; 

try {
    
    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalAmount += $item['totalPrice'] * $item['quantity'];
    }

    
    $sql_order = "INSERT INTO orders (OrderID, UserID, pickup, order_date, order_status, total_amount)
                  VALUES (?, ?, ?, NOW(), ?, ?)";

    $stmt_order = $conn->prepare($sql_order);
    if (!$stmt_order) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }

    $orderStatus = 'Pending';
    $stmt_order->bind_param("siisd", $orderId, $userId, $pickup, $orderStatus, $totalAmount);

    $stmt_order->execute();

    
    $sql_order_item = "INSERT INTO order_item (OrderItemID, OrderID, ItemID, quantity)
                       VALUES (?, ?, ?, ?)";

    $stmt_order_item = $conn->prepare($sql_order_item);
    if (!$stmt_order_item) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }

    foreach ($_SESSION['cart'] as $cartItem) {
        $orderItemId = generateRandomStringID('ORD'); 
        $itemId = $cartItem['itemId'];
        $quantity = $cartItem['quantity'];

        $stmt_order_item->bind_param("sssi", $orderItemId, $orderId, $itemId, $quantity);
        $stmt_order_item->execute();
    }

    
    if ($orderOption === 'delivery') {
        
        $deliveryId = generateRandomStringID('DEL'); 

        
        $deliveryStatus = 'Pending';
        $deliveryDate = date('Y-m-d'); 
        $deliveryTime = date('H:i:s'); 
        $deliveryConfirmation = 0; 

        
        $sql_delivery = "INSERT INTO delivery (DeliveryID, OrderID, delivery_status, delivery_date, delivery_time, delivery_confirmation)
                         VALUES (?, ?, ?, ?, ?, ?)";

        $stmt_delivery = $conn->prepare($sql_delivery);
        if (!$stmt_delivery) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
        }

        $stmt_delivery->bind_param("sssssi", $deliveryId, $orderId, $deliveryStatus, $deliveryDate, $deliveryTime, $deliveryConfirmation);
        $stmt_delivery->execute();
    }

    
    unset($_SESSION['cart']);
    unset($_SESSION['orderOption']);
    unset($_SESSION['orderId']);

    
    $_SESSION['order_success'] = 'Your order has been placed successfully!';
    header('Location: ../CartTab.php');
    exit();

} catch (mysqli_sql_exception $e) {
    error_log('MySQL Error: ' . $e->getMessage());
    if ($e->getCode() === 1062) { 
        $_SESSION['order_error'] = 'A unique OrderID could not be generated. Please try again.';
    } else {
        $_SESSION['order_error'] = 'Database error: ' . $e->getMessage();
    }
    header('Location: ../CartTab.php');
    exit();
} catch (Exception $e) {
    error_log('General Error: ' . $e->getMessage());
    $_SESSION['order_error'] = 'Error: ' . $e->getMessage();
    header('Location: ../CartTab.php');
    exit();
}
?>