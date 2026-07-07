<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>BloodFlow - Blogs</title>
    <link rel="stylesheet" href="deshbord.css">
</head>
<body>
<?php include('navbar.php'); ?>

<div class="blog-section" style="padding: 50px; text-align: center;">
    <h2>All <span>Blogs</span></h2>
    <div class="cards-container">
        <?php 
        $query = "SELECT * FROM blogs ORDER BY id DESC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result)) {
        ?>
        <div class="card">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo substr($row['content'], 0, 100); ?>...</p>
            <a href="#" style="color: #d32f2f;">Read Full Blog →</a>
        </div>
        <?php } ?>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>