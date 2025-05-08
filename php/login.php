<?php
require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$username = $_POST['username'] ?? 'russel';
$password = $_POST['password'] ?? 'gwapa';

// Escape input to prevent SQL injection
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

// Prepare & bind to prevent SQL injection
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ⚠️ Plaintext password check (only use if you are not hashing yet)
    if ($password === $user['password']) {
        // ✅ Redirect on successful login
        header("Location: ../html/customercheckout.html");
        exit();
    } else {
        echo "Invalid password.";
    }


} else {
    echo "User not found.";
}

$conn->close();
?>
