<?php
require_once '../function/GenerateRandomStringID.php';
require_once 'DbConnector.php';

$categoryName = $_POST['categoryName'];
$categoryDescription = $_POST['categoryDescription'];

$generateID = new GenerateRandomStringID();
$categoryID = 'CTG' . $generateID->generateRandomString();

$sql = "INSERT INTO category (CategoryID, category_name, description) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $categoryID, $categoryName, $categoryDescription);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error"));
}
?>