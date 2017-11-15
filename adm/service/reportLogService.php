<?php

@session_start();

class reportLogService {

    //($info, $date, $menu, $action, $user, $other);
    function search($info, $_d, $_m, $_a, $_u, $_o) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= " select   ";
        $strSql .= " l.i_log , l.s_type s_menu , l.s_action , l.d_create , l.s_create_by ";
        $strSql .= " from tb_logs l ";
        $strSql .= " where 1=1 ";
        if ($_d) {
            $strSql .= " AND l.d_create BETWEEN '$info[d_start] 00:00:00' and '$info[d_end] 23:59:00'  ";
        }
        if ($_m) {
            $strSql .= " AND l.s_type = '$info[s_menu]' ";
        }
        if ($_a) {
            $strSql .= " AND l.s_action = '$info[s_action]' ";
        }
        if ($_u) {
            $strSql .= " AND l.s_create_by like '%$info[username]%' ";
        }
        if ($_o) {
            $strSql .= " AND l.s_data like '%$info[other]%' ";
        }
        $strSql .= " order by l.d_create desc ";

        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
