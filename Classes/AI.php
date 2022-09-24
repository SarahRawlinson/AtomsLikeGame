<?php

class AI 
{
    

//    /**
//     * @return void
//     */
//    public static function AIMakeMove()
//    {
//        $moveMade = false;
//        while (!$moveMade) {
//            $cells = $_SESSION['game_data']->GetAllCells();
//            $cellsDic = [];
//            foreach ($cells as $cell) {
//                $v = $cell->WinningPlayer();
//                if (!isset($v)) {
//                    continue;
//                }
//                if ($cell->WinningPlayer()->GetName() == 'ai') {
//                    $cellsDic[$cell->GetAtoms()][] = $cell;
//                }
//                if ($cell->WinningPlayer()->GetName() == 'player') {
//                    $cellsDic[$cell->GetAtoms()][] = $cell;
//                }
//            }
//            if (isset($cellsDic[3])) {
//                $cell = $cellsDic[3][rand(0, count($cellsDic[3]) - 1)];
//            } else if (isset($cellsDic[2])) {
//                $cell = $cellsDic[2][rand(0, count($cellsDic[2]) - 1)];
//            } else if (isset($cellsDic[1])) {
//                $cell = $cellsDic[1][rand(0, count($cellsDic[1]) - 1)];
//            } else {
//                $cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount * GameData::RowCount));
//            }
//            //print_r($cellsDic);
//            //$cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount*GameData::RowCount));
//            $moveMade = $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
//        }
//    }

    /**
     * @return void
     */
    public static function AIMove()
    {
        $moveMade = false;
        while (!$moveMade) {
            $cell = $_SESSION['game_data']->GetCell(rand(1, GameData::ColumnCount * GameData::RowCount));
            $moveMade = $cell->AddAtom($_SESSION['ai'], $_SESSION['player']);
        }
    }
}