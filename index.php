<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['redirected'])) {
    $_SESSION['redirected'] = true;
    header('Location: homepage.php');
    exit();
} else {
    include 'homepage.php';
}
?>