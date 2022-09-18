<?php
class GameData
{
    private array $cells;
    const RowCount = 5;
    const ColumnCount = 5;
    
    public function __construct()
    {
        
    }
    
    public function AddCell(Cell $cell): void
    {
        $this->cells[$cell->getNumber().''] = $cell;
    }
    
    public function GetCell(int $number): Cell
    {
        return $this->cells[$number];
    }
    
    private function GetCellByPosition(int $r, int $c): Cell
    {
        return $this->GetCell((($r*self::ColumnCount)-self::ColumnCount)+$c);
    }
    
    public function CellExploded(Cell $cell, IPlayer $winner): void
    {
        $row = $cell->getRowPos();
        $column = $cell->getColumnPos();
        $players = $cell->getPlayerAtoms($winner->GetName());
        $rows[] = $row;
        $columns[] = $column;
        if ($row > 1)
        {
            $rows[] = $row -1;
        }
        if ($row < self::RowCount)
        {
            $rows[] = $row +1;
        }
        if ($column > 1)
        {
            $columns[] = $column -1;
        }
        if ($column < self::ColumnCount)
        {
            $columns[] = $column +1;
        }
        for ($i = 0; $i < $players; $i++)
        {
            $newRow = $row;
            $newColumn = $column;
            while ($newRow == $row && $newColumn == $column)
            {
                $rr = rand(0, count($rows)-1);
                //echo "\nrows =".$rr."\n";
                $newRow = $rows[$rr];
                $rc = rand(0, count($columns)-1);
                //echo "\ncolumns ".$rc."\n";
                $newColumn = $columns[$rc];
            }
            $newCell = $this->GetCellByPosition($newRow, $newColumn);
            $player = $winner;
            $newCell->AddAtom($player,$_SESSION[$player->GetOpponent()]);
        }
    }
}