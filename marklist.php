<?php
$title = $_GET['title'];
$mark = $_GET['mark'];
$servername = "localhost";
$username = "root";
$password = "redhat";
$dbname = "movieDB";

//Start Session
session_start();

//echo $_SESSION['username'];
//echo "<br>";
//echo $title;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//add to watchlist
if ($title!='')
{
  if ($mark=="watched")
	$sqlins="insert into marklist (username,movie,mark,time) values('".$_SESSION['username']."','".$title."','watched',NOW());";
  if ($mark=="unwatched")
	$sqlins="delete from marklist where username='".$_SESSION['username']."' and movie='".$title."' and mark='watched';";
  if ($mark=="want")
	$sqlins="insert into marklist (username,movie,mark,time) values('".$_SESSION['username']."','".$title."','want to watch',NOW());";
  if ($mark=="unwant")
	$sqlins="delete from marklist where username='".$_SESSION['username']."' and movie='".$title."' and mark='want';";
  if ($mark=="fav")
	$sqlins="insert into marklist (username,movie,mark,time) values('".$_SESSION['username']."','".$title."','favourite',NOW());";
  if ($mark=="unfav")
	$sqlins="delete from marklist where username='".$_SESSION['username']."' and movie='".$title."' and mark='favourite';";
  if ($conn->query($sqlins) === TRUE) 
	header("Location: account.php");
  else
	echo "sql failed";

}
else 
	echo "title is blank";

?>
