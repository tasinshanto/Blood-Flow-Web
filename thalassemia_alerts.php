<?php
session_start();
include('config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'donor') {
    header('Location: login.php');
    exit();
}

$current_donor_id = (int) $_SESSION['user_id'];

$alert_sql = "SELECT ta.id AS alert_id, r.recipient_name, r.blood_group, r.hospital, r.message
              FROM thalassemia_alerts ta
              JOIN requests r ON ta.request_id = r.id
              WHERE ta.donor_id = $current_donor_id AND ta.status = 'pending'
              ORDER BY ta.id DESC";
$alert_result = mysqli_query($conn, $alert_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thalassemia Alerts - BloodFlow</title>
    <link rel="stylesheet" href="user_my_req.css">
    <style>
        .alert-list { display:flex; flex-direction:column; gap:15px; }
        .alert-card {
            display:flex; justify-content:space-between; align-items:center; gap:15px;
            padding:18px; border:1px solid #e4e7eb; border-radius:10px; background:#fff;
            box-shadow:0 2px 8px rgba(0,0,0,0.04);
        }
        .alert-meta h3 { margin:0; }
        .alert-meta p { margin:6px 0; }
        .alert-btn {
            display:inline-block; background:#2e7d32; color:#fff; text-decoration:none;
            padding:10px 16px; border-radius:6px; font-weight:bold;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="user-req-wrapper">
    <div class="container">
        <h1>Thalassemia <span>Alerts</span></h1>
        <p>Approved fixed donor matches assigned to your account.</p>

        <div class="alert-list">
            <?php if($alert_result && mysqli_num_rows($alert_result) > 0): ?>
                <?php while($alert_row = mysqli_fetch_assoc($alert_result)): ?>
                    <div class="alert-card">
                        <div class="alert-meta">
                            <h3>Recipient: <?php echo htmlspecialchars($alert_row['recipient_name']); ?></h3>
                            <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($alert_row['blood_group']); ?></p>
                            <p><strong>Hospital:</strong> <?php echo htmlspecialchars($alert_row['hospital']); ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($alert_row['message']); ?></p>
                        </div>
                        <div>
                            <a class="alert-btn" href="accept_thalassemia.php?id=<?php echo (int)$alert_row['alert_id']; ?>">Accept Request</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty">No pending thalassemia alerts assigned yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>