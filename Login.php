<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container" id="login">
        <div class="icon">
            <a href="homepage.php">
                <img src="Photos/image logo.png" alt="Ninong Ry's" title="Ninong Ry's">
            </a>
        </div>
        <h1 class="form-title">Login</h1>
        <div id="alert-container"></div>
        <form id="login-form">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                <span class="toggle-password">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </span>
            </div>
            <p class="recover">
                <a href="Forgot.php" style="text-decoration: none;">Recover Password</a>
            </p>
            <button type="submit" class="btn">Log in</button>
        </form>
        <div class="signup">
            <p>Don't have an account?<a href="Signup.php" style="text-decoration: none;"> Sign up</a></p>
        </div>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/login.js"></script>
</body>
</html>