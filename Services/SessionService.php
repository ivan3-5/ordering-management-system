<?php
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
        header("Location: " . $actual_link . "/ordering-management-system/Login.php");
        exit();
    }
    
    $session_id = (int)$_SESSION['id'];
    $session_email = $_SESSION['email'];

?>