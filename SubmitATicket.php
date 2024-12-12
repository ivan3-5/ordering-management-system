<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kotta+One&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="SubmitATicket.css">
</head>
<body>
    <a href="homepage.php">
        <img src="System Pictures/BSIT-2F_Logo_real-removebg-preview.png" alt="Logo" class="logo">
    </a>
    <!-- Customer Service header -->
    <div class="header-text">
        Submit a Ticket
    </div>
    <!-- Profile icon -->
    <a href="UserProfile.php"> 
        <img src="Photos/profile-icon.svg" alt="Profile" class="profile-icon">
    </a>

    <!-- Background image container -->
    <div class="bg-container">
        <!-- Content inside the container -->
        <h2>When you help others feel important, <br>you help yourself feel important too</h2>
    </div>

    <!-- Inside .new-bg-container -->
    <div class="new-bg-container">
        <form id="submit-ticket-form">
            <div class="input-group">
                <label for="subject-input">Subject:</label>
                <input type="text" id="subject-input" name="subject" class="transparent-input" placeholder="Enter Subject" required>
            </div>
            <div class="input-group">
                <label for="description-input">Description:</label>
                <textarea id="description-input" name="description" class="transparent-input no-line" placeholder="Enter Description" required></textarea>
            </div>
            <button type="submit" class="submit-ticket-button">Submit Ticket</button>
        </form>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit-ticket-form').on('submit', function(event) {
                event.preventDefault();

                const subject = $('#subject-input').val();
                const description = $('#description-input').val();

                $.ajax({
                    type: "POST",
                    url: 'Services/AddTicketService.php',
                    data: { subject, description },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.status === "success") {
                            alert('Ticket submitted successfully!');
                            window.location.href = 'CustomerService.php';
                        } else {
                            alert('Failed to submit ticket: ' + data.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>