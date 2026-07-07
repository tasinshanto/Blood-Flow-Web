<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <!-- Header part with Red Gradient -->
    <div class="login-header">
        <div class="icon"></div>
        <h1>Blood Donation</h1>
        <p>Login to save lives</p>
    </div>

    <form action="login_logic.php" method="POST">
        <div class="input-box">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
        </div>

        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="forgot">
            <a href="#">Forgot password?</a>
        </div>

        <!-- Main Login Button -->
        <button type="submit" name="login_btn" class="login-btn">Login</button>

        <div class="or-divider">OR</div>

        <!-- Social Login Option -->
        <button type="button" class="google-btn">Continue with Google</button>
        
        <p class="footer-text">Don't have an account? <a href="registration.php">Register</a></p>
    </form>
</div>

<!-- Common Footer Included Here -->
<?php include('footer.php'); ?>

</body>
</html>