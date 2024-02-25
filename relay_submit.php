<?php   
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="relaydatabse";
    $conn=mysqli_connect($servername,$username,$password,$dbname);
    if($conn){
        $cname = $_POST['captainName'];
        $cemail = $_POST['captainEmail'];
		$cphone = $_POST['captainPhone'];
        $cid=$_POST['captainID'];
		$branch = $_POST['branch'];
		$sem = $_POST['sem'];
		$p1n=$_POST['playerName1'];
        $p1id=$_POST['studentID1'];
        $p2n=$_POST['playerName2'];
        $p2id=$_POST['studentID2'];
        $p3n=$_POST['playerName3'];
        $p3id=$_POST['studentID3'];
		
        $stmt = $conn -> prepare("INSERT INTO relay(captain_name,captain_email,captain_phone,captain_id,branch,sem,p1,p1id,p2,p2id,p3,p3id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt -> bind_param("sssssissssss" ,$cname,$cemail,$cphone,$cid,$branch,$sem,$p1n,$p1id,$p2n,$p2id,$p3n,$p3id);
        $stmt -> execute();
        echo "Entries added";
        header('location:relay.html');
        $stmt -> close();
        $conn -> close();
    }else{
        echo "connection failed".mysqli_connect_error();
    }
?>