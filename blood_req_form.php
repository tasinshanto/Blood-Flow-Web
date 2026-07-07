<?php
session_start();
include('config.php');

// Only logged-in users can access form
if(!isset($_SESSION['user_id'])){
    header('Location: login.php'); exit();
}

$bank_id = isset($_GET['bank_id']) ? (int)$_GET['bank_id'] : 0;
$bank_name = '';
if($bank_id > 0){
    $bq = mysqli_query($conn, "SELECT bank_name FROM blood_banks WHERE id = $bank_id LIMIT 1");
    if($bq && mysqli_num_rows($bq) > 0){
        $brow = mysqli_fetch_assoc($bq);
        $bank_name = $brow['bank_name'];
    } else {
        die('Invalid blood bank selected.');
    }
} else {
    die('No blood bank selected.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Request Blood - <?php echo htmlspecialchars($bank_name); ?></title>
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
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Modern Form Card */
        .form-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-top: 6px solid #8b3a3a; /* Dark red matching dashboard accent */
        }

        .form-card h3 {
            font-size: 24px;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group-row {
            display: flex;
            gap: 20px;
        }

        .form-group-row .form-group {
            flex: 1;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #34495e;
            display: block;
            margin-bottom: 8px;
        }

        /* Clean inputs to match dashboard flat style */
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdde1;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            background-color: #fcfcfc;
            color: #2c3e50;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #8b3a3a;
            outline: none;
            background-color: #fff;
        }

        input[readonly] {
            background-color: #f1f2f6;
            color: #7f8c8d;
            cursor: not-allowed;
            border-color: #dcdde1;
        }

        textarea {
            resize: vertical;
        }

        /* Action Buttons Theme */
        .btn-actions {
            margin-top: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-submit {
            background: #8b3a3a; /* Dashboard Red */
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-submit:hover {
            background: #a64545;
        }

        .btn-cancel {
            background: #66bb6a; /* Dashboard Green from your layout */
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s ease;
        }

        .btn-cancel:hover {
            background: #55a659;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">
    <div class="form-card">
        <h3>🏢 Request Blood from <?php echo htmlspecialchars($bank_name); ?></h3>
        
        <form action="request_bank_logic.php" method="POST">
            <input type="hidden" name="bank_id" value="<?php echo $bank_id; ?>">
            
            <div class="form-group">
                <label>Target Blood Bank</label>
                <input type="text" value="<?php echo htmlspecialchars($bank_name); ?>" readonly>
            </div>
            
            <div class="form-group-row">
                <div class="form-group">
                    <label>Required Blood Group</label>
                    <select name="blood_group" required>
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
                
                <div class="form-group">
                    <label>Total Bags Needed</label>
                    <input type="number" name="bags_needed" min="1" max="5" value="1" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Reason / Notes Context</label>
                <textarea name="reason" rows="4" placeholder="Enter brief medical urgency or reason..." required></textarea>
            </div>
            
            <div class="btn-actions">
                <button type="submit" class="btn-submit">Submit Requisition</button>
                <a href="blood_banks_list.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>