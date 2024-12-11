<?php
    session_start();
    session_destroy();
    
    // $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
    
    // header("Location: " . $actual_link . "/ordering-management-system/Login.php");
    echo  "Login.php";
?>