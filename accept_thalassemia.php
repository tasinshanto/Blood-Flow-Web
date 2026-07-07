<?php
session_start();
include('config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'donor') {
    header('Location: login.php');
    exit();
}

$alert_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($alert_id <= 0) {
    header('Location: user_my_req.php');
    exit();
}

$sql = "UPDATE thalassemia_alerts SET status = 'accepted' WHERE id = $alert_id";
if(mysqli_query($conn, $sql)) {
    echo "<script>alert('You have successfully accepted this Thalassemia request!'); window.location='user_my_req.php';</script>";
    exit();
} else {
    echo "<script>alert('Unable to accept the request right now.'); window.location='user_my_req.php';</script>";
    exit();
}
?>