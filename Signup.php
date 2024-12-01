<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Signup.css">
</head>
<body>

    <?php
    $success = ""; // Initialize success message variable

    if (isset($_POST['submit'])) {
        $firstname = trim($_POST["fname"]);
        $lastname = trim($_POST["lname"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $phonenumber = trim($_POST["pnumber"]);
        $address = trim($_POST["address"]);

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $error = [];

        if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($phonenumber) || empty($address)) {
            $error[] = "All fields are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Invalid email format.";
        }
        if (strlen($password) < 8) {
            $error[] = "Password must be at least 8 characters long.";
        }

        if (count($error) > 0) {
            foreach ($error as $msg) {
                echo "<div class='alert alert-danger'>$msg</div>";
            }
        } else {
            require_once "userdb.php";

            $sql = "INSERT INTO usersform (first_name, last_name, email, password, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $email, $hash, $phonenumber, $address);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Account created successfully!";
                } else {
                    echo "<div class='alert alert-danger'>Error creating account. Please try again later.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Database error. Please contact support.</div>";
            }
        }
    }
    ?>

    <div class="container" id="signup">
        <div class="icon">
            <img src="Photos/image logo.png" alt="Ry's">
        </div>
        <h1 class="form">Register</h1>

        <!-- Display success message if account creation is successful -->
        <?php if (!empty($success)) : ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="Signup.php" method="post">
            <div class="input">
                <input type="text" name="fname" id="fname" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input">
                <input type="text" name="lname" id="lname" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="input">
                <input type="text" name="pnumber" id="pnumber" placeholder="Phone Number" required>
                <label for="pnumber">Phone Number</label>
            </div>
            <div class="input">
                <input type="text" name="address" id="address" placeholder="Address" required>
                <label for="address">Address</label>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="submit">
            <div class="login">
                <p>Already have an account? <a href="Login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
