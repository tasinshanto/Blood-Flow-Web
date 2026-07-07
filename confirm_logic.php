<?php
session_start();
include('config.php');

// Backend Security: Login check
if(!isset($_SESSION['user_id'])) {
    die("Unauthorized! Please login first to commit a donation.");
}

if(isset($_POST['confirm_btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['req_id']);
    $name = mysqli_real_escape_string($conn, $_POST['d_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['d_contact']);
    $donor_id = $_SESSION['user_id'];

    // Double-check: Requester jeno donor na hoy
    $check_query = mysqli_query($conn, "SELECT user_id, is_thalassemia FROM requests WHERE id='$id' LIMIT 1");
    $req_data = $check_query ? mysqli_fetch_array($check_query) : null;

    if(!$req_data) {
        die("Request not found!");
    }

    if($req_data['user_id'] == $donor_id) {
        die("Action Denied: You cannot donate to your own request!");
    }

    // Update status to 'accepted' with donor details
    $query = "UPDATE requests SET donor_name='$name', donor_contact='$contact', status='accepted' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)) {
        if(isset($req_data['is_thalassemia']) && (int)$req_data['is_thalassemia'] === 1) {
            $alert_update = mysqli_query($conn, "SELECT id FROM thalassemia_alerts WHERE request_id='$id' AND donor_id='$donor_id' ORDER BY id DESC LIMIT 1");
            if($alert_update && mysqli_num_rows($alert_update) > 0) {
                $alert_row = mysqli_fetch_array($alert_update);
                $alert_id = (int)$alert_row['id'];
                mysqli_query($conn, "UPDATE thalassemia_alerts SET status='accepted' WHERE id='$alert_id'");
                mysqli_query($conn, "UPDATE thalassemia_alerts SET status='ignored' WHERE request_id='$id' AND donor_id <> '$donor_id' AND status='pending'");
            }
        }
        echo "<script>alert('Confirmation Sent! Admin will verify your info.'); window.location='search.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>