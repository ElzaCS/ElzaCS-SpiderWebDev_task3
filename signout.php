<html>
<head>
</head>
<body>
<?php
 session_start();
 $_SESSION = array();
 session_destroy();
 header('Location: movie.php');
?>
</body>
</html>
