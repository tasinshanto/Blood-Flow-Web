<?php
session_start();
include('config.php');

// Check table
$check = mysqli_query($conn, "SHOW TABLES LIKE 'blood_banks'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blood Banks List</title>
    <style>
        /* --- Dashboard Layout Fix Integration --- */
        body {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            background-color: #fce4e4;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 25px;
            font-weight: bold;
        }

        /* Bank Card Styling matching your dashboard grid theme */
        .bank-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-left: 6px solid #8b3a3a; /* Dark red identity accent */
            transition: transform 0.2s ease;
        }

        .bank-card:hover {
            transform: translateY(-2px);
        }

        .bank-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .bank-info strong {
            font-size: 20px;
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        .bank-info .location {
            color: #7f8c8d;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .bank-actions {
            text-align: right;
        }

        .contact-no {
            font-size: 14px;
            color: #34495e;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Matching Buttons with your Dashboard UI */
        .btn-request {
            background: #8b3a3a; /* Your dashboard red button */
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-request:hover {
            background: #a64545;
        }

        /* Inventory Stock Badges Area */
        .inventory-box {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f5ebeb;
        }

        .inventory-title {
            font-size: 13px;
            text-transform: uppercase;
            color: #7f8c8d;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .stock-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .stock-badge {
            background: #94b2cd; /* Your dashboard card blue color */
            color: #2c3e50;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .no-data {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            color: #7f8c8d;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">
    <div class="page-title">Available Blood Banks</div>

<?php if(!$check || mysqli_num_rows($check) === 0): ?>
    <div class="no-data">Blood bank inventory module is currently not available.</div>
<?php else:
    $res = mysqli_query($conn, "SELECT * FROM blood_banks ORDER BY id DESC");
    if($res && mysqli_num_rows($res) > 0):
        while($row = mysqli_fetch_assoc($res)):
            $id = (int)$row['id'];
?>
    <div class="bank-card">
        <div class="bank-head">
            <div class="bank-info">
                <strong>🏢 <?php echo htmlspecialchars($row['bank_name']); ?></strong>
                <div class="location">📍 <?php echo htmlspecialchars($row['location']); ?></div>
            </div>
            <div class="bank-actions">
                <div class="contact-no">📞 <?php echo htmlspecialchars($row['contact_no']); ?></div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="blood_req_form.php?bank_id=<?php echo $id; ?>" class="btn-request">Request Blood</a>
                <?php else: ?>
                    <a href="login.php" class="btn-request">Request Blood</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="inventory-box">
            <span class="inventory-title">Available Blood Stocks</span>
            <div class="stock-grid">
                <span class="stock-badge">A+ : <?php echo (int)$row['stock_a_positive']; ?></span>
                <span class="stock-badge">A- : <?php echo (int)$row['stock_a_negative']; ?></span>
                <span class="stock-badge">B+ : <?php echo (int)$row['stock_b_positive']; ?></span>
                <span class="stock-badge">B- : <?php echo (int)$row['stock_b_negative']; ?></span>
                <span class="stock-badge">O+ : <?php echo (int)$row['stock_o_positive']; ?></span>
                <span class="stock-badge">O- : <?php echo (int)$row['stock_o_negative']; ?></span>
                <span class="stock-badge">AB+ : <?php echo (int)$row['stock_ab_positive']; ?></span>
                <span class="stock-badge">AB- : <?php echo (int)$row['stock_ab_negative']; ?></span>
            </div>
        </div>
    </div>
<?php
        endwhile;
    else:
        echo '<div class="no-data">No blood banks registered yet inside the system.</div>';
    endif;
endif;
?>
</div>

<?php include('footer.php'); ?>

</body>
</html>