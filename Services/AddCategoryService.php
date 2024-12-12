<?php
require_once 'DbConnector.php';
require_once '../function/GenerateRandomStringID.php';

$categoryID = generateRandomStringID('CTG');
$categoryName = $_POST['categoryName'];
$categoryDescription = $_POST['categoryDescription'];

$sql = "INSERT INTO category (CategoryID, category_name, description, deleted) VALUES (?, ?, ?, FALSE)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $categoryID, $categoryName, $categoryDescription);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => $stmt->error));
}
?>