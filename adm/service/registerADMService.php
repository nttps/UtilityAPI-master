<?php

@session_start();

class registerADMService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select u.*,s.s_detail_th status_th, s.s_detail_en status_en from tb_user u , tb_status s ";
        $strSql .= "where u.s_status = s.s_status ";
        $strSql .= "and s.s_type = 'ALL' ";
        $strSql .= "order by u.d_create desc , u.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_user where i_user =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_user where s_user ='" . $info[s_user] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_user != $info[id]  ";
        }
        $strSql .= " and s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_user WHERE i_user = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_user WHERE i_user in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_user WHERE i_user = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_user WHERE i_user in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info, $imgProfile) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_user ( ";
        $strSql .= "    s_firstname, ";
        $strSql .= "    s_lastname, ";
        $strSql .= "    s_phone, ";
        $strSql .= "    s_email, ";
        $strSql .= "    s_line, ";


        $strSql .= "    s_user, ";
        $strSql .= "    s_pass, ";
        $strSql .= "    s_type, ";
        $strSql .= "    s_image, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_firstname]', ";
        $strSql .= "  '$info[s_lastname]', ";
        $strSql .= "  '$info[s_phone]', ";
        $strSql .= "  '$info[s_email]', ";
        $strSql .= "  '$info[s_line]', ";

        $strSql .= "  '$info[s_user]', ";
        $strSql .= "  '$info[s_pass]', ";
        $strSql .= "  '$info[s_type]', ";
        $strSql .= "  '$imgProfile', ";


        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info, $imageProfile) {
        $strSql = "";
        $strSql .= "update tb_user ";
        $strSql .= "set  ";
        $strSql .= "s_firstname = '$info[s_firstname]', ";
        $strSql .= "s_lastname = '$info[s_lastname]', ";
        $strSql .= "s_phone = '$info[s_phone]', ";
        $strSql .= "s_email = '$info[s_email]', ";
        $strSql .= "s_line = '$info[s_line]', ";

        $strSql .= "s_pass = '$info[s_pass]', ";
        $strSql .= "s_type = '$info[s_type]', ";
        
        if ($imageProfile != NULL) {
            $strSql .= "s_image = '$imageProfile', ";
        }
        
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_user = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
