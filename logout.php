<?php
session_start();
session_destroy(); // Safely clears  any user's session
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logged Out - Fish Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding-top: 100px; background-color: #f4f4f4; }
        .logout-box { background: white; padding: 40px; border-radius: 15px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .login-btn { background-color: #007bff; color: white; }
        .register-btn { background-color: #28a745; color: white; }
    </style>
</head>
<body>

    <div class="logout-box">
        <h1>You have been logged out.</h1>
        <p>Thank you for using the Fish Rental System!</p>
        <hr>
        <p>What would you like to do next?</p>
        
        <a href="register.php" class="btn register-btn">Register New Account</a>
        <br>
        <a href="login.php" class="btn login-btn">Login Again</a>
    </div>

</body>
</html>
