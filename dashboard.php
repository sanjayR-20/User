<?php
session_start();
include('functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);
if ($user) {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <h1>Welcome, <?php echo $user['username']; ?></h1>
        <img src="assets/images/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" class="profile-pic">
        <p>Email: <?php echo $user['email']; ?></p>
        <a href="logout.php">Logout</a>
    </body>
    </html>
<?php
} else {
    echo "User not found.";
}
?>
