<?php
session_start();
include('config.php');

if(isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Database check: role and donor_type fetch kora must
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_array($result);

        // Session settings (use actual DB column names)
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['name'] = isset($user_data['fullname']) ? $user_data['fullname'] : '';
        $_SESSION['user_name'] = isset($user_data['fullname']) ? $user_data['fullname'] : '';
        $_SESSION['user_role'] = isset($user_data['role']) ? $user_data['role'] : 'user';
        $_SESSION['donor_type'] = isset($user_data['donor_type']) ? $user_data['donor_type'] : 'regular';

        // Role-wise redirection logic
        if($_SESSION['user_role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: deshbord.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password!'); window.location='login.php';</script>";
    }
}
?>