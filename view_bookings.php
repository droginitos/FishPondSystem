<?php
session_start();
include 'config.php'; // Database connection

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// SQL to join bookings with ponds to show the name and 6-month price
$sql = "SELECT bookings.id AS b_id, ponds.id AS p_id, ponds.pond_name, ponds.location, ponds.price_6_months 
        FROM bookings 
        JOIN ponds ON bookings.pond_id = ponds.id 
        WHERE bookings.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings - Fish Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        .cancel-btn { color: red; text-decoration: none; font-weight: bold; }
        .cancel-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h1>Your Current Bookings</h1>
    <p><a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>

    <table>
        <tr>
            <th>Pond Name</th>
            <th>Location</th>
            <th>Price (6 Months)</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['pond_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                // Uses the price_6_months column name
                echo "<td>KES " . number_format($row['price_6_months'], 2) . "</td>";
                // Link to the cancel script with IDs
                echo "<td><a href='cancel_booking.php?booking_id=" . $row['b_id'] . "&pond_id=" . $row['p_id'] . "' 
                          class='cancel-btn' onclick='return confirm(\"Are you sure you want to cancel this booking?\")'>Cancel Booking</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>You haven't booked any ponds yet.</td></tr>";
        }
        ?>
    </table>

</body>
</html>