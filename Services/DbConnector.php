<?php
    include 'SessionService.php';
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "order_management";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>