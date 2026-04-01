<?php
$conn = mysqli_connect("localhost", "root", "", "pond_booking_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>