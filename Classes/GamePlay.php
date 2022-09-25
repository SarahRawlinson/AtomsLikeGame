<?php

class GamePlay
{

    /**
     * @param string $str
     * @param string $table
     * @return array
     */
    public static function PlayGame(string $str, string $table): array
    {
        if (isset($_SESSION['game_data']) && isset($_POST['selection'])) {
            list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();


            if (count($playerUnits) == 1 && isset($_SESSION['started'])) {
                $str = "Game Over " . array_search(max($playerUnits), $playerUnits) . " Won!<br>";
                $table = TableGenerator::GenerateTable(false);
                session_destroy();
            } else {
                //var_dump($_POST['selection']);
                $cell = $_SESSION['game_data']->GetCell($_POST['selection']);
                $valid = $cell->AddAtom($_SESSION['player'], $_SESSION['ai'], "move made");
                list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();
                if (count($playerUnits) == 1 && isset($_SESSION['started'])) {
                    $str = "Game Over " . array_search(max($playerUnits), $playerUnits) . " Won!<br>";
                    $table = TableGenerator::GenerateTable(false);
                    session_destroy();
                } 
                else {
                    if ($valid) {
                        AI::AIMove();

                    } else {
                        $str .= "You cant select that cell<br>";
                    }
                    list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();
                    if (count($playerUnits) == 1 && isset($_SESSION['started'])) {
                        $str = "Game Over " . array_search(max($playerUnits), $playerUnits) . " Won!<br>";
                        $table = TableGenerator::GenerateTable(false);
                        session_destroy();
                    }
                    else
                    {
                        $table = TableGenerator::GenerateTable(true);
                    }                    
                }
                
                $_SESSION['started'] = true;

            }
            list($cellsWon, $emptyCells, $playerUnits) = $_SESSION['game_data']->GetScore();
            if (isset($playerUnits['ai']) > 0) {
                $str .= "AI = " . $playerUnits['ai'] . "<br>";
            }
            if (isset($playerUnits['player']) > 0) {
                $str .= "Player = " . $playerUnits['player'] . "<br>";
            }


//    $str = "row = ".$cell->getRowPos().", column = ".$cell->getColumnPos().", number = ".$cell->getNumber()
//        .", atoms = ".$cell->GetAtoms().", colour = ".$cell->GetCellColour();

        }
        return array($str, $table);
    }

    /**
     * @return void
     */
    public static function GenerateCells()
    {
        $rowCount = $_SESSION['game_data']->RowCount();
        $columnCount = $_SESSION['game_data']->ColumnCount();
        $count = 1;
        for ($i = 1; $i <= $rowCount; $i++) {
            for ($j = 1; $j <= $columnCount; $j++) {
                $minAtoms = $_SESSION['game_data']->getMinAtom();
                $maxAtoms = $_SESSION['game_data']->getMaxAtom();
                
                if ($_SESSION['game_data']->isHalfCorners())
                {
                    if ($i == 1 || $i == $rowCount)
                    {
                        $minAtoms = $minAtoms - round($minAtoms/4);
                        $maxAtoms = $maxAtoms - round($maxAtoms/4);
                    }
                    if ($j == 1 || $j == $columnCount)
                    {
                        $minAtoms = $minAtoms - round($minAtoms/4);
                        $maxAtoms = $maxAtoms - round($maxAtoms/4);
                    }
                }            
                
                $cell = new Cell($i, $j, $count, $maxAtoms, $minAtoms);
                $_SESSION['game_data']->AddCell($cell);
                $count++;
            }
        }
    }
}