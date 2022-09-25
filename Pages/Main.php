<?php
require_once "include.php";
if(isset($_SESSION['game_data']))
{
    $_SESSION['game_data']->Reset();
}
else
{
    $_SESSION['game_data'] = new GameData();    
}
$_SESSION['csv_writer'] = new CSVWriter();
$_SESSION['player'] = new Player('#00FFFF', 'player', 'ai');
$_SESSION['ai'] = new Player('#DC143C', 'ai', 'player');
$_SESSION['started'] = null;
?>
<!DOCTYPE html>
<html lang="en">
<head><title>My Game</title>
    <link rel="stylesheet" href="../CSS/GAME.css" type="text/css">
</head>

<body>
<a href="settings.php">settings</a><br><br>
<form action="Play.php" method="post"> 
    <?php
    $count = 1;
    for ($i = 1; $i <= $_SESSION['game_data']->RowCount(); $i++)
    {
        for ($j = 1; $j <= $_SESSION['game_data']->ColumnCount(); $j++)
        {
            $cell = new Cell($i,$j,$count, $_SESSION['game_data']->getMaxAtom(), $_SESSION['game_data']->getMinAtom());
            $_SESSION['game_data']->AddCell($cell);
            $count++;
        }        
    }
    echo TableGenerator::GenerateTable(true);
    ?>       
    
    
</form>

</body>

</html>