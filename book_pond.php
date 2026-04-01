<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

if (isset($_GET['id'])) {
    $pond_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // 1. First, get the username of the person logged in
    $user_query = mysqli_query($conn, "SELECT username FROM users WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($user_query);
    $c_name = $user_data['username'];

    // 2. Insert into bookings including the NEW customer_name column
    $sql = "INSERT INTO bookings (user_id, customer_name, pond_id) VALUES ('$user_id', '$c_name', '$pond_id')";

    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, "UPDATE ponds SET status = 'Booked' WHERE id = '$pond_id'");
        echo "<h1>Booking Successful, " . htmlspecialchars($c_name) . "!</h1>";
        echo "<a href='dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>