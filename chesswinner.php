<?php
// connect to the database
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

// fetch the winner from the chess table
$winners_per_page = 20; // number of winners to display per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // current page number
$offset = ($page - 1) * $winners_per_page; // calculate the offset

$sql = "SELECT name, sem FROM chess WHERE status = 'winner' LIMIT $winners_per_page OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        *{
            font-family:'Barlow',sans-serif;
            font-weight:500;
            box-sizing: border-box;
            padding: 0;
        }
        body{
            height:100vh;
            background: linear-gradient(rgba(220, 247, 247,0.8),#088178);
        }
        .rounds{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .rounds h2{
            margin-bottom: 20px;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
        }
        th, td{
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 22px;
        }
        th{
            
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="rounds">
        <h2>Roundwise Winners</h2>
        <table>
            <tr><th>Name</th><th>Semester</th></tr>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>" ;
                    echo "<td>" . $row["name"] . "</td>" ;
                    echo "<td>" . $row["sem"] . "</td>" ;
                    echo "</tr>" ;
                }
            } else {
                echo "<tr><td colspan='2'>No winners yet.</td></tr>" ;
            }
            ?>
        </table>
    </div>
    <?php
    // display pagination links
    $sql = "SELECT COUNT(*) as total FROM chess WHERE status = 'winner'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_winners = $row['total'];
    $total_pages = ceil($total_winners / $winners_per_page);

    // close connection
    $conn->close();
    ?>
</body>
</html>