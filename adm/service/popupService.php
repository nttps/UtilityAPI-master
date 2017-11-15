<?php

@session_start();

class popupService {

    function getInfo() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ps_popup where s_key = 'POPUP' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function edit($db, $img, $info, $s, $e) {
        $strSql = "";
        $strSql .= "update tb_ps_popup ";
        $strSql .= "set  ";
        if ($img != "" && $img != NULL) {
            $strSql .= "s_img_p1 = '$img', ";
        }
        $strSql .= "s_url = '$info[s_url]', ";
        $strSql .= "d_start = '$s', ";
        $strSql .= "d_end = '$e', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where s_key  = 'POPUP' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
