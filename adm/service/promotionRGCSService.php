<?php

@session_start();

class promotionRGCSService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select p.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_cs_promotion_rg p , tb_status s  ";
        $strSql .= " where    p.s_status =  s.s_status ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_promotion_rg where i_promotion =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_promotion_rg WHERE i_promotion = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_promotion_rg WHERE i_promotion in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_cs_promotion_rg ";
        $strSql .= "set  ";
        $strSql .= "s_detail_th = '$info[s_detail_th]', ";
        $strSql .= "s_detail_en = '$info[s_detail_en]', ";
        $strSql .= "s_condition_th = '$info[s_condition_th]', ";
        $strSql .= "s_condition_en = '$info[s_condition_en]', ";
        $strSql .= "f_percen = $info[f_percen], ";
        $strSql .= "f_max_bath = $info[f_max_bath], ";
//        $strSql .= "f_amount = '$info[f_amount]', ";
//        $strSql .= "s_security = $info[s_security], ";
//        $strSql .= "d_dp_date = '$info[d_dp_date]', ";
//        $strSql .= "d_dp_time = '$info[d_dp_time]', ";
//        $strSql .= "i_chanel = '$info[i_chanel]', ";
//        $strSql .= "i_promotion = $info[i_promotion], ";
//        $strSql .= "s_img = $info[s_img], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_promotion = $info[id] ";
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
        $strSql .= "  tb_cs_promotion_rg ( ";
        $strSql .= "    s_detail_th, ";
        $strSql .= "    s_detail_en, ";
        $strSql .= "    f_percen, ";
        $strSql .= "    f_max_bath, ";
        $strSql .= "    s_condition_th, ";
        $strSql .= "    s_condition_en, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_detail_th]', ";
        $strSql .= "  '$info[s_detail_en]', ";
        $strSql .= "  $info[f_percen], ";
        $strSql .= "  $info[f_max_bath], ";
        $strSql .= "  '$info[s_condition_th]', ";
        $strSql .= "  '$info[s_condition_en]', ";
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
