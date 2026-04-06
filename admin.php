<?php
session_start();
include 'config.php';

// 1. SECURITY CHECK
// This prevents regular customers from typing 'admin.php' to see THE data.

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'AdminName') {
    header("Location: login.php");
    exit();
}

// 2. FETCH ALL BOOKINGS

$sql = "SELECT bookings.id AS b_id, 
               bookings.customer_name, 
               ponds.id AS p_id, 
               ponds.pond_name, 
               ponds.location, 
               ponds.price_6_months, 
               bookings.booking_date 
        FROM bookings 
        LEFT JOIN ponds ON bookings.pond_id = ponds.id 
        ORDER BY bookings.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Fish Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .admin-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 1000px; margin: auto; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-delete { background-color: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-delete:hover { background-color: #a71d2a; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

    <div class="admin-container">
        <div class="nav-links">
            <a href="dashboard.php">← Back to Site</a>
            <a href="logout.php" style="color: #dc3545;">Logout</a>
        </div>

        <h1>Admin Management: All Bookings</h1>
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>. Here is the current rental status:</p>

        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Pond Name</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pond_name'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['location'] ?? 'N/A') . "</td>";
                        echo "<td>KES " . number_format($row['price_6_months'] ?? 0, 2) . "</td>";
                        echo "<td>" . $row['booking_date'] . "</td>";
                        // The delete button passes the Booking ID and the Pond ID to reset status
                        echo "<td>
                                <a href='admin_delete.php?booking_id=" . $row['b_id'] . "&pond_id=" . $row['p_id'] . "' 
                                   class='btn-delete' 
                                   onclick='return confirm(\"Are you sure you want to delete this booking and make the pond available again?\")'>
                                   Remove
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No active bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
