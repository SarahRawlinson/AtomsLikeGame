<?php

class Cell
{
    private $AtomMaxLimit;
    private $AtomMinLimit;
    const DefaultColour = "#FFD700";
    private  $rowPos;
    private  $columnPos;
    private  $number;
    private  $atomLimit;
    private  $atoms = 0;
    private  $cellColour = "#FFD700";
    private  $playerAtoms = [];
    
    public function __construct(int $rowPos, int $columnPos, int $number, int $maxAtom, int $minAtom)
    {
        $this->rowPos = $rowPos;
        $this->columnPos = $columnPos;
        $this->number = $number;
        $this->AtomMaxLimit = $maxAtom;
        $this->AtomMinLimit = $minAtom;
        $this->atomLimit = rand($this->AtomMinLimit, $this->AtomMaxLimit);        
    }
    
//    public function WinningPlayer()
//    {
//        if (count($this->playerAtoms) == 0) 
//        {
//            return null;
//        }
//        $players = array_count_values($this->playerAtoms);
//        $maxAtoms = max($players);
//        //print_r($maxAtoms);
//        return $_SESSION[array_search($maxAtoms, $players)];
//    }
    public function WinningPlayer()
    {
        if (count($this->playerAtoms) == 0)
        {
            return null;
        }
        return $_SESSION[$this->playerAtoms[0]];
    }
    
    public function AddAtom(IPlayer $player, IPlayer $opponent): bool
    {
        if (count($this->playerAtoms) > 0 && !in_array($player->GetName(), $this->playerAtoms))
        {
            return false;
        }
        $this->atoms++;
        $this->playerAtoms[] = $player->GetName();
        if ($this->atoms >= $this->atomLimit)
        {            
            $this->Explode($player);            
        }
        return true;
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

    private function Explode(IPlayer $winner)
    {
        $_SESSION['game_data']->CellExploded($this, $winner);
        //echo $winner->GetColour()."\n";
        //$this->cellColour = $winner->GetColour();
        //echo $this->cellColour."\n";
        //echo $this->number." has exploded";
    }
    
    public function GetAtoms():int
    {
        return $this->atoms;
    }
    
    public function GetAtomOwners(): array
    {
        return $this->playerAtoms;
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
    public function GetPlayerAtomsByPlayer(string $player): int
    {
        $counts = array_count_values($this->playerAtoms);

        
        if (isset($counts[$player]))
        {
            //var_dump($counts);
            return $counts[$player];
        }     
        return 0;
    }

    public function ChangeAllAtoms(IPlayer $winner)
    {
        //echo $winner->GetName()." now has cell ".$this->number."<br>";
        for ($i = 0;$i < count($this->playerAtoms); $i++)
        {            
            $this->playerAtoms[$i] = $winner->GetName();
        }
    }

    public function GetPlayerAtoms(): int
    {
        return count($this->playerAtoms);
    }

    /**
     * @return void
     */
    public function EmptyCell()
    {
        $this->atoms = 0;
        $this->playerAtoms = [];
    }
}