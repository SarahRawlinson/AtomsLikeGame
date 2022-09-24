<?php
class GameData
{
    private $cells;
    private $RowCount = 8;
    private $ColumnCount = 8;
    private $set = false;
    private $MinAtom = 4;
    private $MaxAtom = 4;

    public function Reset()
    {
        $cells = null;
    }
    
    /**
     * @param int $RowCount
     */
    public function setRowCount(int $RowCount)
    {
        $this->RowCount = $RowCount;
        echo "<p>row set ".$this->RowCount."</p>";
    }

    /**
     * @param int $ColumnCount
     */
    public function setColumnCount(int $ColumnCount)
    {
        
        $this->ColumnCount = $ColumnCount;
        echo "<p>column set ".$this->ColumnCount."</p>";
    }

    public function IsSet():bool
    {
        return count($this->cells) > 0;
    }
    
    public function __construct()
    {
        
    }

    public function GetAllCells()
    {
        return $this->cells;
    }
    
    public function GetScore(): array
    {
        $cellsWon = [];
        $emptyCells = 0;
        $playerUnits = [];
        foreach ($this->cells as $cell)
        {
            $player = $cell->WinningPlayer();
            if (isset($player))
            {
                $cellsWon[] = $player->GetName();
                if (isset($playerUnits[$player->GetName()]))
                {
                    $playerUnits[$player->GetName()] += $cell->GetAtoms();
                }
                else
                {
                    $playerUnits[$player->GetName()] = $cell->GetAtoms();
                }
            }
            else
            {
                $emptyCells++;
            }
        }
        return [$cellsWon, $emptyCells, $playerUnits];
    }
    
    public function AddCell(Cell $cell)
    {
        $this->cells[$cell->getNumber().''] = $cell;
    }
    
    public function GetCell(int $number): Cell
    {
        return $this->cells[$number];
    }
    
    private function GetCellByPosition(int $r, int $c): Cell
    {
        return $this->GetCell(GameData::GetCellNumber($r, $c));
    }
    
    public function CellExploded(Cell $cell, IPlayer $winner)
    {
        //echo $cell->getNumber()." has exploded by ".$winner->GetName()."<br>";
        $row = $cell->getRowPos();
        $column = $cell->getColumnPos();
        $atomsToReplace = $cell->GetAtoms();
        $cell->EmptyCell();
        $cells = GameData::GetViableCells($row, $column);
        
        $loop = 0;
        for ($i = 0; $i < $atomsToReplace; $i++)
        {
            //list($newRow, $newColumn, $viable) = $cells[rand(0, count($cells)-1)];
            list($newRow, $newColumn, $viable) = $cells[$loop];
            //echo "row=".$newRow.", column=".$newColumn.", viable=".$viable."<br>";
            if ($viable)
            {
                $newCell = $this->GetCellByPosition($newRow, $newColumn);
                //echo "cell number ".$newCell->getNumber()."<br>";
                $newCell->ChangeAllAtoms($winner);
                $newCell->AddAtom($winner,$_SESSION[$winner->GetOpponent()]);
            }
//            else {
//                echo "Cell lost to the either<br>";
//            }
            $loop++;
            if ($loop > (count($cells)-1))
            {
                $loop = 0;
            }
            
        }
    }

    /**
     * @param int $row
     * @param int $column
     * @return array[]
     */
    public function GetViableCells(int $row, int $column): array
    {

        if ($row < $this->RowCount) {
            $rows[] = $row + 1;
        }
        if ($column > 1) {
            $columns[] = $column - 1;
        }
        if ($column < $this->ColumnCount) {
            $columns[] = $column + 1;
        }
        $up = [$row-1, $column, $row > 1];
        $down = [$row+1, $column, $row < $this->RowCount];
        $left = [$row, $column-1, $column > 1];
        $right = [$row, $column+1, $column < $this->ColumnCount];
        
        return [$up, $down, $left, $right];
    }

    /**
     * @param int $r
     * @param int $c
     * @return float|int
     */
    public function GetCellNumber(int $r, int $c)
    {
        return (($r * $this->ColumnCount) - $this->ColumnCount) + $c;
    }

    public function RowCount(): int
    {
        //echo "<p>row called ".$this->RowCount."</p>";
        return $this->RowCount;
    }
    public function ColumnCount(): int
    {
        //echo "<p>column called ".$this->ColumnCount."</p>";
        return $this->ColumnCount;
    }

    /**
     * @return int
     */
    public function getMinAtom(): int
    {
        return $this->MinAtom;
    }

    /**
     * @return int
     */
    public function getMaxAtom(): int
    {
        return $this->MaxAtom;
    }
}