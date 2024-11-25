<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Login.css">
</head>
<body>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        require_once "userdb.php";

        $sql = "SELECT Password FROM userform WHERE Email = ?";
        $statement = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($statement, $sql)) {
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            mysqli_stmt_bind_result($statement, $hash);
            mysqli_stmt_fetch($statement);

            if ($hash && password_verify($password, $hash)) {
                session_start();
                $_SESSION['email'] = $email;
                header("Location: UserProfile.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid email or password.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Database error.</div>";
        }
    }
}
?>

    <div class="container" id="login">
        <div class="icon">
            <img src="Photos/image logo.png" alt="Ry's">
        </div>
        <h1 class="form-title">Login</h1>
        <form method="post" action="login.php"> 
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <p class="recover">
                <a href="Forgot.php" style="text-decoration: none;">Recover Password</a>
            </p>
            <input type="submit" class="btn" value="Log in" name="login">
        </form>
        <div class="signup">
            <p>Don't have an account?<a href="Signup.php" style="text-decoration: none;"> Sign up</a></p>
        </div>
    </div>
</body>
</html>