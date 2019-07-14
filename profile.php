<html>
<heaad>
<title>Movies</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="account.css">
  <link rel="stylesheet" type="text/css" href="movie.css">
</head>
<body>

<!-- page header -->
<div class="page-header">
    <h1>SNTV  for <?php session_start(); echo $_SESSION['username'];?>  
   <button onclick="document.getElementById('id03').style.display='block'" style="height:27px;width:10%;float:right;">Sign out</button>
   <a href="account.php"><button style="height:27px;width:8%;float:right;">Home</button></a>
<!-- -->

<!--sign out-->
<div id="id03" class="modal">
  <span onclick="document.getElementById('id03').style.display='none'" 
class="close" title="Close Modal">&times;</span>
<form class="modal-content animate" action="signout.php" method="post">
    <div class="container">
    <label for="uname"><b>Are you sure you want to sign out?</b></label>
    <br>
    <button type="submit" style="height:27px;width:100%;">Yes</button>
  </div>
</form>
</div>
  </h1>
</div>
<!----->
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

$api="79bdde1e";

echo "<h2>Your activity</h2>";
$sql="select username,movie,mark,time from marklist where username='".$_SESSION['username']."';";
$res = mysqli_query($conn, $sql);
echo "<table><tr><th>Movie</th><th>Mark</th><th>Time</th></tr>";
while($row =mysqli_fetch_array($res, MYSQLI_ASSOC)) {
 $url = file_get_contents("http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api");
 $json = json_decode($url, true); //This will convert it to an array
 $movie_title = $json['Title'];
 echo "<tr><td>".$movie_title."</td><td>".$row['mark']."</td><td>".$row['time']."</td></tr>";
}
echo "</table>";

echo "<h2>Favourites</h2>";
$sql="select username,movie,mark,time from marklist where username='".$_SESSION['username']."' and mark='favourite';";
$res = mysqli_query($conn, $sql);
echo "<table><tr>";
while($row =mysqli_fetch_array($res, MYSQLI_ASSOC)) {
 $url = file_get_contents("http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api");
 $json = json_decode($url, true); //This will convert it to an array
 $movie_title = $json['Title'];
  $movie_poster = $json['Poster'];
  $movie_year = $json['Year'];
  $movie_runtime = $json['Runtime'];
  $movie_rate = $json['Rated'];
  $movie_genre = $json['Genre'];
  $movie_imdbID = $json['imdbID'];
  $movie_plot = $json['Plot'];
  $movie_director = $json['Director'];
  $movie_writer = $json['Writer'];
  $movie_actors = $json['Actors'];
  $movie_imdbRating = $json['imdbRating'];
 echo "<td><center><div class='contain'>";
 echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
 echo "<div class='middle'><div class='text'>";
$string="document.getElementById('fav_$movie_title').style.display='block'";
 echo '<br><br><button onclick="'.$string.'">View</button>';
 echo "</div></div></div></center>";
 echo "</td>";
?>
<!--view favourites-->
<div id="fav_<?php echo $movie_title;?>" class="modal">
  <span onclick="document.getElementById('fav_<?php echo $movie_title; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="container" style="text-align: left;background-color: #333300;">
    <h3><?php echo $movie_title; ?></h3>
	<p><?php echo $movie_plot; ?></p>
	<p><strong>Year: </strong><?php echo $movie_year; ?></p>
	<p><strong>Duration: </strong><?php echo $movie_runtime; ?></p>
	<p><strong>Rate: </strong><?php echo $movie_rate; ?></p>
	<p><strong>imdb Rating: </strong><?php echo $movie_imdbRating; ?></p>
	<p><strong>Genre: </strong><?php echo $movie_genre; ?></p>
	<p><strong>Stars: </strong><?php echo $movie_actors; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong>Writer: </strong><?php echo $movie_writer; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong><?php echo $movie_imdbID; ?></strong></p>
	<?php $str= str_replace(" ","-",$movie_title); $api_url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBb9JUa6mWoRRFV400p0WnvTsYYZrs4TkQ&part=snippet&maxResults=1&type=video&q=$str";
 $data = json_decode(file_get_contents($api_url,true)); $vidID= $data->items[0]->id->videoId; //echo $api_url."<br>".$vidID."<br>";?>
	<center><!--iframe width="420" height="345" src="https://www.youtube.com/embed/<?php echo $vidID; ?>?controls=1">
</iframe--><br><br>mark as:<br>
<a href='marklist.php?mark=want&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>want to watch</strong></button></a>    
<a href='marklist.php?mark=watched&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>watched</strong></button></a>
<a href='marklist.php?mark=unfav&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>unfavourite</strong></button></a></center>

  </div>
</div>
<!----->
<?php
}
echo "</tr></table>";

