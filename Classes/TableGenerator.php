<?php

class TableGenerator
{

    /**
     * @return void
     */
    public static function GenerateTable(bool $select): string
    {
        $onOff = "";
        if (!$select) {
            $onOff = " disabled";
        }
        $count = 1;
        $value = "";
        $value .= '<table>';
        for ($i = 1; $i <= $_SESSION['game_data']->RowCount(); $i++) {

            $value .= '<tr>';
            for ($j = 1; $j <= $_SESSION['game_data']->ColumnCount(); $j++) {
                $value .= '<td>';
                //echo $count." r ".$i." c ".$j;
                $cell = $_SESSION['game_data']->GetCell($count);
                $winner = $cell->WinningPlayer();


                $value .= "<button type='submit' id='$count' name='selection' value='$count' " .
                    "style='height:120px; width:120px; background-color:{$cell->GetCellColour()};'$onOff>";

//                if (isset($winner)) {
//                    $value .= '<div class="square" id="' . $winner->GetName() . '" style="background-color: ' . $winner->GetColour() . '"></div><br>';
//                }
                $value .= '<table>';
                $value .= '<tr>';
                $aiCount = $cell->GetPlayerAtomsByPlayer('ai');
                for ($a = 0; $a < $aiCount; $a++) {
                    $value .= '<td>';
                    //echo "ai";
                    $value .= '<div class="circle" id="ai" style="background-color: ' . $_SESSION['ai']->GetColour() . '"></div>';
                    $value .= '</td>';
                }
                $playerCount = $cell->GetPlayerAtomsByPlayer('player');
                for ($p = 0; $p < $playerCount; $p++) {
                    $value .= '<td>';
                    //echo "player";
                    $value .= '<div class="circle" id="player" style="background-color: ' . $_SESSION['player']->GetColour() . '"></div>';
                    $value .= '</td>';
                }
                $value .= '</tr>';
                $value .= '</table>';

                $value .= "</button>";

                $count++;

                $value .= '</td>';
            }
            $value .= '</tr>';

        }
        $value .= '</table>';
        return $value;
    }
}