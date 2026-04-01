<?php
include('config.php');

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // Verify the token exists
    $result = $conn->query("SELECT user_id FROM users WHERE reset_token = '$token'");
    
    if ($result->num_rows > 0) {
        if (isset($_POST['update_pass'])) {
            $new_pass = $_POST['new_pass'];
            $confirm_pass = $_POST['confirm_pass'];

            if ($new_pass === $confirm_pass) {
                // Hash the new password properly
                $hashed_password = password_hash($new_pass, PASSWORD_BCRYPT);
                
                // Update password and CLEAR the token so it can't be used again
                $update = $conn->query("UPDATE users SET user_password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'");
                
                if ($update) {
                    echo "Success! Password updated. <a href='login.php'>Login here</a>";
                    exit;
                }
            } else {
                echo "Passwords do not match!";
            }
        }
?>
        <form method="post">
            <h3>Create New Password</h3>
            <input type="password" name="new_pass" placeholder="New Password" required>
            <input type="password" name="confirm_pass" placeholder="Confirm Password" required>
            <button type="submit" name="update_pass">Update Password</button>
        </form>
<?php
    } else {
        echo "Invalid or expired token.";
    }
} else {
    header("Location: login.php");
}
?>