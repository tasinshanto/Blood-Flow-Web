<?php
session_start();
include('config.php');

// Security Check: Only Admin can execute these logics
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { 
    die("Unauthorized Access! Only admin can perform this action."); 
}

function create_thalassemia_alerts($conn, $request_id, $blood_group) {
    $safe_request_id = mysqli_real_escape_string($conn, $request_id);
    $safe_blood_group = mysqli_real_escape_string($conn, $blood_group);

    // users table uses `role` column (not user_role) and donor_type does not exist in schema
    $donor_query = "SELECT id FROM users WHERE role='donor' AND blood_group='$safe_blood_group'";
    $donor_result = mysqli_query($conn, $donor_query);

    if($donor_result && mysqli_num_rows($donor_result) > 0) {
        while($donor_row = mysqli_fetch_array($donor_result)) {
            $donor_id = (int)$donor_row['id'];
            $check_query = "SELECT id FROM thalassemia_alerts WHERE request_id='$safe_request_id' AND donor_id='$donor_id' LIMIT 1";
            $check_result = mysqli_query($conn, $check_query);

            if($check_result && mysqli_num_rows($check_result) === 0) {
                $insert_query = "INSERT INTO thalassemia_alerts (request_id, donor_id, status) VALUES ('$safe_request_id', '$donor_id', 'pending')";
                mysqli_query($conn, $insert_query);
            }
        }
    }
}

// LOGIC 1: Approve User's Blood Request (Section 1)
if(isset($_GET['approve_req_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['approve_req_id']);

    $request_result = mysqli_query($conn, "SELECT id, blood_group, is_thalassemia FROM requests WHERE id='$id' LIMIT 1");
    $request_data = $request_result ? mysqli_fetch_array($request_result) : null;
    
    // Status update: pending -> approved
    $sql = "UPDATE requests SET status='approved' WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        if($request_data && isset($request_data['is_thalassemia']) && (int)$request_data['is_thalassemia'] === 1) {
            create_thalassemia_alerts($conn, $request_data['id'], $request_data['blood_group']);
        }
        header("Location: admin_dashboard.php?msg=approved_success");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// LOGIC 2: Verify Donor's Confirmation (Section 2)
if(isset($_GET['verify_donor_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['verify_donor_id']);
    
    // Status update: accepted -> verified
    // Jokhoni verified hobe, tokhoni oita Section 2 theke sore jabe
    $sql = "UPDATE requests SET status='verified' WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?msg=donor_verified_success");
        exit();
    } else {
        echo "Error verifying donor: " . mysqli_error($conn);
    }
}

// LOGIC 3: Reject Request with Comment
if(isset($_POST['reject_btn'])) {
    $id = isset($_POST['reject_req_id']) ? mysqli_real_escape_string($conn, $_POST['reject_req_id']) : '';
    $comment = isset($_POST['reject_comment']) ? mysqli_real_escape_string($conn, $_POST['reject_comment']) : 'No reason provided';
    
    if($id) {
        // Check if requests table has a rejection_reason column; if not, we can add a simple log or just update status
        $sql = "UPDATE requests SET status='rejected' WHERE id='$id'";
        
        if(mysqli_query($conn, $sql)) {
            // Optional: Log the rejection comment to a separate table if needed
            // For now, we just update status and redirect
            header("Location: admin_dashboard.php?msg=request_rejected");
            exit();
        } else {
            echo "Error rejecting request: " . mysqli_error($conn);
        }
    }
}

// LOGIC 4: Reject Donor Confirmation with Comment
if(isset($_POST['reject_donor_btn'])) {
    $id = isset($_POST['reject_donor_id']) ? mysqli_real_escape_string($conn, $_POST['reject_donor_id']) : '';
    $comment = isset($_POST['reject_donor_comment']) ? mysqli_real_escape_string($conn, $_POST['reject_donor_comment']) : 'No reason provided';
    
    if($id) {
        // Update the request status back to 'approved' (removing donor acceptance)
        $sql = "UPDATE requests SET status='approved', donor_name=NULL, donor_contact=NULL WHERE id='$id'";
        
        if(mysqli_query($conn, $sql)) {
            header("Location: admin_dashboard.php?msg=donor_rejected");
            exit();
        } else {
            echo "Error rejecting donor: " . mysqli_error($conn);
        }
    }
}

// =========================================================================
// NEW LOGIC 5: BLOOD BANK REQUISITION APPROVAL & DEDUCTION MANAGEMENT
// =========================================================================
if(isset($_GET['bank_action']) && isset($_GET['bank_req_id'])) {
    $bank_tables_ready = true;
    $bank_table_check = mysqli_query($conn, "SHOW TABLES LIKE 'bank_requests'");
    if(!$bank_table_check || mysqli_num_rows($bank_table_check) === 0) {
        $bank_tables_ready = false;
    }

    $blood_bank_check = mysqli_query($conn, "SHOW TABLES LIKE 'blood_banks'");
    if(!$blood_bank_check || mysqli_num_rows($blood_bank_check) === 0) {
        $bank_tables_ready = false;
    }

    if(!$bank_tables_ready) {
        die('Blood bank requisition tables are not available in the current database schema.');
    }

    $req_id = mysqli_real_escape_string($conn, $_GET['bank_req_id']);
    $action = $_GET['bank_action'];

    if($action == 'approve') {
        // Step A: Request information fetch kora processing tracking matrix
        $req_info = mysqli_query($conn, "SELECT * FROM bank_requests WHERE id = '$req_id' AND status = 'pending'");
        if(mysqli_num_rows($req_info) > 0) {
            $req_data = mysqli_fetch_array($req_info);
            $bank_id = $req_data['bank_id'];
            $bags = $req_data['bags_needed'];
            
            // Step B: Formating Blood group column name (e.g., A+ to stock_a_positive)
            $bg = strtolower(str_replace(['+', '-'], ['_positive', '_negative'], $req_data['blood_group']));
            $column_name = "stock_" . $bg;

            // Step C: Stock level limits checking validation
            $stock_check = mysqli_query($conn, "SELECT $column_name FROM blood_banks WHERE id = '$bank_id'");
            $stock_data = mysqli_fetch_array($stock_check);
            
            if($stock_data[$column_name] >= $bags) {
                // SQL Pipeline: Stock logic minus and Request status approved query
                $deduct_sql = "UPDATE blood_banks SET $column_name = $column_name - $bags WHERE id = '$bank_id'";
                $update_status_sql = "UPDATE bank_requests SET status = 'approved' WHERE id = '$req_id'";
                
                if(mysqli_query($conn, $deduct_sql) && mysqli_query($conn, $update_status_sql)) {
                    header("Location: admin_dashboard.php?msg=bank_req_approved");
                    exit();
                } else {
                    echo "Error processing dynamic transaction: " . mysqli_error($conn);
                }
            } else {
                echo "<script>alert('❌ Error: Inadequate blood bags in institutional inventory stock matrix!'); window.location='admin_dashboard.php';</script>";
                exit();
            }
        }
    } elseif($action == 'reject') {
        // Status update: pending -> rejected
        $sql = "UPDATE bank_requests SET status = 'rejected' WHERE id = '$req_id'";
        if(mysqli_query($conn, $sql)) {
            header("Location: admin_dashboard.php?msg=bank_req_rejected");
            exit();
        } else {
            echo "Error rejecting record: " . mysqli_error($conn);
        }
    }
}
?>