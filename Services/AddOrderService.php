<?php
include 'DbConnector.php';
include 'CommonQueryService.php';

session_start();

$userId = $_SESSION['id'];

$orderId = $_POST['OrderID'];
$pickup = $_POST['pickup']; 
$orderStatus = $_POST['order_status'];
$totalAmount = $_POST['total_amount'];

$amountPaid = $totalAmount * 1.02;

$deliveryId = generateRandomStringID('DEL'); 
$transactionId = generateRandomStringID('TRAN');

$deliveryStatus = 'Pending';
$deliveryConfirmation = 0;

$sql_delivery = "INSERT INTO delivery (DeliveryID, delivery_status, delivery_date, delivery_time, delivery_confirmation)
                 VALUES (?, ?, CURDATE(), CURTIME(), ?)";

$stmt_delivery = $conn->prepare($sql_delivery);
$stmt_delivery->bind_param("ssi", $deliveryId, $deliveryStatus, $deliveryConfirmation);

if (!$stmt_delivery->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add delivery.']);
    exit();
}

$sql_order = "INSERT INTO orders (OrderID, UserID, DeliveryID, TransactionID, pickup, order_date, order_status, total_amount)
              VALUES (?, ?, ?, ?, ?, CURDATE(), ?, ?)";

$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("isssisd", $orderId, $userId, $deliveryId, $transactionId, $pickup, $orderStatus, $totalAmount);

if (!$stmt_order->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add order.']);
    exit();
}

$transactionStatus = 'Pending';

$sql_transaction = "INSERT INTO transactions (TransactionID, transaction_status, transaction_date, transaction_method, amount_paid)
                    VALUES (?, ?, CURDATE(), ?, ?)";

$stmt_transaction = $conn->prepare($sql_transaction);
$transactionMethod = 'Delivery'; 

$stmt_transaction->bind_param("sssd", $transactionId, $transactionStatus, $transactionMethod, $amountPaid);

if ($stmt_transaction->execute()) {
    $_SESSION['orderId'] = $orderId;
    $_SESSION['deliveryId'] = $deliveryId;
    $_SESSION['transactionId'] = $transactionId;

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add transaction.']);
}

$stmt_transaction->close();
$conn->close();

function generateRandomStringID($prefix) {
    try {
        $id = $prefix . bin2hex(random_bytes(5));
    } catch (Exception $e) {
        $id = $prefix . uniqid();
    }
    return strtoupper($id);
}
?>