<?php
require_once 'DbConnector.php';

$itemId = $_POST['itemId'];
$newItemName = $_POST['newItemName'];
$newItemDescription = $_POST['newItemDescription'];
$newItemPrice = $_POST['newItemPrice'];
$newItemCategory = $_POST['newItemCategory'];

$sql = "UPDATE menu SET item_name = ?, description = ?, price = ?, CategoryID = ? WHERE ItemID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdss", $newItemName, $newItemDescription, $newItemPrice, $newItemCategory, $itemId);

if ($stmt->execute()) {
    if (isset($_FILES['newItemImage']) && $_FILES['newItemImage']['error'] == UPLOAD_ERR_OK) {
        $newItemImage = file_get_contents($_FILES['newItemImage']['tmp_name']);
        $sql = "UPDATE menu SET item_image = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newItemImage, $itemId);
        $stmt->execute();
    }
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => $stmt->error));
}
?>