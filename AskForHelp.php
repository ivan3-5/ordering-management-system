<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubmitRefund</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="AskForHelp.css">
</head>
<body>
    <a href="homepage.php">
        <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
    </a>
    <div class="header-text">
        Submit a Ticket
    </div>
    <a href="UserProfile.php"> 
        <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
    </a>
    <div class="bg-container">
        <h2>When you help others feel important, <br>you help yourself feel important too</h2>
    </div>

<div class="new-bg-container">
    <?php
        function generateTicketID($length = 8) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $ticketID = '';
            for ($i = 0; $i < $length; $i++) {
                $ticketID .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $ticketID;
        }

        $ticketID = generateTicketID(8); 
        $todayDate = date("F j, Y");
    ?>
    
<div class="ticket-container">
    <p class="ticket-text">You have your ticket number: <?php echo $ticketID; ?>  Date: <?php echo $todayDate; ?></p>
    
    <div class="input-group">
        <input type="text" id="subject-input" name="subject" class="transparent-input" placeholder="Enter Subject" required>
    </div>
     <div class="input-group">
        <input type="text" id="description-input" name="description" class="transparent-input no-line" placeholder="Enter Description" required>
    </div>
</div>
    <a href="CustomerService.php" class="submit-ticket-button">Submit</a>
</div>

</body>
</html>