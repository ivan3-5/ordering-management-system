<?php
session_start();

// Check if the cart session variable exists
if (isset($_SESSION['cart'])) {
    // Clear the cart session variable
    unset($_SESSION['cart']);
}

// Optionally, you can also clear other related session variables
if (isset($_SESSION['orderCount'])) {
    unset($_SESSION['orderCount']);
}

// Return a success response
echo json_encode(['status' => 'success']);
?>