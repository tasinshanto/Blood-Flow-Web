<?php session_start(); ?>
<nav class="navbar">
    <div class="logo">BloodFlow</div>
    <ul class="nav-menu">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="#">Donation Request</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Search Request</a></li>
    </ul>
    <div class="nav-auth">
        <?php if(isset($_SESSION['user_name'])): ?>
            <!-- Show User Name if logged in -->
            <span class="user-welcome">Hi, <?php echo $_SESSION['user_name']; ?></span>
            <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
            <!-- Show Login/Join if not logged in -->
            <a href="login.php" class="btn-login">Login</a>
            <a href="registration.php" class="btn-join">Join Now</a>
        <?php endif; ?>
    </div>
</nav>

<style>
/* Navbar CSS from your image */
.navbar { background: linear-gradient(to right, #2c3e50, #4b79a1); display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; color: white; }
.nav-menu { display: flex; list-style: none; gap: 20px; }
.nav-menu a { color: white; text-decoration: none; font-weight: bold; }
.btn-login { background: rgba(255,255,255,0.1); border: 1px solid white; padding: 5px 15px; color: white; border-radius: 5px; text-decoration: none; }
.btn-join { background: #1A1F2C; padding: 5px 15px; color: white; border-radius: 5px; text-decoration: none; margin-left: 10px; }
.user-welcome { font-weight: bold; color: #50c878; margin-right: 10px; }
</style>