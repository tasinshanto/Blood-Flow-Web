<?php
session_start();
include('config.php');

if(isset($_POST['post_request_btn'])) {
    // Current logged in user ID
    $user_id = $_SESSION['user_id'];
    
    // Sanitize and get form data
    $recipient_name = mysqli_real_escape_string($conn, $_POST['recipient_name']);
    $blood_group = $_POST['blood_group'];
    $hospital = mysqli_real_escape_string($conn, $_POST['hospital']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // STABLE THALASSEMIA CHECK: Form submit hole value check korbe
    $is_thalassemia = 0;
    if(isset($_POST['is_thalassemia']) && $_POST['is_thalassemia'] == '1') {
        $is_thalassemia = 1;
    }

    // SQL to insert data into requests table with is_thalassemia column
    $query = "INSERT INTO requests (user_id, recipient_name, blood_group, hospital, location, date, time, message, status, is_thalassemia) 
              VALUES ('$user_id', '$recipient_name', '$blood_group', '$hospital', '$location', '$date', '$time', '$message', 'pending', '$is_thalassemia')";

    if(mysqli_query($conn, $query)) {
        // Form post successful hole alert dekhabe ar dashboard-e pathabe
        echo "<script>alert('Blood Request Posted Successfully!'); window.location='deshbord.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Sora-sori url hit korle redirect hobe form page-e
    header("Location: request_form.php");
    exit();
}
?>