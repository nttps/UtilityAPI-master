<?php

@session_start();

class notificationService {

    function countNotify() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_user";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function listNotify() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select * from ( ";
        $strSql .= "select 'CS' as 'app' , 'REG' as 'act' , s_status ,'$_SESSION[noti_reg]' as 'text' , d_create as time from tb_cs_user WHERE s_status = 'PEND' ";
        $strSql .= "UNION ALL ";
        $strSql .= "select 'CS' as 'app' , 'DP' as 'act' , s_status  ,'$_SESSION[noti_dp]' as 'text' ,d_create as time from tb_cs_dp  WHERE s_status = 'PEND'  ";
        $strSql .= "UNION ALL ";
        $strSql .= "select 'CS' as 'app' , 'WD' as 'act' ,s_status   ,'$_SESSION[noti_wd]' as 'text' , d_create as time from tb_cs_wd  WHERE s_status = 'PEND' ";
        $strSql .= " ) noti order by time desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
