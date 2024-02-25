<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$captain_name = $_POST['name'];
$unique_id=$_POST['sid'];

// Retrieve captain information
$sql = "SELECT * FROM chess WHERE name=? and sid=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $captain_name,$unique_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $captain_id = $result->fetch_assoc()['id'];

  // Update captain status in database
  $sql = "UPDATE chess SET status='winner' WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $captain_id);
  $stmt->execute();

  // Redirect back to the form
  header('Location: ad_access.html');

} else {
  echo "Captain not found";
}

$stmt->close();
$conn->close();
?>