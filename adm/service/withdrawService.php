<?php

@session_start();

class withdrawService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "	d.*,  ";
        $strSql .= "	m.s_img s_img_bank,  ";
        $strSql .= "	w.s_website,  ";
        $strSql .= "	m.s_bank_th,  ";
        $strSql .= "	m.s_bank_en,  ";
        $strSql .= "	d.s_account_no s_bank_no,  ";
        $strSql .= "	s.s_detail_th status_th,  ";
        $strSql .= "	s.s_detail_en status_en  ";
        $strSql .= "from  ";
        $strSql .= "	tb_cs_wd d,  ";
        $strSql .= "	tb_status s,  ";
        $strSql .= "	tb_website w,  ";
        $strSql .= "	tb_master_bank m  ";
        $strSql .= "where  ";
        $strSql .= "	d.s_status = s.s_status  ";
        $strSql .= "	and s.s_type = 'CS'  ";
        $strSql .= "    and d.i_bank = m.i_bank  ";
        $strSql .= "    and d.i_web = w.i_web  ";
        $strSql .= "order by d.d_create desc , d.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_wd where i_wd =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function findBank($info) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_user where s_username ='" . $info[s_username] . "' limit 1 ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_wd WHERE i_wd = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_wd WHERE i_wd in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_cs_wd WHERE i_wd = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_cs_wd WHERE i_wd in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function validBankAccount($db, $info) {
        $strSql = "SELECT * FROM tb_cs_user WHERE s_username = '$info[s_username]' ";
        $strSql .= " and i_bank = $info[i_bank] and s_account_no = '$info[s_account_no]' ";
        $strSql .= " and s_account_name = '$info[s_account_name]' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data != NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function add($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_cs_wd ( ";
        $strSql .= "    i_web, ";
        $strSql .= "    s_username, ";
//        $strSql .= "    s_phone, ";
        $strSql .= "    f_amount, ";
        $strSql .= "    s_security, ";
        $strSql .= "    i_bank, ";
        $strSql .= "    i_bank_adm, ";
        $strSql .= "    s_account_no, ";
        $strSql .= "    s_account_name, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[i_web]', ";
        $strSql .= "  '$info[s_username]', ";
//        $strSql .= "  '$info[s_phone]', ";
        $strSql .= "  $info[f_amount], ";
        $strSql .= "  '$info[s_security]', ";
        $strSql .= "  $info[i_bank], ";
        $strSql .= "  $info[i_bank_adm], ";
        $strSql .= "  '$info[s_account_no]', ";
        $strSql .= "  '$info[s_account_name]', ";


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

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_cs_wd ";
        $strSql .= "set  ";
        $strSql .= "i_web = '$info[i_web]', ";
        $strSql .= "s_username = '$info[s_username]', ";
//        $strSql .= "s_phone = '$info[s_phone]', ";
        $strSql .= "f_amount = '$info[f_amount]', ";
        $strSql .= "s_security = $info[s_security], ";

        $strSql .= "s_account_no = '$info[s_account_no]', ";
        $strSql .= "s_account_name = '$info[s_account_name]', ";
//        $strSql .= "d_dp_date = '$info[d_dp_date]', ";
//        $strSql .= "d_dp_time = '$info[d_dp_time]', ";
//        $strSql .= "i_chanel = '$info[i_chanel]', ";
        $strSql .= "i_bank = '$info[i_bank]', ";
        $strSql .= "i_bank_adm = '$info[i_bank_adm]', ";
//        $strSql .= "i_promotion = $info[i_promotion], ";
//        $strSql .= "s_img = $info[s_img], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_wd = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
