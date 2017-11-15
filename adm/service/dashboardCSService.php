<?php

@session_start();

class dashboardCSService {

    function BlockMenu() {
//        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "(select sum(f_amount) from tb_cs_dp where s_status = 'APPR' ) dp_appr  , ";
        $strSql .= "(select count(*) from tb_cs_dp where s_status = 'PEND' ) dp_pend  , ";
        $strSql .= "(select sum(f_amount) from tb_cs_wd where s_status = 'APPR' ) wd_appr  , ";
        $strSql .= "(select count(*) from tb_cs_wd where s_status = 'PEND' ) wd_pend , ";
        $strSql .= "(select count(*) from tb_cs_user where s_status = 'APPR' ) user_appr  , ";
        $strSql .= "(select count(*) from tb_cs_user where s_status = 'PEND' ) user_pend , ";
        $strSql .= "(select IFNULL((dp.f_amount-wd.f_amount),0) from  ";
        $strSql .= "(select sum(f_amount) f_amount from tb_cs_dp where s_status = 'APPR' )  dp , ";
        $strSql .= "(select sum(f_amount) f_amount from tb_cs_wd where s_status = 'APPR' )  wd) total_appr  ,  ";
        $strSql .= "(select IFNULL((dp.f_amount-wd.f_amount),0) from  ";
        $strSql .= "(select sum(f_amount) f_amount from tb_cs_dp where s_status = 'PEND' )  dp , ";
        $strSql .= "(select sum(f_amount) f_amount from tb_cs_wd where s_status = 'PEND' )  wd) total_pend   ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
     function sumDP($condition) {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT IFNULL(sum(f_amount),0) cnt FROM  tb_cs_dp  WHERE s_status = 'APPR' AND DATE_FORMAT(d_create,'%Y-%m-%d') = '$condition' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
     function sumWD($condition) {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT IFNULL(sum(f_amount),0) cnt FROM  tb_cs_wd  WHERE s_status = 'APPR' AND DATE_FORMAT(d_create,'%Y-%m-%d') = '$condition' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
