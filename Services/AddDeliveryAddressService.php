<?php
include 'DbConnector.php';

session_start();

$address = $_POST['address'];
$deliveryId = $_POST['DeliveryID'];

function generateRandomStringID($prefix) {
    $id = $prefix . bin2hex(random_bytes(5));
    return strtoupper($id);
}

$deliveryAddressId = generateRandomStringID('DA');

$sql = "INSERT INTO delivery_address (DeliveryAddressID, DeliveryID, address, da_date, da_time)
        VALUES (?, ?, ?, CURDATE(), CURTIME())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $deliveryAddressId, $deliveryId, $address);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "DeliveryAddressID" => $deliveryAddressId));
} else {
    echo json_encode(array("status" => "error", "message" => $stmt->error));
}
$stmt->close();
$conn->close();
?>