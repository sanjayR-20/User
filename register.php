<?php
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Handle file upload for profile picture (optional)
    $profile_pic = 'default.jpg';  // Default profile picture
    if ($_FILES['profile_pic']['error'] == 0) {
        $profile_pic = $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'assets/images/' . $profile_pic);
    }

    // Check if user already exists
    if (userExistsByEmail($email)) {
        echo "User with this email already exists!";
    } else {
        if (registerUser($username, $email, $password, $profile_pic)) {
            echo "Registration successful! <a href='login.php'>Login</a>";
        } else {
            echo "Error in registration.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <form method="POST" action="register.php" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="file" name="profile_pic" accept="image/*"><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
