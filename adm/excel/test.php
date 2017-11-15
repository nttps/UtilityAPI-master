<?php

function updateLeague($db, $i_game, $i_team) {
        $set = $this->getData($db, $i_game, $i_team);
        $updateAway = "";
        $updateAway .= "UPDATE ";
        $updateAway .= "  tb_league_table ";
        $updateAway .= "SET ";
        $updateAway .= "  i_win = $set[i_win], ";
        $updateAway .= "  i_frequent = $set[i_frequent], ";
        $updateAway .= "  i_lose = $set[i_lose], ";
        $updateAway .= "  i_score_win = $set[i_score_win], ";
        $updateAway .= "  i_score_lose = $set[i_score_lose], ";
        $updateAway .= "  i_score = $set[i_score], ";
        $updateAway .= "  i_result = $set[i_result], ";
        $updateAway .= "  s_update_by = '$_SESSION[username]', ";
        $updateAway .= "  d_update = " . $db->Sysdate(TRUE) . "  ";
        $updateAway .= "WHERE ";
        $updateAway .= "    i_game = $i_game ";
        $updateAway .= " AND i_team = $i_team ";

        return array("query" => "$updateAway");
    }


$arrTable = array();
        if ($final) {
            array_push($arrTable, $this->updateLeague($db, $info[i_game], $info[i_home_team]));
            array_push($arrTable, $this->updateLeague($db, $info[i_game], $info[i_away_team]));
            $result2 = $db->insert_for_upadte($arrTable);
        }