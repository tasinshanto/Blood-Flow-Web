<?php 
session_start();
include('config.php');
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .admin-table th { background-color: #f8f9fa; color: #d32f2f; }
        .btn-verify { background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .badge-pending { background: #ffeeb3; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="admin-wrapper" style="padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1>Admin <span>Dashboard</span></h1>
        <a href="add_blood_bank.php" style="background: #2c3e50; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: 0.3s;">
            🏢 Add Institutional Blood Bank Node
        </a>
    </div>

    <h3>1. New Blood Requests (Status: Pending)</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Recipient</th>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Shudhu pending requests
            $res1 = mysqli_query($conn, "SELECT * FROM requests WHERE status='pending'");
            if(mysqli_num_rows($res1) > 0) {
                while($r = mysqli_fetch_array($res1)) {
                    echo "<tr>
                            <td>$r[recipient_name]</td>
                            <td>$r[blood_group]</td>
                            <td>
                                <a href='admin_logic.php?approve_req_id=$r[id]' style='background:green; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; margin-right:5px;'>Approve</a>
                                <button onclick=\"openRejectModal($r[id])\" style='background:#d32f2f; color:white; padding:6px 12px; border:none; border-radius:4px; cursor:pointer;'>Reject</button>
                            </td>
                          </tr>";
                }
            } else { echo "<tr><td colspan='3'>No new requests.</td></tr>"; }
            ?>
        </tbody>
    </table>

    <h3>2. Donor Confirmations (Need Verification)</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Donor Name</th>
                <th>For Recipient</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            /* FORCE QUERY: Jader donor_name ache kintu ekhono verified na */
            $res2 = mysqli_query($conn, "SELECT * FROM requests WHERE donor_name IS NOT NULL AND status='accepted'");
            
            if(mysqli_num_rows($res2) > 0) {
                while($d = mysqli_fetch_array($res2)) {
                    echo "<tr>
                            <td>$d[donor_name]</td>
                            <td>$d[recipient_name]</td>
                            <td>$d[donor_contact]</td>
                            <td>
                                <a href='admin_logic.php?verify_donor_id=$d[id]' class='btn-verify' style='margin-right:5px;'>Verify & Notify</a>
                                <button onclick=\"openDonorRejectModal($d[id], '$d[donor_name]')\" style='background:#d32f2f; color:white; padding:6px 12px; border:none; border-radius:4px; cursor:pointer;'>Reject</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; color:gray;'>No donor confirmations found in database.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>3. Registered Institutional Blood Banks Inventory</h3>
    <?php
    $blood_bank_check = mysqli_query($conn, "SHOW TABLES LIKE 'blood_banks'");
    if($blood_bank_check && mysqli_num_rows($blood_bank_check) > 0):
    ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Bank Name</th>
                <th>Location</th>
                <th>Contact</th>
                <th>A+</th>
                <th>A-</th>
                <th>B+</th>
                <th>B-</th>
                <th>O+</th>
                <th>O-</th>
                <th>AB+</th>
                <th>AB-</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $blood_bank_sql = "SELECT * FROM blood_banks ORDER BY id DESC";
            $blood_bank_res = mysqli_query($conn, $blood_bank_sql);
            
            if($blood_bank_res && mysqli_num_rows($blood_bank_res) > 0) {
                while($bb_row = mysqli_fetch_array($blood_bank_res)) {
            ?>
                <tr>
                    <td><strong>🏢 <?php echo htmlspecialchars($bb_row['bank_name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($bb_row['location']); ?></td>
                    <td><?php echo htmlspecialchars($bb_row['contact_no']); ?></td>
                    <td><?php echo $bb_row['stock_a_positive']; ?></td>
                    <td><?php echo $bb_row['stock_a_negative']; ?></td>
                    <td><?php echo $bb_row['stock_b_positive']; ?></td>
                    <td><?php echo $bb_row['stock_b_negative']; ?></td>
                    <td><?php echo $bb_row['stock_o_positive']; ?></td>
                    <td><?php echo $bb_row['stock_o_negative']; ?></td>
                    <td><?php echo $bb_row['stock_ab_positive']; ?></td>
                    <td><?php echo $bb_row['stock_ab_negative']; ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='11' style='text-align:center; color:gray; font-style:italic;'>No blood banks registered yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:#777; font-style:italic;">Blood banks are disabled in the current schema.</p>
    <?php endif; ?>

    <h3>4. User Blood Bank Requisition Requests Logs</h3>
    <?php
    $bank_table_check = mysqli_query($conn, "SHOW TABLES LIKE 'bank_requests'");
    $blood_bank_check = mysqli_query($conn, "SHOW TABLES LIKE 'blood_banks'");
    $bank_tables_ready = $bank_table_check && mysqli_num_rows($bank_table_check) > 0 && $blood_bank_check && mysqli_num_rows($blood_bank_check) > 0;
    ?>
    <?php if($bank_tables_ready): ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Requested Blood Bank Node</th>
                <th>Group</th>
                <th>Bags</th>
                <th>Reason Context Notes</th>
                <th>Current Status</th>
                <th>Execution Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bank_sql = "SELECT br.*, bb.bank_name 
                         FROM bank_requests br 
                         JOIN blood_banks bb ON br.bank_id = bb.id 
                         ORDER BY br.id DESC";
            $bank_res = mysqli_query($conn, $bank_sql);
            
            if($bank_res && mysqli_num_rows($bank_res) > 0) {
                while($b_row = mysqli_fetch_array($bank_res)) {
            ?>
                <tr>
                    <td><strong>User #<?php echo $b_row['user_id']; ?></strong></td>
                    <td>🏢 <?php echo $b_row['bank_name']; ?></td>
                    <td><span style="color:#d32f2f; font-weight:bold;"><?php echo $b_row['blood_group']; ?></span></td>
                    <td><?php echo $b_row['bags_needed']; ?> Bags</td>
                    <td><small><?php echo htmlspecialchars($b_row['reason']); ?></small></td>
                    <td><span class="badge badge-<?php echo $b_row['status']; ?>"><?php echo $b_row['status']; ?></span></td>
                    <td>
                        <?php if($b_row['status'] == 'pending'): ?>
                            <a href="admin_logic.php?bank_action=approve&bank_req_id=<?php echo $b_row['id']; ?>" style="background:#2e7d32; color:white; padding:5px 10px; text-decoration:none; border-radius:4px; font-weight:bold; font-size:12px; margin-right:5px;">Approve</a>
                            <a href="admin_logic.php?bank_action=reject&bank_req_id=<?php echo $b_row['id']; ?>" style="background:#c62828; color:white; padding:5px 10px; text-decoration:none; border-radius:4px; font-weight:bold; font-size:12px;">Reject</a>
                        <?php else: ?>
                            <span style="color:#888; font-style:italic; font-size:13px;">No Action Pending</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center; color:gray; font-style:italic;'>No blood bank requisitions dropped by users yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="color:#777; font-style:italic;">Blood bank requisitions are disabled in the current schema.</p>
    <?php endif; ?>
    </div>

<!-- Rejection Modal for Requests -->
<div id="rejectModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:30px; border-radius:8px; width:90%; max-width:500px; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top:0; color:#333;">Reject Request</h3>
        <form action="admin_logic.php" method="POST">
            <input type="hidden" id="reject_req_id" name="reject_req_id" value="">
            <div style="margin-bottom:15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Rejection Comment (Optional)</label>
                <textarea name="reject_comment" rows="4" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px; font-family:Arial, sans-serif;">Please provide reason for rejection...</textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" style="background:#888; color:white; padding:8px 16px; border:none; border-radius:4px; cursor:pointer;">Cancel</button>
                <button type="submit" name="reject_btn" style="background:#d32f2f; color:white; padding:8px 16px; border:none; border-radius:4px; cursor:pointer; font-weight:bold;">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<!-- Rejection Modal for Donor Confirmations -->
<div id="donorRejectModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:30px; border-radius:8px; width:90%; max-width:500px; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top:0; color:#333;">Reject Donor Confirmation</h3>
        <p id="donorName" style="color:#666; margin-bottom:15px;"></p>
        <form action="admin_logic.php" method="POST">
            <input type="hidden" id="reject_donor_id" name="reject_donor_id" value="">
            <div style="margin-bottom:15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Rejection Reason (Optional)</label>
                <textarea name="reject_donor_comment" rows="4" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px; font-family:Arial, sans-serif;">Please provide reason for rejection...</textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeDonorRejectModal()" style="background:#888; color:white; padding:8px 16px; border:none; border-radius:4px; cursor:pointer;">Cancel</button>
                <button type="submit" name="reject_donor_btn" style="background:#d32f2f; color:white; padding:8px 16px; border:none; border-radius:4px; cursor:pointer; font-weight:bold;">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(reqId) {
    document.getElementById('reject_req_id').value = reqId;
    document.getElementById('rejectModal').style.display = 'block';
}
function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
function openDonorRejectModal(donorId, donorName) {
    document.getElementById('reject_donor_id').value = donorId;
    document.getElementById('donorName').textContent = 'Rejecting donor confirmation from: ' + donorName;
    document.getElementById('donorRejectModal').style.display = 'block';
}
function closeDonorRejectModal() {
    document.getElementById('donorRejectModal').style.display = 'none';
}
window.onclick = function(event) {
    var modal = document.getElementById('rejectModal');
    var donorModal = document.getElementById('donorRejectModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
    if (event.target == donorModal) {
        donorModal.style.display = 'none';
    }
}
</script>
</body>
</html>