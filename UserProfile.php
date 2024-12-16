<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['UserRole'] !== 'user') {
    header('Location: homepage.php');
    exit();
}

require_once __DIR__ . '/Services/DbConnector.php';

$userId = $_SESSION['id'];

// Fetch user information
$sql = "SELECT Email, PhoneNumber, Address FROM users WHERE Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($email, $phoneNumber, $address);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="UserProfile.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-brown d-flex flex-column align-items-center py-4">
            <div class="nav-icon mb-4">
                <a href="homepage.php">
                    <i class="fas fa-home fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <a href="OrderHistory.php">
                    <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <a href="CustomerService.php">
                    <i class="fas fa-comment fa-2x"></i>
                </a>
            </div>

            <div class="nav-icon mb-4">
                <i class="fas fa-sign-out-alt fa-2x" onclick="logout()"></i>
            </div>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 bg-light-brown d-flex justify-content-center align-items-center p-5">
            <!-- Profile -->
            <div class="profile-section bg-brown text-center p-4 rounded">
                <img src="Photos/profile-icon.svg" alt="Profile Image" class="profile-img rounded-circle mb-3">
                <h5 id="fullname" class="text-white"><?php echo htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']); ?></h5>
                <br>

                <!-- ACCOUNT INFO -->
                <p class="info">Email: <?php echo htmlspecialchars($email); ?></p>
                <p class="info">Phone Number: <?php echo htmlspecialchars($phoneNumber); ?></p>
                <p class="info">Address: <?php echo htmlspecialchars($address); ?></p>
                <br>
                <button class="edit btn btn-primary mt-4">Edit Profile</button>
                
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/order-list.service.js"></script>
    <script type="text/javascript">
        let purchasedList = [];
        let purchasedOrderList = [];

        $(document).ready(function() {
            getUser();
            getPurchases();
        });

        function getUser() {
            $.ajax({
                type: "GET",
                url: 'Services/User/GetLoggedInService.php',
                success: function(response) {
                    console.log('login: ', response);
                    const data = JSON.parse(response);
                    if (data.status === "success") {
                        $('#fullname').text(data.FirstName + ' ' + data.LastName);
                    } else {
                        console.log("Unauthorized!");
                    }
                }
            });
        }

        function getPurchases() {
            $.ajax({
                type: "GET",
                url: 'Services/GetPurchaseListService.php',
                success: function(response) {
                    console.log('purchases: ', response);
                    const data = JSON.parse(response);
                    if (data.status === "success") {
                        purchasedList = data.purchasedList;
                        purchasedOrderList = data.purchasedOrderList;
                        displayPurchases();
                    } else {
                        console.log("Failed to fetch purchases!");
                    }
                }
            });
        }

        function displayPurchases() {
            // Implement the logic to display purchases
        }

        function logout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'Services/User/LogoutService.php';
            }
        }
    </script>
</body>
</html>
