<?php 
session_start(); 
include('config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Dashboard</title>
    <link rel="stylesheet" href="deshbord.css"> 
</head>
<body>

<?php 
// Case-sensitive check for navbar.php
if(file_exists('navbar.php')){
    include('navbar.php'); 
} else {
    echo "<div style='background: #ffcccc; color: #d8000c; padding: 10px; text-align: center; border: 1px solid #d8000c;'>
            <strong>Warning:</strong> navbar.php file ta 'blood_flow' folder-e khuje paoa jachhe na!
          </div>";
}
?>

<!-- Hero Section -->
<section class="hero">
    <h1>Welcome to <span>BloodFlow</span></h1>
    <div class="hero-box">
        <h2>Give Blood, Give Hope</h2>
        <p>A single donation can save multiple lives. Be the reason someone gets a second chance today.</p>
        <div class="hero-btns">
            <!-- Ekhon ekhane Join as Donor er jaygay Request Post option dile user-er jonno subidha -->
            <a href="request_form.php" class="btn-box-red">Post Blood Request</a>
            <a href="search.php" class="btn-box-green">Search Donors</a>
        </div>
    </div>
</section>

<!-- Verified Blood Requests Section -->
<section class="info-grid">
    <h2 class="section-title">Verified <span>Blood Requests</span></h2>
    <div class="cards-container">
        <?php 
        // Logic Update: Shudhu Admin-er approve kora request gulo show korbe
        $query = "SELECT * FROM requests WHERE status='approved' ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                                $request_tag = isset($row['is_thalassemia']) && $row['is_thalassemia'] == 1 ? "<span style='display:inline-block; margin-bottom:8px; background:#ffebee; color:#c62828; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:bold; border:1px solid #c62828;'>Thalassemia Request</span>" : "";
                echo "<div class='card'>
                                                $request_tag
                        <h3 style='color:#d32f2f;'>$row[blood_group] Required</h3>
                        <p><strong>Hospital:</strong> $row[hospital]</p>
                        <p><strong>Location:</strong> $row[location]</p>
                        <a href='search.php?blood_group=$row[blood_group]' class='btn-box-red' style='font-size:12px; padding:5px 10px;'>View Details</a>
                      </div>";
            }
        } else {
            echo "<p style='grid-column: 1 / -1; color: #777;'>No verified requests found at the moment.</p>";
        }
        ?>
    </div>
</section>

<!-- Info Section -->
<section class="info-grid" style="background: #fdfdfd;">
    <h2 class="section-title">Why Support Blood Donation?</h2>
    <div class="cards-container">
        <div class="card">
            <h3>Community Impact</h3>
            <p>Your contribution directly supports local hospitals and emergency medical needs.</p>
        </div>
        <div class="card">
            <h3>Donor Network</h3>
            <p>Join thousands of volunteers committed to making blood donation seamless.</p>
        </div>
        <div class="card">
            <h3>Quick Process</h3>
            <p>Our platform ensures a fast connection between donors and recipients.</p>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="visuals">
    <h2 class="map-title">Our Location</h2>
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9022699890664!2d90.4524458!3d23.7508734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087021c81%3A0x19690180a009fb52!2sUnited%20International%20University!5e0!3m2!1sen!2sbd!4v1714770000000!5m2!1sen!2sbd" 
            width="100%" 
            height="450" 
            style="border:0; border-radius: 15px;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</section>

<?php include('footer.php'); ?>

</body>
</html>