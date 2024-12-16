<?php
session_start();

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$orderCount = 0;

file_put_contents('debug_log.txt', print_r($_SESSION, true));

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $orderCount += $item['quantity'];
    }
}

echo json_encode($orderCount);
?>