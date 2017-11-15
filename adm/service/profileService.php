<?php

@session_start();

class profileService {

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_user where i_user =" . $_SESSION["i_user"];
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_user ";
        $strSql .= "set ";
        $strSql .= "s_firstname= '$info[s_firstname]', ";
        $strSql .= "s_lastname= '$info[s_lastname]', ";
        $strSql .= "s_email= '$info[s_email]', ";
        $strSql .= "s_phone= '$info[s_phone]' ";
        $strSql .= "where i_user =  $_SESSION[i_user]";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function editPassword($db, $info) {
        $strSql = "";
        $strSql .= "update tb_user ";
        $strSql .= "set ";
        $strSql .= "s_pass= '$info[s_pass]' ";
        $strSql .= "where i_user =  $_SESSION[i_user]";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }
    function editPicture($db, $image) {
        $strSql = "";
        $strSql .= " update tb_user ";
        $strSql .= " set ";
        $strSql .= " s_image = '".$image."' ";
        $strSql .= " where i_user =  $_SESSION[i_user]";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function getOldPassword($db) {
        $strSql = " select s_pass from tb_user where i_user =" . $_SESSION["i_user"];
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

}
