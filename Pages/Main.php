<?php
require_once "include.php";
$number = 5;
$_SESSION['game_data'] = new GameData();
$_SESSION['player'] = new Player('#00FFFF', 'player', 'ai');
$_SESSION['ai'] = new Player('#DC143C', 'ai', 'player');
?>
<!DOCTYPE html>
<html>
<header>
    
</header>

<body>

<form action="Play.php" method="post">
    <?php
    $count = 1;
    echo '<table>';  
    for ($i = 1; $i <= $number; $i++)
    {
        
        echo '<tr>';
        for ($j = 1; $j <= $number; $j++)
        {
            echo '<td>';
            $cell = new Cell($i,$j,$count);
            $_SESSION['game_data']->AddCell($cell);
            echo "<input type='submit' name='selection' value='$count' ".
                "style='height:50px; width:50px; background-color:{$cell->GetCellColour()};'>";
            $count++;
            
            echo '</td>';
        }
        echo '</tr>';
        
    }
    echo '</table>';
    
    ?>
        
    
    
</form>

</body>

</html>