<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="icon" href="Photos/image logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Forgot.css">
</head>
<body>
    <div class="container" id="forget-password">
        <div class="icon">
            <img src="Photos/image logo.png" alt="Ry's">
        </div>
        <h1 class="form">Forgot Password</h1>
        <p class="instructions">Enter your email address to reset your password.</p>
        <form method="post" action="reset-password.php">
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
        <button class="btn back" onclick="window.history.back();">Back</button>
    </div>
</body>
</html>
