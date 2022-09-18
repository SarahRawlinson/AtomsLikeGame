<?php 
require_once "include.php";
$str = "";
if (isset($_SESSION['game_data']) && isset($_POST['selection']))
{
    var_dump($_POST['selection']);
    $cell = $_SESSION['game_data']->GetCell($_POST['selection']);  
    $cell->AddAtom($_SESSION['player'], $_SESSION['ai']);
    $cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount*GameData::RowCount));
    $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
//    $str = "row = ".$cell->getRowPos().", column = ".$cell->getColumnPos().", number = ".$cell->getNumber()
//        .", atoms = ".$cell->GetAtoms().", colour = ".$cell->GetCellColour();
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
    .circle {
    height: 5px;
    width: 5px;
    /*background-color: #555;*/
    border-radius: 50%;
    }
    .square {
        height: 15px;
        width: 15px;
        /*background-color: #555;*/
    }
    </style>
</head>

<body>

<form action="Play.php" method="post">
<?php
$count = 1;
echo '<table>';
for ($i = 1; $i <= GameData::RowCount; $i++)
{

    echo '<tr>';
    for ($j = 1; $j <= GameData::ColumnCount; $j++)
    {
        echo '<td>';
        //echo $count;
        $cell = $_SESSION['game_data']->GetCell($count);
        $winner = $cell->WinningPlayer();
        
        
        echo "<button type='submit' id='$count' name='selection' value='$count' ".
            "style='height:100px; width:100px; background-color:{$cell->GetCellColour()};'>";
        
        if (isset($winner))
        {
            echo '<div class="square" id="'.$winner->GetName().'" style="background-color: '.$winner->GetColour().'"></div><br>';
        }
        echo '<table>';
        echo '<tr>';
        $aiCount = $cell->GetPlayerAtoms('ai');
        for ($a = 0; $a < $aiCount; $a++)
        {
            echo '<td>';
            //echo "ai";
            echo '<div class="circle" id="ai" style="background-color: '.$_SESSION['ai']->GetColour().'"></div>';
            echo '</td>';
        }
        $playerCount = $cell->getPlayerAtoms('player');
        for ($p = 0; $p < $playerCount; $p++)
        {
            echo '<td>';
            //echo "player";
            echo '<div class="circle" id="player" style="background-color: '.$_SESSION['player']->GetColour().'"></div>';
            echo '</td>';
        }
        echo '</tr>';
        echo '</table>';
        
        echo "</button>";
        
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
