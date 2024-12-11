<?php
session_start();
if (isset($_SESSION['UserRole'])) {
    echo json_encode(['role' => $_SESSION['UserRole']]);
} else {
    echo json_encode(['role' => 'guest']);
}
?>