echo "<h2>Watched</h2>";
$sql="select username,movie,mark,time from marklist where username='".$_SESSION['username']."' and mark='watched';";
$res = mysqli_query($conn, $sql);
echo "<table><tr>";
while($row =mysqli_fetch_array($res, MYSQLI_ASSOC)) {
  //echo "<br>".$row['movie'].", ";
 $url = file_get_contents("http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api");
 $json = json_decode($url, true); //This will convert it to an array
 $movie_title = $json['Title'];
  $movie_poster = $json['Poster'];
  $movie_year = $json['Year'];
  $movie_runtime = $json['Runtime'];
  $movie_rate = $json['Rated'];
  $movie_genre = $json['Genre'];
  $movie_imdbID = $json['imdbID'];
  $movie_plot = $json['Plot'];
  $movie_director = $json['Director'];
  $movie_writer = $json['Writer'];
  $movie_actors = $json['Actors'];
  $movie_imdbRating = $json['imdbRating'];
 //echo "<br>http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api";
 echo "<td><center><div class='contain'>";
 echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
 echo "<div class='middle'><div class='text'>";
$string="document.getElementById('watc_$movie_title').style.display='block'";
 echo '<br><br><button onclick="'.$string.'">View</button>';
 echo "</div></div></div></center>";
 echo "</td>";
?>
<!--view watched-->
<div id="watc_<?php echo $movie_title;?>" class="modal">
  <span onclick="document.getElementById('watc_<?php echo $movie_title; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="container" style="text-align: left;background-color: #333300;">
    <h3><?php echo $movie_title; ?></h3>
	<p><?php echo $movie_plot; ?></p>
	<p><strong>Year: </strong><?php echo $movie_year; ?></p>
	<p><strong>Duration: </strong><?php echo $movie_runtime; ?></p>
	<p><strong>Rate: </strong><?php echo $movie_rate; ?></p>
	<p><strong>imdb Rating: </strong><?php echo $movie_imdbRating; ?></p>
	<p><strong>Genre: </strong><?php echo $movie_genre; ?></p>
	<p><strong>Stars: </strong><?php echo $movie_actors; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong>Writer: </strong><?php echo $movie_writer; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong><?php echo $movie_imdbID; ?></strong></p>
	<?php $str= str_replace(" ","-",$movie_title); $api_url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBb9JUa6mWoRRFV400p0WnvTsYYZrs4TkQ&part=snippet&maxResults=1&type=video&q=$str";
 $data = json_decode(file_get_contents($api_url,true)); $vidID= $data->items[0]->id->videoId; //echo $api_url."<br>".$vidID."<br>";?>
	<center><iframe width="420" height="345" src="https://www.youtube.com/embed/<?php echo $vidID; ?>?controls=1">
</iframe><br><br>mark as:<br>
<a href='marklist.php?mark=want&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>want to watch</strong></button></a>    
<a href='marklist.php?mark=unwatched&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>not watched</strong></button></a>
<a href='marklist.php?mark=fav&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>favourite</strong></button></a></center>

  </div>
</div>
<!----->
<?php
}
echo "</tr></table>";

echo "<h2>Marked as watch later</h2>";
$sql="select username,movie,mark,time from marklist where username='".$_SESSION['username']."' and mark='want to watch';";
$res = mysqli_query($conn, $sql);
echo "<table><tr>";
while($row =mysqli_fetch_array($res, MYSQLI_ASSOC)) {
  //echo "<br>".$row['movie'].", ";
 $url = file_get_contents("http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api");
 $json = json_decode($url, true); //This will convert it to an array
 $movie_title = $json['Title'];
  $movie_poster = $json['Poster'];
  $movie_year = $json['Year'];
  $movie_runtime = $json['Runtime'];
  $movie_rate = $json['Rated'];
  $movie_genre = $json['Genre'];
  $movie_imdbID = $json['imdbID'];
  $movie_plot = $json['Plot'];
  $movie_director = $json['Director'];
  $movie_writer = $json['Writer'];
  $movie_actors = $json['Actors'];
  $movie_imdbRating = $json['imdbRating'];
 //echo "<br>http://www.omdbapi.com/?i=".$row['movie']."&apikey=$api";
 echo "<td><center><div class='contain'>";
 echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
 echo "<div class='middle'><div class='text'>";
$string="document.getElementById('want_$movie_title').style.display='block'";
 echo '<br><br><button onclick="'.$string.'">View</button>';
 echo "</div></div></div></center>";
 echo "</td>";
?>
<!--view watch later-->
<div id="want_<?php echo $movie_title;?>" class="modal">
  <span onclick="document.getElementById('want_<?php echo $movie_title; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="container" style="text-align: left;background-color: #333300;">
    <h3><?php echo $movie_title; ?></h3>
	<p><?php echo $movie_plot; ?></p>
	<p><strong>Year: </strong><?php echo $movie_year; ?></p>
	<p><strong>Duration: </strong><?php echo $movie_runtime; ?></p>
	<p><strong>Rate: </strong><?php echo $movie_rate; ?></p>
	<p><strong>imdb Rating: </strong><?php echo $movie_imdbRating; ?></p>
	<p><strong>Genre: </strong><?php echo $movie_genre; ?></p>
	<p><strong>Stars: </strong><?php echo $movie_actors; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong>Writer: </strong><?php echo $movie_writer; ?></p>
	<p><strong>Director: </strong><?php echo $movie_director; ?></p>
	<p><strong><?php echo $movie_imdbID; ?></strong></p>
	<?php $str= str_replace(" ","-",$movie_title); $api_url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBb9JUa6mWoRRFV400p0WnvTsYYZrs4TkQ&part=snippet&maxResults=1&type=video&q=$str";
 $data = json_decode(file_get_contents($api_url,true)); $vidID= $data->items[0]->id->videoId; //echo $api_url."<br>".$vidID."<br>";?>
	<center><iframe width="420" height="345" src="https://www.youtube.com/embed/<?php echo $vidID; ?>?controls=1">
</iframe><br><br>mark as:<br>
<a href='marklist.php?mark=unwant&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>don't want to watch</strong></button></a>    
<a href='marklist.php?mark=watched&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>watched</strong></button></a>
<a href='marklist.php?mark=fav&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>favourite</strong></button></a></center>

  </div>
</div>
<!----->
<?php
}
echo "</tr></table>";
?>

</body>
</html>
