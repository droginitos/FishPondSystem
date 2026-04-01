<?php
session_start();
include('config.php'); // Your database connection

// 1. Fetch all available ponds from the database
$query = "SELECT * FROM ponds WHERE pond_status = 'available'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fish Pond Management System</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 1000px; margin: auto; }
        .pond-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .pond-card { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center; }
        .pond-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 5px; }
        .btn { display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .nav { margin-bottom: 30px; text-align: right; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <?php if(isset($_SESSION['user_id'])): ?>
            Welcome, <strong><?php echo $_SESSION['user_name']; ?></strong> | 
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> | <a href="register.php">Register</a>
        <?php endif; ?>
    </div>

    <h1>Available Fish Ponds</h1>
    <hr>

    <div class="pond-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="pond-card">
                <img src="images/<?php echo $row['pond_image']; ?>" alt="Pond Image">
                
                <h3><?php echo $row['pond_name']; ?></h3>
                <p>Location: <?php echo $row['pond_location']; ?></p>
                <p><strong>Price: KSh <?php echo number_format($row['price_per_day']); ?> / day</strong></p>
                
                <a href="booking.php?id=<?php echo $row['pond_id']; ?>" class="btn">Book Now</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>