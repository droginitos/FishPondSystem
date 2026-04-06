<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Search for the user in the database
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Verify password against the hashed password in DB
    if ($row && password_verify($pass, $row['password'])) {
        // Store user info in the session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // --- ADMIN RECOGNITION LOGIC ---
        
        if ($row['username'] === 'AdminName') {
            // Send you to the management panel
            header("Location: admin.php");
        } else {
            // Send normal customers to the pond list
            header("Location: dashboard.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid username or password.'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Fish Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding-top: 100px; }
        .login-box { background: white; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { display: block; width: 250px; padding: 10px; margin: 10px auto; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>
