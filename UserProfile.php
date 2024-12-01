<?php 
session_start();
include("userdb.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve user data from the database using the session email
$email = $_SESSION['email'];
$sql = "SELECT first_name, last_name FROM usersform WHERE email = ?";
$statement = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($statement, $sql)) {
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $firstname, $lastname);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    // Fullname sa user
    $fullname = $firstname . " " . $lastname;
} else {
    die("Error fetching user data");
}

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
                <i class="fas fa-home fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-motorcycle fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-map-marker-alt fa-2x"></i>
            </div>
            <div class="nav-icon mb-4">
                <i class="fas fa-sign-out-alt fa-2x"></i>
            </div>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 bg-light-brown p-5">
            <h2 class="text-white">PROFILE</h2>
            <div class="d-flex mt-4">
                <!-- Profile -->
                <div class="profile-section bg-brown text-center p-4 rounded">
                    <img src="Photos/gwapo.jpg" alt="Profile Image" class="profile-img rounded-circle mb-3">
                    <h5 class="text-white"><?php echo $fullname ?></h5>
                </div>
                
                <!-- Purchases -->
                <div class="purchases-section flex-grow-1 bg-brown ml-3 p-4 rounded">
                    <h5 class="text-white">Purchases</h5>
                    <hr class="bg-white">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
