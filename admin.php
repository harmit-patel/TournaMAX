<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['pwd'];

$sql = "SELECT * FROM admint WHERE email=? and pasword=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Redirect to the admin dashboard page
  header('Location: ad_access.html');
} else {
  echo "Invalid email or password";
}
$stmt->close();
$conn->close();
?>