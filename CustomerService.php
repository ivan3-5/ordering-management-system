<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: homepage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="CustomerService.css">
</head>
<body>
    <a href="homepage.php">
        <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
    </a>
    <div class="header-text">
        Customer Service
    </div>
    <a href="UserProfile.php"> 
        <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
    </a>
    <div class="bg-container">
        <h2>When you help others feel important, <br>you help yourself feel important too</h2>
    </div>
    <div class="new-bg-container">
        <a href="SubmitATicket.php" class="submit-ticket-button">Submit a Ticket</a>
    </div>
    
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/customer-service.js"></script>
</body>
</html>