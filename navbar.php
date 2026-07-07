<?php 
// Session start kora na thakle start korbe
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
$display_name = $_SESSION['name'] ?? ($_SESSION['user_name'] ?? null);
$user_role = $_SESSION['user_role'] ?? null;
?>
<nav class="navbar">
    <div class="logo">BloodFlow</div>
    <ul class="nav-menu">
        <li><a href="deshbord.php">Home</a></li>
        
        <!-- Always-visible link to the public blood banks list -->
        <li><a href="blood_banks_list.php">Blood Bank Inventory</a></li>
        <?php if($display_name): ?>
            <li><a href="request_form.php">Post Request</a></li>
            <li><a href="user_my_req.php">My Requests</a></li>
        <?php endif; ?>
        
        <li><a href="search.php">Donation Requests</a></li>

        <!-- Removed duplicate inventory link: single 'Blood Bank Inventory' entry above is used across all pages -->
        <li><a href="vlog.php">Blog</a></li>

        <?php if($user_role === 'donor'): ?>
            <li><a href="thalassemia_alerts.php">Thalassemia Alerts</a></li>
        <?php endif; ?>
    </ul>
    
    <div class="nav-auth">
        <?php if($display_name): ?>
            <?php if($user_role == 'admin'): ?>
                <a href="admin_dashboard.php" style="color: #50c878; margin-right: 15px; font-weight: bold;">Admin Panel</a>
            <?php endif; ?>

            <span class="user-welcome">Hi, <?php echo $display_name; ?></span>
            <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
            <a href="registration.php" class="btn-join">Join Now</a>
        <?php endif; ?>
    </div>
</nav>

<style>
/* Navbar basic styling */
.navbar {
    background: linear-gradient(to right, #2c3e50, #4b79a1) !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 18px 60px !important;
    color: #ffffff !important;
    box-shadow: 0 2px 0 rgba(0,0,0,0.15) !important;
}
.nav-menu { display: flex !important; list-style: none !important; gap: 28px !important; align-items: center !important; }
.nav-menu a { color: #ffffff !important; text-decoration: none !important; font-weight: 600 !important; font-size: 15px !important; padding: 6px 4px !important; }
.nav-menu a:hover { color: #ffd59a !important; }

.btn-login {
    background: rgba(255,255,255,0.04) !important;
    border: 1px solid rgba(255,255,255,0.6) !important;
    padding: 6px 14px !important;
    color: #ffffff !important;
    border-radius: 6px !important;
    text-decoration: none !important;
}
.btn-join {
    background: #d32f2f !important;
    padding: 6px 14px !important;
    color: white !important;
    border-radius: 6px !important;
    text-decoration: none !important;
    margin-left: 10px !important;
    font-weight: 700 !important;
}
.user-welcome { font-weight: 700 !important; color: #65d07a !important; margin-right: 12px !important; }
</style>