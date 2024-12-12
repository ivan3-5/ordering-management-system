<?php
require_once 'DbConnector.php';

$response = array();

// Fetch categories
$sql = "SELECT CategoryID, category_name, description FROM category WHERE deleted = FALSE";
$result = $conn->query($sql);

$categories = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
$response['categories'] = $categories;

// Fetch items
$sql = "SELECT ItemID, item_name, description, price, CategoryID FROM menu WHERE deleted = FALSE";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
$response['items'] = $items;

echo json_encode($response);
?>