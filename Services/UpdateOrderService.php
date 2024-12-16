<?php
session_start();
require_once __DIR__ . '/DbConnector.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    if (!isset($_SESSION['id'])) {
        throw new Exception('User not logged in');
    }

    $userId = $_SESSION['id'];
    $pickup = isset($_POST['pickup']) ? (int)$_POST['pickup'] : 0;
    $orderStatus = isset($_POST['order_status']) ? trim($_POST['order_status']) : '';
    $deliveryId = isset($_POST['delivery_id']) ? NULL : '';

    
    $getOrderSql = "SELECT OrderID FROM orders WHERE UserID = ? AND order_status = 'cart' LIMIT 1";
    $getOrderStmt = $conn->prepare($getOrderSql);
    $getOrderStmt->bind_param("i", $userId);
    $getOrderStmt->execute();
    $getOrderResult = $getOrderStmt->get_result();

    if ($orderRow = $getOrderResult->fetch_assoc()) {
        $orderId = $orderRow['OrderID'];

        
        $updateOrderSql = "UPDATE orders SET pickup = ?, order_status = ?, DeliveryID = ? WHERE OrderID = ?";
        $updateOrderStmt = $conn->prepare($updateOrderSql);
        if (!$updateOrderStmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $updateOrderStmt->bind_param("issi", $pickup, $orderStatus, $deliveryId, $orderId);
        if (!$updateOrderStmt->execute()) {
            throw new Exception('Execute failed: ' . $updateOrderStmt->error);
        }
        $updateOrderStmt->close();

        $response = ['status' => 'success'];
    } else {
        throw new Exception('No cart order found');
    }
    $getOrderStmt->close();
} catch (Exception $e) {
    error_log($e->getMessage(), 3, __DIR__ . '/error_log.txt');
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
$conn->close();
?>