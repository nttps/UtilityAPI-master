<?php

@session_start();

class commonCSService {

    function DDLStatus() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'CS' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLGame() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_game where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function DDLFunction() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_function";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function DDLWebsite() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_website where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLBonus() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_special_bonus where s_status = 'A' order by f_bonus asc";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLStatusALL() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'ALL' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLBank() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_master_bank where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLBankDeposit() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select b.i_bank,b.s_bank_no ,b.s_bank_name_th,b.s_bank_name_en,m.s_bank_th,m.s_bank_en,m.s_img from tb_cs_bank b , tb_master_bank m  where m.i_bank = b.i_ref and b.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLBankWidhdraw($info) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "	w.*,  ";
        $strSql .= "	m.s_bank_th,  ";
        $strSql .= "	m.s_bank_en,  ";
        $strSql .= "	m.s_img  ";
        $strSql .= "from  ";
        $strSql .= "	tb_cs_wd w,  ";
        $strSql .= "	tb_master_bank m  ";
        $strSql .= "where  ";
        $strSql .= "	w.i_bank = m.i_bank ";
        $strSql .= "and w.i_wd = $info[id] ";

        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLTime() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_time where s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLSEO() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_seo where s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLChanel() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_chanel where s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPromotion() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_promotion where s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPromotionRG() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_cs_promotion_rg where s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function ValidSecurity($db) {
        $strSql = "select * from tb_cs_user where s_status = 'APPR'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectById($db, $info) {
        $strSql = "SELECT * FROM $info[table] WHERE  $info[field] = '" . $info[id] . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function ValidUserAndSecurity($db, $username, $security) {
        $strSql = "select * from tb_cs_user where s_status = 'APPR'  ";
        $strSql .= " and s_username = '$username'  ";
        if ($security != NULL) {
            $strSql .= " and s_security = '$security'  ";
        }
        $_data = $db->Search_Data_FormatJson($strSql);


        if ($_data != NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
