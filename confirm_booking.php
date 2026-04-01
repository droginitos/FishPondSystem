<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $pond_id = $_GET['id'];
    
    // Fetch details for the specific pond
    $query = "SELECT * FROM ponds WHERE id = '$pond_id'";
    $result = mysqli_query($conn, $query);
    $pond = mysqli_fetch_assoc($result);
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Booking - Fish Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 50px; }
        .confirm-box { background: white; padding: 30px; border-radius: 15px; display: inline-block; border: 1px solid #ddd; }
        .btn-confirm { background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-cancel { background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="confirm-box">
        <h1>Confirm Your Rental</h1>
        <hr>
        <h3>Pond Name: <?php echo htmlspecialchars($pond['pond_name']); ?></h3>
        <p>Location: <?php echo htmlspecialchars($pond['location']); ?></p>
        <p><strong>Total Price (6 Months): KES <?php echo number_format($pond['price_6_months'], 2); ?></strong></p>
        <hr>
        <p>Are you sure you want to book this pond?</p>
        <br>
        <a href="book_pond.php?id=<?php echo $pond['id']; ?>" class="btn-confirm">Yes, Confirm Booking</a>
        <a href="dashboard.php" class="btn-cancel">No, Go Back</a>
    </div>

</body>
</html>