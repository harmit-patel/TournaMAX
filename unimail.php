<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Matches</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    *{
        font-family:'Barlow',sans-serif;
        font-weight:500;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        height:100vh;
        background: linear-gradient(rgba(220, 247, 247,0.8),#088178);
    }
    table {
        border-collapse: collapse;
        width: 50%;
        margin: 0 auto;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        font-size: 22px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    h1 {
        text-align: center;
        margin-top: 50px;
    }
    </style>
</head>

<body>
    <h1>Match Pool</h1>
    <table>
        <tr>
            <th>Matche No.</th>
            <th>Participants</th>
        </tr>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the number of players
$num_players = $conn->query("SELECT COUNT(*) FROM chess")->fetch_row()[0];

// Generate unique random pairs of players
$pairs = [];
for ($i = 0; $i < floor($num_players / 2); $i++) {
    // Get a random player who has not been assigned to a pair yet
    do {
        $player1_id = rand(1, $num_players);
    } while (in_array($player1_id, array_column($pairs, 0)) || in_array($player1_id, array_column($pairs, 1)));

    // Get a random player who has not been assigned to a pair yet and is different from the first player
    do {
        $player2_id = rand(1, $num_players);
    } while (in_array($player2_id, array_column($pairs, 0)) || in_array($player2_id, array_column($pairs, 1)) || $player1_id == $player2_id);

    $pairs[] = [$player1_id, $player2_id];
}
foreach ($pairs as $pair_num => $pair) {
    $player1 = $conn->query("SELECT name FROM chess WHERE id=" . $pair[0])->fetch_assoc();
    $player2 = $conn->query("SELECT name FROM chess WHERE id=" . $pair[1])->fetch_assoc();
    echo "<tr><td>" . ($pair_num + 1) . "</td><td>" . $player1['name'] . " vs " . $player2['name'] . "</td></tr>";
}

// Send an email to each pair of players
foreach ($pairs as $pair) {
    $player1 = $conn->query("SELECT name, email FROM chess WHERE id=" . $pair[0])->fetch_assoc();
    $player2 = $conn->query("SELECT name, email FROM chess WHERE id=" . $pair[1])->fetch_assoc();

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'harmit2644@gmail.com'; // Replace with your email
        $mail->Password = 'rrdzpjyyfdnxezvq'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('harmit2644@gmail.com', 'Chess Tournament');
        $mail->addAddress($player1['email']);
        $mail->addAddress($player2['email']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Matches';
        $mail->Body = 'Hello ' . $player1['name'] . ' and ' . $player2['name'] . ', You have been randomly paired for the chess tournament. See you at the Sports Complex of DDU. Good Luck!';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}?>
</table>
</body>

</html>