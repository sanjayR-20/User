<?php
// Connect to the database
function getDbConnection() {
    $servername = "localhost";
    $username = "root";  // Default username for XAMPP MySQL
    $password = "";      // Default password for XAMPP MySQL
    $dbname = "user_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Check if a user exists by email (for registration and login)
function userExistsByEmail($email) {
    $conn = getDbConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Register a new user
function registerUser($username, $email, $password, $profile_pic) {
    $conn = getDbConnection();

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, profile_pic) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $profile_pic);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Authenticate user during login
function authenticateUser($email, $password) {
    $conn = getDbConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user;  // Return the user data if authentication is successful
        }
    }
    return false;  // Return false if authentication fails
}

// Fetch user data by ID (for dashboard)
function getUserById($user_id) {
    $conn = getDbConnection();
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Return the user data
    }
    return null;  // Return null if no user is found
}
?>
