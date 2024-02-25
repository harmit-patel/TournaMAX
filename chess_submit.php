<?php   
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="temp";
    $conn=mysqli_connect($servername,$username,$password,$dbname);
    if($conn){
        $name = $_POST['name'];
        $id = $_POST['id'];
		$phone = $_POST['phone'];
		$branch = $_POST['branch'];
		$sem = $_POST['sem'];
		$email = $_POST['email'];
		
        $stmt = $conn -> prepare("INSERT INTO chess(name,sid,pno,branch,sem,email) VALUES (?,?,?,?,?,?)");
        $stmt -> bind_param("ssisis" ,$name,$id,$phone,$branch,$sem,$email);
        $stmt -> execute();
        echo "Entries added";
        header('location:chess_entry.html');
        $stmt -> close();
        $conn -> close();

    }else{
        echo "connection failed".mysqli_connect_error();
    }
?>