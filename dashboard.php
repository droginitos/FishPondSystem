<?php
session_start();
include 'config.php';

// 1. Security: Redirect to login if user session is not active
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Handle Search Input
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// 3. Fetch Ponds: Filtered by search and sorted A-Z
$query = "SELECT * FROM ponds WHERE 
          (location LIKE '%$search%' OR pond_name LIKE '%$search%') 
          ORDER BY pond_name ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fish Pond Rental System</title>
    <style>
        /* --- CSS STYLING --- */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f7f6; 
            margin: 0; 
            padding: 0; 
        }

        .navbar { 
            background: linear-gradient(135deg, #1e3c72, #2a5298); 
            color: white; 
            padding: 15px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .navbar a { color: white; text-decoration: none; font-weight: bold; padding: 10px 15px; transition: 0.3s; }
        .navbar a:hover { background: rgba(255,255,255,0.2); border-radius: 8px; }

        .search-box { 
            padding: 10px 15px; 
            border-radius: 20px; 
            border: none; 
            width: 250px; 
            outline: none;
        }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; text-align: center; }

        /* Grid Layout for side-by-side cards */
        .pond-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        /* The Pond Card Template Styling */
        .pond-card { 
            background: white; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 6px 15px rgba(0,0,0,0.05); 
            transition: all 0.3s ease;
            text-align: left;
            border: 1px solid #eee;
        }

        .pond-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 12px 24px rgba(0,0,0,0.15); 
        }

        .pond-image { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            background-color: #ddd;
        }

        .pond-info { padding: 20px; }
        .pond-info h2 { margin: 0; font-size: 1.4em; color: #2c3e50; text-transform: capitalize; }
        .pond-info p { color: #7f8c8d; margin: 8px 0; font-size: 0.95em; }
        
        .price-tag { 
            display: block;
            color: #28a745; 
            font-size: 1.3em; 
            font-weight: 800; 
            margin: 15px 0; 
        }

        .book-btn { 
            display: block;
            background-color: #007bff; 
            color: white; 
            padding: 12px; 
            text-decoration: none; 
            border-radius: 8px; 
            text-align: center; 
            font-weight: bold; 
            transition: 0.3s;
        }
        .book-btn:hover { background-color: #0056b3; }

        .admin-banner { background-color: #ffc107; padding: 10px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'AdminName'): ?>
        <div class="admin-banner">
            ⭐ ADMIN MODE: <a href="admin.php">Management Panel</a>
        </div>
    <?php endif; ?>

    <div class="navbar">
        <div style="font-size: 1.5em; font-weight: bold;">FishRental</div>
        <form method="GET" action="dashboard.php">
            <input type="text" name="search" class="search-box" placeholder="Search location..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" style="padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-weight: bold;">Search</button>
        </form>
        <div>
            <a href="dashboard.php">Home</a>
            <a href="view_bookings.php">My Bookings</a>
            <a href="logout.php" style="color: #ff6b6b;">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Available Fish Ponds</h1>
        
        <div class="pond-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    // Identify the image from the folder
                    $imageFile = !empty($row['pond_image']) ? $row['pond_image'] : "default_pond.jpg";
                    
                    /* --- THE POND CARD TEMPLATE --- */
                    echo "<div class='pond-card'>";
                        echo "<img src='images/" . htmlspecialchars($imageFile) . "' class='pond-image' alt='Pond View'>";
                        echo "<div class='pond-info'>";
                            echo "<h2>" . htmlspecialchars($row['pond_name']) . "</h2>";
                            echo "<p>📍 Location: " . htmlspecialchars($row['location']) . "</p>";
                            echo "<span class='price-tag'>KES " . number_format($row['price_6_months'], 2) . "</span>";
                            
                            // Link to booking page using the ID
                            echo "<a href='confirm_booking.php?id=" . $row['id'] . "' class='book-btn'>Book Now</a>";
                        echo "</div>";
                    echo "</div>";
                    /* --- END OF TEMPLATE --- */
                    
                }
            } else {
                echo "<p style='grid-column: 1/-1;'>No ponds found matching your search.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>