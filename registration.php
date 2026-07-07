<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Register</title>
    <!-- Same CSS file used for Login to keep UI same -->
    <link rel="stylesheet" href="registration.css"> 
</head>
<body>

<div class="reg-container">
    <!-- Header: Same as Login Page UI -->
    <div class="reg-header">
        <div class="icon">💧</div>
        <h1>Blood Donation</h1>
        <p>Register as a life saver</p>
    </div>

    <form action="registration_logic.php" method="POST">
        <div class="input-box">
            <label>Full Name</label>
            <input type="text" name="fullname" placeholder="Enter your full name" required>
        </div>

        <div class="input-box">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
        </div>

        <!-- Role Selection -->
        <div class="input-box">
            <label>Register As</label>
            <select name="role" required>
                <option value="user">Normal User (Needs Blood)</option>
                <option value="donor">Donor (Give Blood)</option>
            </select>
        </div>

        <div class="input-box">
            <label>Donor Type</label>
            <select name="donor_type" required>
                <option value="regular">Regular Donor</option>
                <option value="fixed">Fixed Donor (Thalassemia Support)</option>
            </select>
        </div>

        <!-- NID Number (Text Input instead of File) -->
        <div class="input-box">
            <label>National ID Number (NID)</label>
            <input type="text" name="nid_number" placeholder="Enter your 10 or 17 digit NID" required>
        </div>

        <!-- All Blood Groups Added -->
        <div class="input-box">
            <label>Blood Group</label>
            <select name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
        </div>

        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Create a strong password" required>
        </div>

        <button type="submit" name="register_btn" class="reg-btn">Register Now</button>
        
        <p class="auth-footer-text">Already registered? <a href="login.php">Login</a></p>
    </form>
</div>

<!-- Common Footer -->
<?php include('footer.php'); ?>

</body>
</html>