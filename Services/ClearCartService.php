<?php
session_start();

if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

if (isset($_SESSION['orderCount'])) {
    unset($_SESSION['orderCount']);
}

echo json_encode(['status' => 'success']);
?>