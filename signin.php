<?php
$servername = "localhost";
$username = "root";
$password = "redhat";
$dbname = "movieDB";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Start Session
session_start();

if(isset($_POST['submitbtn'])) {
 $sql1 = "select * from myusers where username='".$_POST['uname']."';";
 $result1 = mysqli_query($conn,$sql1);
 $row1 = mysqli_fetch_array($result1) ;

 //First Login
  if (hash('ripemd160', $_POST['psw'])==$row1['password'] && $_POST['psw']!=null) {  
     //save username
     $_SESSION['username']=$_POST['uname'];

    // enter unique no. to table
    $sup="update myusers set uniqueID=".$_SESSION['rand']." where username='".$_POST['uname']."';";
    if ($conn->query($sup) === FALSE) {  echo "<br>shocking: ".$sup."<br>";   }
    

    //redirect to account
    header("Location: account.php");
    
  }
}
?>
