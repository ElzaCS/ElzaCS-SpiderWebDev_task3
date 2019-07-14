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
   <a href="profile.php"><button style="height:27px;width:12%;float:right;">View my Profile</button></a>
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

<!-- search form -->
<form class="search" action="result.php" method="get">
<table>
<tr>
  <td><label style="color:white;">Search by title: </label></td>
  <td><input type="text" id='m_name' name='m_name'></input>
</tr>
<tr>
  <td><label style="color:white;">Search by imdbID: </label></td>
  <td><input type="text" id='m_id' name='m_id'></input>
</tr>
<tr>
  <td><button type="submit">Enter</button></td>
</tr>
</table>
</form>
<!-- -->

<br><br>

<!recent movies -->
<center><h2>Recent Movies for You</h2>
<table><tr>
<?php
$api="79bdde1e";
$x=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$id_trk=array();
$k=0;

for ($i=0;$i<3;$i+=1) {
  $y=$x[$i];
  $check=0;
  $url = file_get_contents("http://www.omdbapi.com/?apikey=$api&y=2019&t=$y*");
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

  //to check if the movie is already displayed
  for ($j=0;$j<count($id_trk);$j+=1) {
	if ($movie_imdbID==$id_trk[$j]) 
		$check+=1;
  }
  if ($check==0) {
	$id_trk[$k]=$movie_imdbID;
	$string="document.getElementById('$movie_title').style.display='block'";
	echo "<td><center><div class='contain'>";
	echo "<img src='$movie_poster' class='image' style='width:100%;height:100%;'></img>";
	echo "<div class='middle'><div class='text'><br><strong>$movie_title</strong><br><br>".substr($movie_plot,0,125);
	if (strlen($movie_plot)>125)
	echo "..."; 
	echo "<br><br>".substr($movie_genre,0,35);
	if (strlen($movie_genre)>35)
	echo "...";
	echo '<br><br><button onclick="'.$string.'">View</button>';
	echo "</div></div></div><center></td>";
	$k+=1;
  }
  if ($k%4==0)
	echo "</tr><tr>";
?>
<!-- -->

<!--view -->
<div id="<?php echo $movie_title;?>" class="modal">
  <span onclick="document.getElementById('<?php echo $movie_title; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
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
	<?php //embed trailer 
	$str= str_replace(" ","-",$movie_title); $api_url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBb9JUa6mWoRRFV400p0WnvTsYYZrs4TkQ&part=snippet&maxResults=1&type=video&q=$str";
	$data = json_decode(file_get_contents($api_url,true)); $vidID= $data->items[0]->id->videoId; ?>
	<center><iframe width="420" height="345" src="https://www.youtube.com/embed/<?php echo $vidID; ?>?controls=1"></iframe><br><br>mark as:<br>
<a href='marklist.php?mark=want&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>want to watch</strong></button></a>    
<a href='marklist.php?mark=watched&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>watched</strong></button></a>
<a href='marklist.php?mark=fav&title=<?php echo $movie_imdbID; ?>'><button style="color:black;"><strong>favourite</strong></button></a></center>

  </div>
</div>
<!----->
<?php
}
echo "</tr></table></center>";
?>

</body>
</html>
