<?php 
require_once "include.php";
$str = "";
$table = "";
if (isset($_SESSION['game_data']) && isset($_POST['selection']))
{
    list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();
    if (count($playerUnits) == 1 && isset($_SESSION['started']))
    {
        $str = "Game Over ".array_search(max($playerUnits), $playerUnits)." Won!";
        $table = TableGenerator::GenerateTable(false);
        session_destroy();
    }
    else
    {
        //var_dump($_POST['selection']);
        $cell = $_SESSION['game_data']->GetCell($_POST['selection']);
        $valid = $cell->AddAtom($_SESSION['player'], $_SESSION['ai']);
        list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();
        if (count($playerUnits) == 1 && isset($_SESSION['started']))
        {
            $str = "Game Over ".array_search(max($playerUnits), $playerUnits)." Won!";
            $table = TableGenerator::GenerateTable(false);
            session_destroy();
        }        
        else
        {
            if ($valid)
            {
                $moveMade = false;
                while (!$moveMade)
                {
                    $cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount*GameData::RowCount));
                    $moveMade = $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
                }

            }
            else {
                $str = "You cant select that cell";
            }
            $table = TableGenerator::GenerateTable(true);
        }
        $_SESSION['started'] = true;
        
    }
    
    
//    $str = "row = ".$cell->getRowPos().", column = ".$cell->getColumnPos().", number = ".$cell->getNumber()
//        .", atoms = ".$cell->GetAtoms().", colour = ".$cell->GetCellColour();
    
}


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
