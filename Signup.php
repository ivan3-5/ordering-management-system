<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Signup.css">
</head>
<body>

    <?php
    if(isset($_POST['submit'])) {
       $firstname = $_POST["fname"];
       $lastname = $_POST["lname"];
       $email = $_POST["email"];
       $password = $_POST["password"];
       $phonenumber = $_POST["pnumber"];

       $hash = password_hash($password, PASSWORD_DEFAULT);
       $error = array();

       if(empty($firstname) OR empty($lastname) OR empty($email) OR empty($password) OR empty($phonenumber)) {
        array_push($error,"Field is blank.");
       }
       if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, "Email missing");
       }
       if(strlen($password)<8) {
        array_push($error, "");
       }
       if(count($error)>0) {
        foreach($error as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
       } else {
        require_once "userdb.php";
        $sql = "INSERT INTO userform (FirstName, LastName, Email, Password, PhoneNumber) VALUES (?, ?, ?, ?, ?)";
        $statement = mysqli_stmt_init($conn);
        $prepare = mysqli_stmt_prepare($statement, $sql);
        if($prepare) {
            mysqli_stmt_bind_param($statement, "sssss", $firstname, $lastname, $email, $hash, $phonenumber, );
            mysqli_stmt_execute($statement);

            $message = "<div class='alert alert-success'>Account successfully created!</div>";
        } else {
           die("Error");
        }
       }
    }
    ?>

    <div class="container" id="signup">
        <div class="icon">
            <img src="Photos/image logo.png" alt="Ry's">
        </div>
        <h1 class="form">Register</h1>
        <form action="Signup.php" method="post">
            <div class="input">
                <input type="text" name="fname" id="fname" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input">
                <input type="text" name="lname" id="lname" placeholder="Last Name">
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
            <input type="submit" class="btn" value="Sign Up" name="submit">
            <div class="login">
                <p>Already have an account? <a href="Login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>