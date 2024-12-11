<?php
require_once 'DbConnector.php';

$sql = "SELECT CategoryID, category_name FROM category";
$result = $conn->query($sql);

$categories = array();
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
?>