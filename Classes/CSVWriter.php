<?php

class CSVWriter
{

    private $file;
    public function __construct()
    {
        $digits = 5;
        $r = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, $digits);
        $this->file = "../CSV/gameplay_".$r."_".date("Y-m-d_h-i-sa").".csv";
        $file = fopen($this->file, "w");
        fputcsv($file, ['player', 'cell', 'atoms', 'time', 'status']);
        fclose($file);
    }
    public function AddData($player, $row, $column, $atoms, $status)
    {
        //$data = [$player, $row.$column, $atoms.""];
        $file = fopen($this->file, "a");
        fputcsv($file, [$player, $row.$column, $atoms."", date("d/m/Y : h:i:sa"), $status]);
        fclose($file);
    }
}