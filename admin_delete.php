<?php
session_start();
include 'config.php';

// Security Check: Only admin can trigger a delete
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'AdminName') {
    die("Unauthorized action.");
}

if (isset($_GET['booking_id']) && isset($_GET['pond_id'])) {
    $booking_id = $_GET['booking_id'];
    $pond_id = $_GET['pond_id'];

    // 1. Delete the booking
    $delete_query = "DELETE FROM bookings WHERE id = '$booking_id'";
    
    if (mysqli_query($conn, $delete_query)) {
        // 2. Make the pond available again
        mysqli_query($conn, "UPDATE ponds SET status = 'Available' WHERE id = '$pond_id'");
        
        header("Location: admin.php?msg=BookingRemoved");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>