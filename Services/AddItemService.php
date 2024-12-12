<?php
require_once 'DbConnector.php';
require_once '../function/GenerateRandomStringID.php';

$itemID = generateRandomStringID('ITM');
$itemName = $_POST['itemName'];
$itemCategory = $_POST['itemCategory'];
$itemDescription = $_POST['itemDescription'];
$itemPrice = $_POST['itemPrice'];

// Handle file upload
$itemImage = $_FILES['itemImage'];
$imageData = file_get_contents($itemImage['tmp_name']);

$sql = "INSERT INTO menu (ItemID, CategoryID, item_name, item_image, description, price, deleted) VALUES (?, ?, ?, ?, ?, ?, FALSE)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssd", $itemID, $itemCategory, $itemName, $imageData, $itemDescription, $itemPrice);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => $stmt->error));
}
?>