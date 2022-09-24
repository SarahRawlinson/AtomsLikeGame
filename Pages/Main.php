<?php
require_once "include.php";
if(isset($_SESSION))
{
    session_destroy();
}
session_start();
$_SESSION['game_data'] = new GameData();
$_SESSION['player'] = new Player('#00FFFF', 'player', 'ai');
$_SESSION['ai'] = new Player('#DC143C', 'ai', 'player');
$_SESSION['started'] = null;
?>
<!DOCTYPE html>
<html>
<head><title>My Game</title>
    <link rel="stylesheet" href="../CSS/GAME.css" type="text/css">
</head>

<body>

<form action="Play.php" method="post"> 
    <?php
    $count = 1;
    //echo '<table>';  
    for ($i = 1; $i <= GameData::RowCount; $i++)
    {
        
        //echo '<tr>';
        for ($j = 1; $j <= GameData::ColumnCount; $j++)
        {
            //echo '<td>';
            $cell = new Cell($i,$j,$count);
            $_SESSION['game_data']->AddCell($cell);
            //echo "<input type='submit' name='selection' value='$count' ".
                //"style='height:50px; width:50px; background-color:{$cell->GetCellColour()};'>";
            $count++;
            
            //echo '</td>';
        }
        //echo '</tr>';
        
    }
    //echo '</table>';
    echo TableGenerator::GenerateTable(true);
    ?>
        
    
    
</form>

</body>

</html>