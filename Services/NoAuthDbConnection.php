<?php
    $conn = new mysqli('localhost', 'root', '', 'order_management');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // echo "DB Connected successfully";
    }
?>