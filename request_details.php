<?php 
session_start(); 
include('config.php'); 

// User login kora na thakle login page-e pathiye dibe
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database theke request-er details fetch kora
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM requests WHERE id='$id'");
    
    if(mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_array($res);
    } else {
        die("Request not found!");
    }
} else {
    header("Location: search.php");
    exit();
}

$current_user = null;
$current_user_role = null;
$current_user_donor_type = 'regular';
$current_user_name = $_SESSION['name'] ?? ($_SESSION['user_name'] ?? '');

if(isset($_SESSION['user_id'])) {
    $current_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    // users table uses `fullname` and `role` columns (not `name` / `user_role`)
    $user_res = mysqli_query($conn, "SELECT fullname, role, email FROM users WHERE id='$current_user_id' LIMIT 1");
    if($user_res && mysqli_num_rows($user_res) > 0) {
        $current_user = mysqli_fetch_array($user_res);
        $current_user_role = $current_user['role'];
        // donor type column does not exist in this schema; keep default 'regular'
        $current_user_donor_type = 'regular';
        // update display name from DB if available
        if(!empty($current_user['fullname'])) {
            $current_user_name = $current_user['fullname'];
        }
    }
}

$is_thalassemia_request = isset($data['is_thalassemia']) && (int)$data['is_thalassemia'] === 1;
$thal_alert = null;
if(isset($_SESSION['user_id']) && $is_thalassemia_request) {
    $current_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $alert_res = mysqli_query($conn, "SELECT * FROM thalassemia_alerts WHERE request_id='$id' AND donor_id='$current_user_id' LIMIT 1");
    if($alert_res && mysqli_num_rows($alert_res) > 0) {
        $thal_alert = mysqli_fetch_array($alert_res);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Details</title>
    <link rel="stylesheet" href="request_details.css"> 
</head>
<body>

<?php include('navbar.php'); ?>

<div class="details-wrapper">
    <div class="details-box">
        <div class="details-header">
            <span class="status-text">Status: <?php echo ucfirst($data['status']); ?></span>
            <span class="blood-badge"><?php echo $data['blood_group']; ?> REQUIRED</span>
            <h1 style="margin-top: 20px;">Request for <?php echo $data['recipient_name']; ?></h1>
            <p class="location-tag"> <?php echo $data['location']; ?></p>
        </div>

        <div class="info-section">
            <div class="recipient-info">
                <h3>Recipient Information</h3>
                <p><strong>Hospital:</strong> <?php echo $data['hospital']; ?></p>
                <p><strong>Date:</strong> <?php echo $data['date']; ?></p>
                <p><strong>Time:</strong> <?php echo $data['time']; ?></p>
            </div>
            <div class="message-info">
                <h3>Requester Message</h3>
                <p class="msg-text">"<?php echo $data['message']; ?>"</p>
            </div>
        </div>

        <!-- Logic: Check if logged-in user is the one who made the request -->
        <div class="action-area">
            <?php if($_SESSION['user_id'] == $data['user_id']): ?>
                <!-- Request creator cannot donate to themselves -->
                <p style="color: #d32f2f; font-weight: bold; background: #ffebee; padding: 10px; border-radius: 5px; display: inline-block;">
                    This is your own request. You cannot commit as a donor here.
                </p>
            <?php elseif($data['status'] !== 'approved'): ?>
                <p style="color: #b26b00; font-weight: bold; background: #fff8e1; padding: 10px; border-radius: 5px; display: inline-block;">
                    This request is currently <?php echo ucfirst($data['status']); ?>. Fixed donor actions become available after admin approval.
                </p>
            <?php elseif($is_thalassemia_request && $current_user_role === 'donor' && $current_user_donor_type === 'fixed' && $thal_alert && $thal_alert['status'] === 'pending'): ?>
                <p style="color: #0d47a1; font-weight: bold; background: #e3f2fd; padding: 10px; border-radius: 5px; display: inline-block; margin-bottom: 12px;">
                    This is a fixed donor Thalassemia request assigned to you.
                </p>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="thalassemia_alert_logic.php?action=accept&alert_id=<?php echo (int)$thal_alert['id']; ?>" class="donate-now-btn" style="text-decoration:none; display:inline-block;">Accept & Commit</a>
                    <a href="thalassemia_alert_logic.php?action=ignore&alert_id=<?php echo (int)$thal_alert['id']; ?>" class="cancel-btn" style="text-decoration:none; display:inline-block;">Ignore</a>
                </div>
            <?php elseif($is_thalassemia_request && $current_user_role === 'donor' && $current_user_donor_type === 'fixed' && $thal_alert && $thal_alert['status'] === 'accepted'): ?>
                <p style="color: #2e7d32; font-weight: bold; background: #e8f5e9; padding: 10px; border-radius: 5px; display: inline-block;">
                    You have already accepted this fixed donor request. The admin verification step is now pending.
                </p>
            <?php elseif($is_thalassemia_request): ?>
                <p style="color: #c62828; font-weight: bold; background: #ffebee; padding: 10px; border-radius: 5px; display: inline-block;">
                    This is a Thalassemia request reserved for fixed donors. Normal donors cannot commit here.
                </p>
            <?php else: ?>
                <!-- Show button only for other donors -->
                <button onclick="document.getElementById('modal').style.display='block'" class="donate-now-btn">DONATE NOW</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal: Confirm Donation Form -->
<?php if(!$is_thalassemia_request): ?>
<div id="modal" class="modal">
    <div class="modal-content">
        <h2>Confirm Donation</h2>
        <p style="margin-bottom: 20px; color: #666;">Enter your details to notify the requester.</p>
        
        <form action="confirm_logic.php" method="POST">
            <input type="hidden" name="req_id" value="<?php echo $data['id']; ?>">
            
            <div class="input-group">
                <label>Donor Name</label>
                <input type="text" name="d_name" placeholder="Enter your name" required>
            </div>
            
            <div class="input-group">
                <label>Contact (Phone/Email)</label>
                <input type="text" name="d_contact" placeholder="How to reach you?" required>
            </div>
            
            <button type="submit" name="confirm_btn" class="confirm-commit-btn">Confirm & Commit</button>
            <button type="button" onclick="document.getElementById('modal').style.display='none'" class="cancel-btn">Cancel</button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
window.onclick = function(event) {
    if (event.target == document.getElementById('modal')) {
        document.getElementById('modal').style.display = "none";
    }
}
</script>

<?php include('footer.php'); ?>
</body>
</html>