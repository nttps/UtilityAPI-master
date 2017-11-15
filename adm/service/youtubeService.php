<?php

@session_start();

class youtubeService {

    function getInfo() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ps_youtube where s_key = 'LIVE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_ps_youtube ";
        $strSql .= "set  ";
        $strSql .= "url_id = '$info[url_id]', ";
        $strSql .= "s_status_auto = '$info[status_auto]', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where s_key  = 'LIVE' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
