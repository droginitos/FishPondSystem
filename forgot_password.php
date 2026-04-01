<?php
include('config.php'); // Your DB connection ($conn)

if (isset($_POST['request_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    
    // Check if email exists
    $check = $conn->query("SELECT user_id FROM users WHERE user_email = '$email'");
    
    if ($check->num_rows > 0) {
        $user = $check->fetch_assoc();
        $user_id = $user['user_id'];
        
        // Generate a simple unique ID for the reset link
        $token = bin2hex(random_bytes(16)); 
        
        // Save token to DB (You might need to add a 'reset_token' column to your table)
        $conn->query("UPDATE users SET reset_token = '$token' WHERE user_id = '$user_id'");

        echo "<div style='background:#d4edda; padding:15px; border:1px solid #c3e6cb;'>
                <strong>Local Test Mode:</strong> Email found! <br>
                Click here to reset: <a href='reset_password.php?token=$token'>reset_password.php?token=$token</a>
              </div>";
    } else {
        echo "Email not found in our system.";
    }
}
?>

<form method="post">
    <h3>Forgot Password</h3>
    <input type="email" name="user_email" placeholder="Enter your registered email" required>
    <button type="submit" name="request_reset">Check Email</button>
</form>