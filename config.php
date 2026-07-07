<?php
// Database credentials
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "blood_flow";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>