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

//check if username exists
$sqlget="select count(*) from myusers where name='".$_POST['Nuname']."';";
$result = mysqli_query($conn, $sqlget);
$row =mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($conn->query($sqlget) == FALSE) 
  {  echo "<br>shocking: ".$sqlget."<br>";   }

if ($row['count(*)']==0)
{
  //check if password and confirm password fields match
  if($_POST['Npsw1']==$_POST['Npsw2']) 
  {
   // insert user to myUsers table
    $sql="insert into myusers (username,password) values('".$_POST['Nuname']."','".hash('ripemd160', $_POST['Npsw1'])."');"; 
    if ($conn->query($sql) === FALSE) 
     {  echo "<br>shocking: ".$sql."<br>";   }
    header("Location: movie.php");
  }
  else
  {
    echo "<br>Passwords don't match, please try again<br>";
  }
}
else
{
  echo "<br>Username exists. Please try another username.<br>";
}
?>
