<?php
session_start();
require_once __DIR__ . '/DbConnector.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    if (!isset($_SESSION['id'])) {
        throw new Exception('User not logged in');
    }

    $userId = $_SESSION['id'];
    $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : null;

    if ($itemId === null) {
        throw new Exception('Invalid item ID');
    }

    
    $getOrderSql = "SELECT OrderID FROM orders WHERE UserID = ? AND order_status = 'cart' LIMIT 1";
    $getOrderStmt = $conn->prepare($getOrderSql);
    $getOrderStmt->bind_param("i", $userId);
    $getOrderStmt->execute();
    $getOrderResult = $getOrderStmt->get_result();

    if ($orderRow = $getOrderResult->fetch_assoc()) {
        $orderId = $orderRow['OrderID'];

        
        $deleteItemSql = "DELETE FROM order_item WHERE OrderID = ? AND ItemID = ?";
        $deleteItemStmt = $conn->prepare($deleteItemSql);
        $deleteItemStmt->bind_param("ss", $orderId, $itemId);
        if (!$deleteItemStmt->execute()) {
            throw new Exception('Failed to remove item from cart');
        }
        $deleteItemStmt->close();

        
        $updateTotalSql = "UPDATE orders SET total_amount = (SELECT SUM(price * quantity) FROM order_item WHERE OrderID = ?) WHERE OrderID = ?";
        $updateTotalStmt = $conn->prepare($updateTotalSql);
        $updateTotalStmt->bind_param("ss", $orderId, $orderId);
        if (!$updateTotalStmt->execute()) {
            throw new Exception('Failed to update total amount');
        }
        $updateTotalStmt->close();

        $response = ['status' => 'success'];
    } else {
        throw new Exception('Cart order not found');
    }
    $getOrderStmt->close();
} catch (Exception $e) {
    error_log($e->getMessage(), 3, __DIR__ . '/error_log.txt');
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
$conn->close();
?>