<?php

class loginService {

    function login($info) {
        include_once '../common/ConnectDB.php';
        $db = new ConnectDB();
        $db->conn();
        $strSQL = "select * from tb_user where s_user = '$info[username]' and s_pass='$info[password]' and s_status = 'A' ";
        $db->Search_Data_FormatJson($strSQL);
        $_data = $db->Search_Data_FormatJson($strSQL);
        if ($_data != NULL) {
            return $_data;
        }
        return NULL;
    }

    function checkEmail($info) {
        include_once '../common/ConnectDB.php';
        $db = new ConnectDB();
        $db->conn();
        $strSQL = "select * from tb_user where s_email = '$info[email]' ";
        $db->Search_Data_FormatJson($strSQL);
        $_data = $db->Search_Data_FormatJson($strSQL);
        if ($_data != NULL) {
            return $_data;
        }
        return NULL;
    }

}
