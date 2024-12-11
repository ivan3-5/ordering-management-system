<?php
    session_start();
    $_SESSION['UserRole'] = "guest";
    session_destroy();
    
    // echo json_encode(['status' => 'success']);
    // $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
    
    // header("Location: " . $actual_link . "/ordering-management-system/Login.php");
    header("Location: /homepage.php");
    exit();
?>