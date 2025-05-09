<?php
require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statement to prevent SQL injection
$sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    // Redirect to login or home page
    header("Location: ../index.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
