<?php
require_once 'DbConnector.php';

$response = array();


$sql = "SELECT CategoryID, category_name, description FROM category WHERE deleted = FALSE";
$result = $conn->query($sql);

$categories = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
$response['categories'] = $categories;


$sql = "SELECT ItemID, item_name, item_image, description, price, CategoryID FROM menu WHERE deleted = FALSE";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['item_image'] = base64_encode($row['item_image']);
        $row['price'] = (float)$row['price']; 
        $items[] = $row;
    }
}
$response['items'] = $items;

echo json_encode($response);
?>