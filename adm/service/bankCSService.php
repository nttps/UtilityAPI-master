<?php

@session_start();

class bankCSService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select b.*,0 f_amount_current ,m.s_bank_th , m.s_bank_en , m.s_img,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_cs_bank b , tb_status s , tb_master_bank m  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    b.i_ref =  m.i_bank ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_bank where i_bank =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_bank WHERE i_bank = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_bank WHERE i_bank in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_cs_bank WHERE i_bank = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_cs_bank WHERE i_bank in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function getAmountCurrent($f_amount_base , $i_bank) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
    
        $strSql = "select IFNULL(sum(f_total),0) amt from tb_cs_dp where s_status = 'APPR' and i_bank = $i_bank";
        $_dp = $db->Search_Data_FormatJson($strSql);

        $strSql = "select IFNULL(sum(f_amount),0) amt from tb_cs_wd where s_status = 'APPR' and i_bank_adm = $i_bank";
        $_wd = $db->Search_Data_FormatJson($strSql);
        $summary = $f_amount_base + ($_dp[0][amt] - $_wd[0][amt]);
        return $summary;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_cs_bank ";
        $strSql .= "set  ";
        $strSql .= "s_bank_no = '$info[s_bank_no]', ";
        $strSql .= "s_bank_name_th = '$info[s_bank_name_th]', ";
//        $strSql .= "s_bank_name_en = '$info[s_bank_name_en]', ";
//        $strSql .= "f_amount = '$info[f_amount]', ";
//        $strSql .= "s_security = $info[s_security], ";
//        $strSql .= "d_dp_date = '$info[d_dp_date]', ";
//        $strSql .= "d_dp_time = '$info[d_dp_time]', ";
//        $strSql .= "i_chanel = '$info[i_chanel]', ";
        $strSql .= "i_ref= '$info[i_bank]', ";
        $strSql .= "f_amount_base= $info[f_amount_base], ";
//        $strSql .= "i_promotion = $info[i_promotion], ";
//        $strSql .= "s_img = $info[s_img], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_bank = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_cs_bank( ";
        $strSql .= "    i_ref, ";
        $strSql .= "    s_bank_no, ";
        $strSql .= "    s_bank_name_th, ";
//        $strSql .= "    s_bank_name_en, ";
        $strSql .= "    f_amount_base, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_bank], ";
        $strSql .= "  '$info[s_bank_no]', ";
        $strSql .= "  '$info[s_bank_name_th]', ";
//        $strSql .= "  '$info[s_bank_name_en]', ";
        $strSql .= "  $info[f_amount_base], ";
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

}
