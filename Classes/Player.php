<?php

class Player implements IPlayer
{
    private  $colour;
    private  $name;
    private  $opponent;
    
    public function __construct(string $colour, string $name, string $opponent)
    { 
        $this->colour = $colour;
        $this->name = $name;
        $this->opponent = $opponent;
    }

    public function GetColour(): string
    {
        return $this->colour;
    }

    public function GetName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function GetOpponent(): string
    {
        return $this->opponent;
    }
}