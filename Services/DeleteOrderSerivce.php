<?php
include __DIR__ . '/DbConnector.php';
include __DIR__ . '/CommonQueryService.php';
require_once __DIR__ . '/../function/GenerateRandomStringID.php'; 

$orderId = $_POST['orderId'];

$orderId = $conn->real_escape_string($orderId);

$sql = "DELETE FROM orders WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);

if ($stmt->execute()) {
} else {
    echo "Error: " . $stmt->error;
}

echo htmlspecialchars($orderId);
?>