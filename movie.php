<html>
<heaad>
<title>Movies</title>
  <link rel="stylesheet" type="text/css" href="movie.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "redhat";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database movieDB;
$sql = "CREATE DATABASE movieDB";
if ($conn->query($sql) === TRUE) {
    $dbname = "movieDB";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) 
	die("Connection failed: " . $conn->connect_error);
     
    // create table myusers
    $sql = "CREATE TABLE myusers (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,username VARCHAR(30) NOT NULL,password VARCHAR(50) NOT NULL,uniqueID VARCHAR(50) not null)";
    if ($conn->query($sql) === FALSE) 
	echo "ERROR";

    //create table marklist
    $sql="create table marklist (id int(5) auto_increment primary key,username varchar(30) not null,movie varchar(60) not null,mark varchar(30) not null,time timestamp);";
    if ($conn->query($sql) === FALSE) 
	echo "ERROR";
} 
?>
<!-- page header -->
<div class="page-header">
    <h1>SNTV     
    <button type="button" onclick="document.getElementById('id01').style.display='block'" style = "position:absolute; right:130px;">Sign in</button>
    <button type="button" onclick="document.getElementById('id02').style.display='block'"style = "position:absolute; right:30px;">Sign up</button>
    </h1>
  </div>
<!-- -->


<!-- Sign in -->
<div id="id01" class="modal">
<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
 <form class="modal-content animate" action="signin.php" method="post">
  <div class="imgcontainer">
    <img src="https://tse1.mm.bing.net/th?id=OIP.GqIjTJaOCVoVTD_TaIErnwHaIJ&pid=Api&P=0&w=300&h=300" alt="Avatar" class="avatar">
  </div>
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <br>
    <?php
        session_start();
        $rand=rand();
        $_SESSION['rand']=$rand;
    ?>
    <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
    <button type="submit" name="submitbtn" style="height:35px;width:80%;">Login</button>
    <br>
  </div>
 </form>
</div>
<!-- -->

<!-- Sign up -->
<div id="id02" class="modal">
<span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
 <form class="modal-content animate" action="signup.php" method="post">
  <div class="imgcontainer">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTiJtBGGbC_GpE-XWFW3AT0h6Yph2XQlyNrRvBTyBnaBBJECG0T" alt="Avatar" class="avatar">
  </div>
  <div class="container">
    <label for="Nuname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="Nuname" required>
    <br>
    <label for="Npsw1"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="Npsw1" required>
    <br>
     <label for="Npsw2"><b>Confirm Password</b></label>
    <input type="password" placeholder="Re-Enter Password" name="Npsw2" required>
    <br>
    <button type="submit" style="height:27px;width:100%">Login</button>
    <br>
  </div>
</form>
<!-- -->


</body>
</html> 
