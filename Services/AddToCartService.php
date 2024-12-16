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

    $insertItemSql = "INSERT INTO order_item (OrderItemID, OrderID, ItemID, quantity)
                      VALUES (?, ?, ?, ?)";
    $insertItemStmt = $conn->prepare($insertItemSql);
    if (!$insertItemStmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $insertItemStmt->bind_param("sssi", $orderItemId, $orderId, $itemId, $quantity);
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