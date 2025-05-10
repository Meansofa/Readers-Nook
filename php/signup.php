<?php
require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";

$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$street = $_POST['street'] ?? '';
$city = $_POST['city'] ?? '';
$post_code = $_POST['post_code'] ?? '';
$date_of_birth = $_POST['date_of_birth'] ?? '';
$contact_no = $_POST['contact_no'] ?? '';
$role_id = $_POST['role_id'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statement to prevent SQL injection
$sql = "INSERT INTO user (first_name, middle_name, last_name, contact_no, email, street, city, post_code, role_id, date_of_birth, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $first_name, $middle_name, $last_name, $contact_no, $email, $street, $city, $post_code, $role_id, $date_of_birth, $hashed_password);

if ($stmt->execute()) {
    // Redirect to login or home page
    header("Location: ../index.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
