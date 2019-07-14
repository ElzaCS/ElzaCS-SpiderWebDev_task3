<html>
<heaad>
<title>Movies</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script-->

  <link rel="stylesheet" type="text/css" href="account.css">
  <link rel="stylesheet" type="text/css" href="movie.css">
</head>
<body>
<!-- page header -->
<div class="page-header">
    <h1>SNTV  for <?php session_start(); echo $_SESSION['username'];?>  
    <button onclick="document.getElementById('id03').style.display='block'" style="height:27px;width:10%;float:right;">Sign out</button>
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
$api= '79bdde1e';
$id=$_GET['m_id'];
$name=$_GET['m_name'];

//if both fields are empty
if ($name=='' && $id=='')
 header("Location: account.php");

//if imdbID is passed
if ($id!='') {
$url = file_get_contents("http://www.omdbapi.com/?i=$id&apikey=$api");
}

//if movie title is passed
if ($name!='') {
$m_name=str_replace(" ","-",$name);
$url = file_get_contents("http://www.omdbapi.com/?t=$m_name&apikey=$api");
}

$json = json_decode($url, true); //This will convert it to an array
$movie_title = $json['Title'];
$movie_year = $json['Year'];
$movie_rate = $json['Rated'];
$movie_genre = $json['Genre'];
$movie_runtime = $json['Runtime'];
$movie_director = $json['Director'];
$movie_writer = $json['Writer'];
$movie_actors = $json['Actors'];
$movie_plot = $json['Plot'];
$movie_poster = $json['Poster'];
$movie_imdbRating = $json['imdbRating'];
$movie_imdbVotes = $json['imdbVotes'];
$movie_imdbID = $json['imdbID'];
if ($movie_title!="") {
echo "<img src='$movie_poster' alt='' style='position:absolute;right:10px;width:20%;height:60%;'></img>";
echo "<h3>'$movie_title'</h3>";
echo $movie_plot;
echo "<br><br><strong>Year: </strong>$movie_year</u>";
echo "<br><strong>Runtime: </strong>$movie_runtime";
echo "<br><strong>Rated: </strong>$movie_rate";
echo "<br><strong>Genre: </strong>$movie_genre>";
echo "<br><br><strong>Director: </strong>$movie_director";
echo "<br><strong>Writer: </strong>$movie_writer";
echo "<br><strong>Actors: </strong>$movie_actors";
echo "<br><br><strong>imdbRating: </strong>$movie_imdbRating";
echo "<br><strong>imdbVotes: </strong>$movie_imdbVotes";

 //embed trailer
 $str= str_replace(" ","-",$movie_title);
 $api_url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBb9JUa6mWoRRFV400p0WnvTsYYZrs4TkQ&part=snippet&maxResults=1&type=video&q=$str&controls=1";
 $data = json_decode(file_get_contents($api_url,true));
 $vidID= $data->items[0]->id->videoId; 
echo "<center><iframe width='420' height='345' src='https://www.youtube.com/embed/$vidID?controls=1'></iframe>";

}

//if no info is received from api
else if ($name!='' || $id!='')
echo "<a href='http://www.omdbapi.com/?t=$m_name&apikey=$api'>See raw result</a>";
?>
<br><br>
<a href="account.php"><button style="color:black;"><strong>Back</strong></button></a>
</body>
</html>
