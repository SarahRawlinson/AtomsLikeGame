<?php

class AI 
{

    public static function AILevel1Move(): int
    {
        $cells = $_SESSION['game_data']->GetAllCells();
        $cellsDic = [];
        foreach ($cells as $cell) {
            $v = $cell->WinningPlayer();
            if (!isset($v)) {
                $cellsDic['empty'][0][] = $cell;
                continue;
            }
            $name = $v->GetName();
            if ($name == 'ai') {
                $cellsDic['ai'][$cell->GetAtoms()][] = $cell;                
            }
            if ($name == 'player') {
                $cellsDic['player'][$cell->GetAtoms()][] = $cell;
            }
        }
        //var_dump($cellsDic['player'][2]);
        for ($i = Cell::AtomMaxLimit; $i >= 0; $i--)
        {
            $chosenCell = self::GetPlayerMinExplode($cellsDic, $cells, $i);
            if ($chosenCell != -1)
            {
                return $chosenCell;
            }
        }        
        return -1;
    }    

    /**
     * @param array $cellsDic
     * @param array $cells
     * @param int $atoms
     * @return void
     */
    public static function GetPlayerMinExplode(array $cellsDic, array $cells, int $atoms): int
    {
        if (isset($cellsDic['player'][$atoms])) {
            
            foreach ($cellsDic['player'][$atoms] as $playerCell) 
            {
                $cellNumber = self::GetEqualValueAICellNextToPlayerCell($playerCell, $cells, $atoms);
                if ($cellNumber != -1)
                {
                    echo "<p>worked</p>";
                    return $cellNumber;
                }

            }
        }
        return -1;
    }

    /**
     * @param Cell $playerCell
     * @param array $cells
     * @param int $atoms
     * @return void
     */
    public static function GetEqualValueAICellNextToPlayerCell(Cell $playerCell, array $cells, int $atoms) : int
    {
        foreach (GameData::GetViableCells($playerCell->getRowPos(), $playerCell->getColumnPos()) as $pos) {
            list($newRow, $newColumn, $viable) = $pos;
            if ($viable)
            {
                $cellNumber = GameData::GetCellNumber($newRow, $newColumn);
                $checkCell = $cells[$cellNumber];
                $winner = $checkCell->WinningPlayer();
                if (!isset($winner))
                {
                    
                }
                else if ($winner->GetName() == 'ai')
                {
                    if ($checkCell->GetAtoms() == $atoms)
                    {
                        return $cellNumber;
                    }
                }
            }
        }
        return -1;
    }

    /**
     * @return void
     */
    public static function AIMove()
    {
        $moveMade = false;
        $number = self::AILevel1Move();
        if ($number != -1)
        {
            $cell = $_SESSION['game_data']->GetCell($number);
            $moveMade = $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
        }        
        while (!$moveMade) {
            
            $cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount * GameData::RowCount));
            $moveMade = $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
        }
    }
}