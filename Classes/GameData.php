<?php
class GameData
{
    private $cells;
    private $RowCount = 8;
    private $ColumnCount = 8;
    private $set = false;
    private $MinAtom = 4;
    private $MaxAtom = 4;
    private $HalfCorners = true;

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
                $newCell->AddAtom($winner,$_SESSION[$winner->GetOpponent()], "exploded");
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
        $options = [];
        if (!$this->HalfCorners || $row > 1) 
        {
            $up = [$row-1, $column, $row > 1];
            $options[] = $up;
        }
        if (!$this->HalfCorners || $row < $this->RowCount) 
        {
            $down = [$row+1, $column, $row < $this->RowCount];
            $options[] = $down;
        }
        if (!$this->HalfCorners || $column > 1) 
        {
            $left = [$row, $column-1, $column > 1];
            $options[] = $left;
        }
        if (!$this->HalfCorners || $this->ColumnCount) 
        {
            $right = [$row, $column+1, $column < $this->ColumnCount];
            $options[] = $right;
        }        
        return $options;
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

    /**
     * @param int $MinAtom
     */
    public function setMinAtom(int $MinAtom)
    {
        $this->MinAtom = $MinAtom;
        echo "<p>Min Atom set ".$this->MinAtom."</p>";
    }

    /**
     * @param int $MaxAtom
     */
    public function setMaxAtom(int $MaxAtom)
    {
        $this->MaxAtom = $MaxAtom;
        echo "<p>Max Atom set ".$this->MaxAtom."</p>";
    }

    /**
     * @param bool $HalfCorners
     */
    public function setHalfCorners(bool $HalfCorners)
    {
        $this->HalfCorners = $HalfCorners;
    }

    /**
     * @return bool
     */
    public function isHalfCorners(): bool
    {
        return $this->HalfCorners;
    }
}