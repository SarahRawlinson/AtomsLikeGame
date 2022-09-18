<?php

class Cell
{
    const AtomMaxLimit = 10;
    const AtomMinLimit = 2;
    const DefaultColour = "#FFD700";
    private int $rowPos;
    private int $columnPos;
    private int $number;
    private int $atomLimit;
    private int $atoms = 0;
    private string $cellColour = "#FFD700";
    private array $playerAtoms = [];
    
    public function __construct(int $rowPos, int $columnPos, int $number)
    {
        $this->rowPos = $rowPos;
        $this->columnPos = $columnPos;
        $this->number = $number;
        $this->atomLimit = rand(self::AtomMinLimit, self::AtomMaxLimit);
    }
    
    public function WinningPlayer(): IPlayer | null
    {
        if (count($this->playerAtoms) == 0) 
        {
            return null;
        }
        $players = array_count_values($this->playerAtoms);
        $maxAtoms = max($players);
        //print_r($maxAtoms);
        return $_SESSION[array_search($maxAtoms, $players)];
    }
    
    public function AddAtom(IPlayer $player, IPlayer $opponent):void
    {
        if (($this->atoms + 1) > $this->atomLimit)
        {            
            $this->Explode($opponent);            
        }
        else
        {            
            $this->atoms++;
            $this->playerAtoms[] = $player->GetName();
//            $v = $this->WinningPlayer();
//            if (isset($v))
//            {
//                //echo $v->GetColour();
//            }            
        }
    }

    /**
     * @return int
     */
    public function getRowPos(): int
    {
        return $this->rowPos;
    }

    /**
     * @return int
     */
    public function getColumnPos(): int
    {
        return $this->columnPos;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    private function Explode(IPlayer $winner): void
    {
        $_SESSION['game_data']->CellExploded($this, $winner);
        //echo $winner->GetColour()."\n";
        //$this->cellColour = $winner->GetColour();
        //echo $this->cellColour."\n";
        $this->atoms = 0;
        $this->playerAtoms = [];
        //echo $this->number." has exploded";
    }
    
    public function GetAtoms():int
    {
        return $this->atoms;
    }

    /**
     * @return string
     */
    public function GetCellColour(): string
    {
//        $v = $this->WinningPlayer();
//        if (isset($v))
//        {
//            return $v->GetColour();
//        }
        return $this->cellColour;
    }

    /**
     * @param string $player
     * @return int
     */
    public function GetPlayerAtoms(string $player): int
    {
        $counts = array_count_values($this->playerAtoms);

        
        if (isset($counts[$player]))
        {
            //var_dump($counts);
            return $counts[$player];
        }     
        return 0;
    }
}