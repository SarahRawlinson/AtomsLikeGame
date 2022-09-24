<?php 
require_once "include.php";
$str = "";
$table = "";

 list($str, $table) = GamePlay::PlayGame($str, $table);


?>
<!DOCTYPE html>
<a href="Main.php">New Game</a><br><br>
<html>
<head><title>My Game</title>
    <link rel="stylesheet" href="../CSS/GAME.css" type="text/css">
</head>

<body>
<p><?=$str?></p>

<form action="Play.php" method="post">
<?php


echo $table;

?>
</form>
</body>

</html>
