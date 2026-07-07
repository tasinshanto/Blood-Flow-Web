<?php
session_start();
include('config.php');

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'donor') {
    die('Unauthorized Access! Only donors can process thalassemia alerts.');
}

if(!isset($_GET['action']) || !isset($_GET['alert_id'])) {
    header("Location: thalassemia_alerts.php");
    exit();
}

$action = $_GET['action'];
$alert_id = mysqli_real_escape_string($conn, $_GET['alert_id']);
$donor_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

$alert_query = "SELECT ta.id AS alert_id, ta.request_id, ta.status AS alert_status, r.blood_group, r.is_thalassemia, r.status AS request_status, r.user_id AS requester_id
                FROM thalassemia_alerts ta
                JOIN requests r ON ta.request_id = r.id
                WHERE ta.id='$alert_id' AND ta.donor_id='$donor_id'
                LIMIT 1";
$alert_result = mysqli_query($conn, $alert_query);

if(!$alert_result || mysqli_num_rows($alert_result) === 0) {
    die('Alert not found or access denied.');
}

$alert_data = mysqli_fetch_array($alert_result);
$request_id = (int)$alert_data['request_id'];
$current_status = $alert_data['alert_status'];

if($action === 'ignore') {
    if($current_status === 'pending') {
        mysqli_query($conn, "UPDATE thalassemia_alerts SET status='ignored' WHERE id='$alert_id'");
    }
    header('Location: thalassemia_alerts.php?alert=ignored');
    exit();
}

if($action === 'accept') {
    if((int)$alert_data['is_thalassemia'] !== 1) {
        die('This alert does not belong to a Thalassemia request.');
    }

    if($alert_data['request_status'] !== 'approved') {
        die('This request is no longer available for donor commitment.');
    }

    if($current_status !== 'pending') {
        header('Location: thalassemia_alerts.php?alert=already-processed');
        exit();
    }

    $user_lookup = mysqli_query($conn, "SELECT fullname, email FROM users WHERE id='$donor_id' LIMIT 1");
    $user_data = $user_lookup ? mysqli_fetch_array($user_lookup) : null;

    $donor_name = $user_data && isset($user_data['fullname']) ? mysqli_real_escape_string($conn, $user_data['fullname']) : mysqli_real_escape_string($conn, $_SESSION['name'] ?? ($_SESSION['user_name'] ?? 'Fixed Donor'));
    $donor_contact = $user_data && isset($user_data['email']) ? mysqli_real_escape_string($conn, $user_data['email']) : $donor_name;

    $update_request = "UPDATE requests SET donor_name='$donor_name', donor_contact='$donor_contact', status='accepted' WHERE id='$request_id'";
    if(mysqli_query($conn, $update_request)) {
        mysqli_query($conn, "UPDATE thalassemia_alerts SET status='accepted' WHERE id='$alert_id'");
        mysqli_query($conn, "UPDATE thalassemia_alerts SET status='ignored' WHERE request_id='$request_id' AND id <> '$alert_id' AND status='pending'");
        header('Location: thalassemia_alerts.php?alert=accepted');
        exit();
    }

    die('Unable to commit the donor acceptance.');
}

header('Location: thalassemia_alerts.php');
exit();
?>