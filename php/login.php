<?php
require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Escape inputs to prevent SQL injection
$email = $conn->real_escape_string($email);

// Prepare & bind
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ✅ Secure hashed password check
   if (password_verify($password, $user['password'])) {
        header("Location: ../html/customercheckout.html");
        exit();
    } else {
        echo $user['password'];
        echo $password;
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ User or email not found.";
}

$conn->close();
?>
