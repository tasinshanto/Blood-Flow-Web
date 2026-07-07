<?php 
session_start(); 
include('config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Blood Requests - BloodFlow</title>
    <link rel="stylesheet" href="search.css"> 
</head>
<body>

<?php include('navbar.php'); ?>

<div class="search-page-wrapper">
    <div class="search-header-section">
        <h1>Pending <span class="highlight">Donation Requests</span></h1>
        <p>Heroism is in your blood. Browse the requests below and help someone in their critical time.</p>
        <div class="header-line"></div>
    </div>

    <div class="search-filter-box">
        <form action="" method="GET">
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
            <button type="submit" class="search-btn">Search Now</button>
        </form>
    </div>

    <div class="request-grid">
        <?php 
        $query_condition = "WHERE status='approved'";

        if(isset($_GET['blood_group']) && !empty($_GET['blood_group'])) {
            $blood = mysqli_real_escape_string($conn, $_GET['blood_group']);
            $query_condition .= " AND blood_group='$blood'";
        }

        $final_query = "SELECT * FROM requests $query_condition ORDER BY id DESC";
        $result = mysqli_query($conn, $final_query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) { 
        ?>
                <div class="request-card">
                    <div class="card-top">
                        <span class="blood-tag"><?php echo $row['blood_group']; ?></span>
                        <span class="date-tag"><?php echo $row['date']; ?></span>
                    </div>
                    
                    <div class="card-body">
                        <h3>Recipient: <?php echo $row['recipient_name']; ?></h3>
                        
                        <?php if(isset($row['is_thalassemia']) && $row['is_thalassemia'] == 1): ?>
                            <div style="margin: 8px 0;">
                                <span class="thalassemia-badge" style="background: #ffebee; color: #c62828; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; border: 1px solid #c62828; display: inline-block;">
                                    🔴 Thalassemia Case
                                </span>
                            </div>
                        <?php endif; ?>

                        <p>📍 <?php echo $row['location']; ?></p>
                        <p>⏰ <?php echo $row['time']; ?></p>
                    </div>

                    <div class="card-footer">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="request_details.php?id=<?php echo $row['id']; ?>" class="view-details-btn">View Details</a>
                        <?php // Corrected spelling error token for syntax output safety
                        else: ?>
                            <a href="login.php" class="view-details-btn" onclick="alert('Please login first to see the details!')">View Details</a>
                        <?php endif; ?>
                    </div>
                </div>
        <?php 
            }
        } else {
            echo "<p class='no-data' style='grid-column: 1 / -1;'>No verified blood requests found for this category.</p>";
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>