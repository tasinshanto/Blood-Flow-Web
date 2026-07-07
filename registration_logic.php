<?php
session_start();
include('config.php');

if(isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_role = $_POST['role'];
    $donor_type = isset($_POST['donor_type']) ? $_POST['donor_type'] : 'regular';
    if($user_role !== 'donor') {
        $donor_type = 'regular';
    }
    $nid_number = mysqli_real_escape_string($conn, $_POST['nid_number']);
    $blood_group = $_POST['blood_group'];
    $password = $_POST['password'];

    // check if `donor_type` column exists in `users` table
    $has_donor_type = false;
    $col_check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'donor_type'");
    if($col_check && mysqli_num_rows($col_check) > 0) {
        $has_donor_type = true;
    }

    if($has_donor_type) {
        $query = "INSERT INTO users (fullname, email, role, donor_type, nid_number, blood_group, password) 
                  VALUES ('$name', '$email', '$user_role', '$donor_type', '$nid_number', '$blood_group', '$password')";
    } else {
        $query = "INSERT INTO users (fullname, email, role, nid_number, blood_group, password) 
                  VALUES ('$name', '$email', '$user_role', '$nid_number', '$blood_group', '$password')";
    }

    if(mysqli_query($conn, $query)) {
        // Auto-login bondho korar jonno nicher line-ta comment out ba delete koro:
        // $_SESSION['name'] = $name; 

        // Direct login na hoye login page-e pathiye dao
        header("Location: login.php?msg=Registration Successful! Please Login.");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>