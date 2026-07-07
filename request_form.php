<?php 
include('config.php'); 
session_start(); 

// Check koro user login kora ache kina
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Login na thakle login page-e pathiye dibe
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Blood Request - BloodFlow</title>
    <link rel="stylesheet" href="request_form.css"> </head>
<body>

<?php include('navbar.php'); ?>

<div class="form-wrapper">
    <div class="request-box">
        <div class="request-header">
            <h1>Post Blood Request</h1>
            <p>Fill out the details to find a donor</p>
        </div>

        <div class="request-body">
            <form action="request_logic.php" method="POST">
                
                <div class="field-group">
                    <label>Recipient Name</label>
                    <input type="text" name="recipient_name" placeholder="Who needs the blood?" required>
                </div>

                <div class="field-group">
                    <label>Blood Group Required</label>
                    <select name="blood_group" required>
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>

                <div class="field-group">
                    <label>Hospital Name</label>
                    <input type="text" name="hospital" placeholder="Name of the hospital" required>
                </div>

                <div class="field-group">
                    <label>Location (District/Area)</label>
                    <input type="text" name="location" placeholder="e.g. Dhaka, Dhanmondi" required>
                </div>

                <div class="field-group" style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label>Date Needed</label>
                        <input type="date" name="date" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Time</label>
                        <input type="time" name="time" required>
                    </div>
                </div>

                <div class="field-group">
                    <label>Message/Notes</label>
                    <textarea name="message" rows="3" placeholder="Any additional info..."></textarea>
                </div>

                <div class="field-group" style="display:flex; gap:10px; align-items:center; margin-top:15px; margin-bottom:20px;">
                    <label style="min-width:200px; font-weight:600; color:#d32f2f;">Patient Classification Profile Type</label>
                    <select name="is_thalassemia" required style="padding:8px 10px; border-radius:6px; border:1px solid #ddd;">
                        <option value="0">Regular Patient</option>
                        <option value="1">Thalassemia Patient</option>
                    </select>
                </div>

                <button type="submit" name="post_request_btn" class="post-btn">Post Request Now</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>