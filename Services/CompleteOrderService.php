<?php
require_once 'OrderService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $orderService = new OrderService();
    $result = $orderService->completeOrder($orderId);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>