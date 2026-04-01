<?php
include 'config.php'; 
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // This line matches the table we just created
    $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Fish Rental System</title>
</head>
<body style="text-align:center; padding-top:50px; font-family:Arial, sans-serif;">

    <h1>Welcome to Fish Rental System</h1>
    
    <div style="border:1px solid #ccc; display:inline-block; padding:30px; border-radius:15px; background-color:#f9f9f9;">
        <h2>User Registration</h2>
        <p style="color:blue;"><?php echo $message; ?></p>
        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required style="padding:10px; margin:10px; width:200px;"><br>
            <input type="password" name="password" placeholder="Password" required style="padding:10px; margin:10px; width:200px;"><br>
            <button type="submit" style="padding:10px 20px; background-color:green; color:white; border:none; border-radius:5px; cursor:pointer;">Register Now</button>
        </form>
    </div>
</body>
</html>