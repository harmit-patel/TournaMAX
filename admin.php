<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$conn = new mysqli($servername, $username, $password, $dbname);
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
  header('Location: access.html');
} else {
  echo "Invalid email or password";
}
$stmt->close();
$conn->close();
?>
