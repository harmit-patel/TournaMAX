<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temp";

$conn = new mysqli($servername, $username, $password, $dbname);
// include 'chess.php';
$pdoObject = new PDO("mysql:host=localhost;dbname=temp;charset=utf8", "root", "");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// delete records with empty status
$sql = "DELETE FROM chess WHERE status = ''";
if ($conn->query($sql ) === TRUE) {
  echo "Records deleted successfully.";
} else {
  echo "Error deleting records: " . $conn->error;
}

$sql = "SELECT COUNT(id) FROM chess";
$count = $pdoObject->query($sql)->fetchColumn();

if ($count == 1) {
    echo "We have a winner!";
}
else{
// delete records with empty status
$sql1 = "ALTER TABLE chess DROP COLUMN id";
if ($conn->query($sql1) === TRUE) {
  echo "Records deleted successfully.";
} else {
  echo "Error deleting records: ";
  $conn->error;
}
$sql = "UPDATE chess set status='' where status='winner' ";
$sql1 = "ALTER TABLE chess ADD id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
if (($conn->query($sql)) && ($conn->query($sql1)) == true) {
  echo "Records deleted successfully.";
} else {
  echo "Error deleting records: " . $conn->error;
}
}
// close connection
header('Location: ad_access.html');
$conn->close();
?>