<?php
require_once 'DbConnector.php';

$categoryId = $_POST['categoryId'];
$newCategoryName = $_POST['newCategoryName'];
$newCategoryDescription = $_POST['newCategoryDescription'];

$sql = "UPDATE category SET category_name = ?, description = ? WHERE CategoryID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $newCategoryName, $newCategoryDescription, $categoryId);

if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => $stmt->error));
}
?>