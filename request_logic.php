<?php
session_start();
include('config.php');

if(!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: request_form.php');
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
$recipient_name = mysqli_real_escape_string($conn, $_POST['recipient_name'] ?? '');
$blood_group = mysqli_real_escape_string($conn, $_POST['blood_group'] ?? '');
$hospital = mysqli_real_escape_string($conn, $_POST['hospital'] ?? '');
$location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
$date = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
$time = mysqli_real_escape_string($conn, $_POST['time'] ?? '');
$message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');
$is_thalassemia = isset($_POST['is_thalassemia']) ? (int) $_POST['is_thalassemia'] : 0;

$sql = "INSERT INTO requests (user_id, recipient_name, blood_group, location, hospital, date, time, message, status, is_thalassemia) VALUES ('$user_id', '$recipient_name', '$blood_group', '$location', '$hospital', '$date', '$time', '$message', 'pending', '$is_thalassemia')";

if(mysqli_query($conn, $sql)) {
    $new_req_id = mysqli_insert_id($conn);

    if($is_thalassemia === 1) {
        $bg = mysqli_real_escape_string($conn, $blood_group);
        $dq = "SELECT id FROM users WHERE role='donor' AND blood_group='$bg'";
        $dr = mysqli_query($conn, $dq);
        if($dr) {
            while($d = mysqli_fetch_array($dr)) {
                $donor_id = (int) $d['id'];
                $iq = "INSERT INTO thalassemia_alerts (request_id, donor_id, status) VALUES ('$new_req_id', '$donor_id', 'pending')";
                mysqli_query($conn, $iq);
            }
        }
    }

    echo "<script>alert('Request posted successfully.'); window.location='deshbord.php';</script>";
    exit();
} else {
    $err = mysqli_error($conn);
    echo "<script>alert('Error: " . addslashes($err) . "'); window.location='request_form.php';</script>";
    exit();
}

?>