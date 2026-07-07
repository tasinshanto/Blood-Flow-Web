<?php
session_start();
include('config.php');

$blood_bank_table_ready = false;
$blood_bank_check = mysqli_query($conn, "SHOW TABLES LIKE 'blood_banks'");
if($blood_bank_check && mysqli_num_rows($blood_bank_check) > 0) {
    $blood_bank_table_ready = true;
}

// =========================================================================
// SECURITY CHECK: Shudhu logged in System Admin eikhane dhukte parbe
// =========================================================================
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("<div style='padding:20px; color:red; font-weight:bold; font-family:sans-serif;'>❌ Fatal Error: Unauthorized Access! Only System Administrators can access this engine node.</div>");
}

// =========================================================================
// FORM PROCESSING LOGIC: Save button click hole database query run hobe
// =========================================================================
if(isset($_POST['save_bank_btn'])) {
    if(!$blood_bank_table_ready) {
        die('Blood bank schema is not available in the current database.');
    }

    // String inputs data sanitize kora hocche SQL injection prevent korar jonno
    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    
    // Quantity values gulo cast integer logic map algorithm e sanitize kora holo
    $stock_a_pos = (int)$_POST['stock_a_positive'];
    $stock_a_neg = (int)$_POST['stock_a_negative'];
    $stock_b_pos = (int)$_POST['stock_b_positive'];
    $stock_b_neg = (int)$_POST['stock_b_negative'];
    $stock_o_pos = (int)$_POST['stock_o_positive'];
    $stock_o_neg = (int)$_POST['stock_o_negative'];
    $stock_ab_pos = (int)$_POST['stock_ab_positive'];
    $stock_ab_neg = (int)$_POST['stock_ab_negative'];

    // SQL execution structure map insertion query string
    
    $query = "INSERT INTO blood_banks (bank_name, location, contact_no, stock_a_positive, stock_a_negative, stock_b_positive, stock_b_negative, stock_o_positive, stock_o_negative, stock_ab_positive, stock_ab_negative) 
              VALUES ('$bank_name', '$location', '$contact_no', '$stock_a_pos', '$stock_a_neg', '$stock_b_pos', '$stock_b_neg', '$stock_o_pos', '$stock_o_neg', '$stock_ab_pos', '$stock_ab_neg')";

    if(mysqli_query($conn, $query)) {
        // Dynamic row block successfully save hole dashboard confirmation alert ashbe
        echo "<script>alert('New Institutional Blood Bank Node Registered Systematically!'); window.location='admin_dashboard.php';</script>";
        exit();
    } else {
        echo "Database core schema write tracking failure execution error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Institutional Blood Bank - Admin</title>
    <link rel="stylesheet" href="add_blood_bank.css">
</head>
<body>

<?php include('navbar.php'); ?>

<?php if(!$blood_bank_table_ready): ?>
<div style="max-width: 900px; margin: 40px auto; padding: 20px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 8px; font-family: sans-serif;">
    <strong>Blood bank feature unavailable.</strong> The current schema does not include the <em>blood_banks</em> table, so this admin form is disabled.
</div>
<?php else: ?>
<div class="admin-wrapper">
    <div class="admin-box">
        <h2>🏢 Add Institutional Blood Bank Nodes</h2>
        <p>Control Panel Module: Registered structural inventory database node parameters entry management grid array configuration schema setup.</p>
        
        <form action="add_blood_bank.php" method="POST">
            
            <div class="row-group">
                <div class="field-unit">
                    <label>Blood Bank Name</label>
                    <input type="text" name="bank_name" placeholder="e.g. Quantum Lab (Dhaka)" required>
                </div>
                <div class="field-unit">
                    <label>Hotline / Contact Info</label>
                    <input type="text" name="contact_no" placeholder="e.g. +88017XXXXXXXX" required>
                </div>
            </div>

            <div class="field-unit" style="margin-bottom: 25px;">
                <label>Operational Address (District Location)</label>
                <input type="text" name="location" placeholder="e.g. Dhanmondi, Dhaka" required>
            </div>

            <div class="stock-header-title">📊 Live Initial Stock Inventory Quantities Configuration (In Bags Size Count)</div>
            
            <div class="stock-grid">
                <div class="field-unit">
                    <label>A+ Quantity</label>
                    <input type="number" name="stock_a_positive" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>A- Quantity</label>
                    <input type="number" name="stock_a_negative" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>B+ Quantity</label>
                    <input type="number" name="stock_b_positive" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>B- Quantity</label>
                    <input type="number" name="stock_b_negative" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>O+ Quantity</label>
                    <input type="number" name="stock_o_positive" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>O- Quantity</label>
                    <input type="number" name="stock_o_negative" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>AB+ Quantity</label>
                    <input type="number" name="stock_ab_positive" value="0" min="0" required>
                </div>
                <div class="field-unit">
                    <label>AB- Quantity</label>
                    <input type="number" name="stock_ab_negative" value="0" min="0" required>
                </div>
            </div>

            <div class="btn-panel">
                <button type="submit" name="save_bank_btn" class="save-btn">💾 Save & Add Inventory</button>
                <a href="admin_dashboard.php" class="dash-link">Admin Dashboard</a>
                <a href="admin_dashboard.php" class="back-link">Cancel</a>
            </div>

        </form>
    </div>
</div>
<?php endif; ?>

<?php include('footer.php'); ?>

</body>
</html>