<?php
session_start();
include('config.php');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: blood_banks_list.php'); exit();
}

if(!isset($_SESSION['user_id'])){
    header('Location: login.php'); exit();
}

$user_id = (int)$_SESSION['user_id'];
$bank_id = isset($_POST['bank_id']) ? (int)$_POST['bank_id'] : 0;
$blood_group = mysqli_real_escape_string($conn, $_POST['blood_group'] ?? '');
$bags_needed = isset($_POST['bags_needed']) ? (int)$_POST['bags_needed'] : 0;
$reason = mysqli_real_escape_string($conn, $_POST['reason'] ?? '');

// Basic validation
$allowed = ['A+','A-','B+','B-','O+','O-','AB+','AB-'];
if($bank_id <= 0 || $bags_needed < 1 || $bags_needed > 5 || !in_array($blood_group, $allowed)){
    echo "<script>alert('Invalid input.'); window.history.back();</script>"; exit();
}

// Ensure bank_requests table exists (create minimal schema if missing)
$check = mysqli_query($conn, "SHOW TABLES LIKE 'bank_requests'");
if(!$check || mysqli_num_rows($check) === 0){
    $create_sql = "CREATE TABLE IF NOT EXISTS bank_requests (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        bank_id INT NOT NULL,
        blood_group VARCHAR(5) NOT NULL,
        bags_needed INT NOT NULL,
        reason TEXT,
        status ENUM('pending','approved','rejected') DEFAULT 'pending',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $create_sql);
}

$sql = "INSERT INTO bank_requests (user_id, bank_id, blood_group, bags_needed, reason, status) VALUES ('$user_id', '$bank_id', '$blood_group', '$bags_needed', '$reason', 'pending')";
if(mysqli_query($conn, $sql)){
    echo "<script>alert('Request submitted successfully.'); window.location='deshbord.php';</script>";
    exit();
} else {
    $err = mysqli_error($conn);
    echo "<script>alert('Database error: " . addslashes($err) . "'); window.history.back();</script>";
    exit();
}

?>