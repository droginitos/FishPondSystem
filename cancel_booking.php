<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

if (isset($_GET['booking_id']) && isset($_GET['pond_id'])) {
    $booking_id = $_GET['booking_id'];
    $pond_id = $_GET['pond_id'];
    $user_id = $_SESSION['user_id'];

    // 1. Delete the booking record
    $delete_sql = "DELETE FROM bookings WHERE id = '$booking_id' AND user_id = '$user_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        // 2. Set the pond back to 'Available'
        mysqli_query($conn, "UPDATE ponds SET status = 'Available' WHERE id = '$pond_id'");
        
        echo "<h1>Booking Cancelled Successfully</h1>";
        echo "<a href='dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>