<?php
require_once '../function/GenerateRandomStringID.php';
require_once 'DbConnector.php';

$productName = $_POST['productName'];
$productCategory = $_POST['productCategory'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productImage = file_get_contents($_FILES['productImage']['tmp_name']);

$generateID = new GenerateRandomStringID();
$productID = 'ITM' . $generateID->generateRandomString();

$sql = "INSERT INTO menu (ItemID, CategoryID, item_name, item_image, description, price) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssd", $productID, $productCategory, $productName, $productImage, $productDescription, $productPrice);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error"));
}
?>