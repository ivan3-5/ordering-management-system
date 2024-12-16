<?php
require_once 'DbConnector.php';

$categoryId = $_GET['categoryId'];

$sql = "SELECT COUNT(*) as itemCount FROM menu WHERE CategoryID = ? AND deleted = FALSE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $categoryId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$response = array('hasItems' => $row['itemCount'] > 0);

echo json_encode($response);
?>