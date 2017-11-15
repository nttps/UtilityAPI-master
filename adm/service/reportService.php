<?php

@session_start();

class reportService {

    function search($info, $_d, $_w, $_u, $_n) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT   ";
        $strSql .= "'DEPOSIT' s_type, ";
        $strSql .= "u.s_username , ";
//        $strSql .= "ws.s_website , ";
        $strSql .= "CONCAT(u.s_firstname, ' ', u.s_lastname) s_fullname, ";
        $strSql .= "d.f_total f_amount, ";
        $strSql .= "d.f_bonus f_bonus, ";
        $strSql .= "d.f_special_bonus f_bonus_special, ";
        $strSql .= "s.s_status, ";
        $strSql .= "s.s_detail_th status_th, ";
        $strSql .= "s.s_detail_en status_en, ";
        $strSql .= "d.d_create ";
        $strSql .= "FROM tb_cs_user u , tb_cs_dp d , tb_status s  ";
//        $strSql .= ", tb_website ws ";
        $strSql .= "WHERE u.s_username = d.s_username ";
        $strSql .= "AND d.s_status = s.s_status ";
//        $strSql .= "AND d.i_web = ws.i_web ";
        if ($_u) {
            $strSql .= "AND u.s_username like '%$info[s_username]%' ";
        }
//        if ($_w) {
//            $strSql .= "AND ws.i_web = $info[i_web] ";
//        }
        if ($_n) {
            $strSql .= "AND CONCAT(u.s_firstname, ' ', u.s_lastname) like '%$info[fullname]%' ";
        }
        if ($_d) {
            $strSql .= "AND d.d_create BETWEEN '$info[d_start] 00:00:00' and '$info[d_end] 23:59:00'  ";
        }
        $strSql .= "UNION ";
        $strSql .= "SELECT   ";
        $strSql .= "'WITHDRAW' s_type, ";
        $strSql .= "u.s_username , ";
//        $strSql .= "ws.s_website , ";
        $strSql .= "CONCAT(u.s_firstname, ' ', u.s_lastname) s_fullname, ";
        $strSql .= "w.f_amount f_amount, ";
        $strSql .= "0 f_bonus, ";
        $strSql .= "0 f_special_bonus, ";
        $strSql .= "s.s_status, ";
        $strSql .= "s.s_detail_th status_th, ";
        $strSql .= "s.s_detail_en status_en, ";
        $strSql .= "w.d_create ";
        $strSql .= "FROM tb_cs_user u , tb_cs_wd w , tb_status s  ";
//        $strSql .= ", tb_website ws ";
        $strSql .= "WHERE u.s_username = w.s_username ";
        $strSql .= "AND w.s_status = s.s_status ";
//        $strSql .= "AND w.i_web = ws.i_web ";
        if ($_u) {
            $strSql .= "AND u.s_username like '%$info[s_username]%' ";
        }
//        if ($_w) {
//            $strSql .= "AND ws.s_website like '%$info[s_website]%' ";
//        }
        if ($_n) {
            $strSql .= "AND CONCAT(u.s_firstname, ' ', u.s_lastname) like '%$info[fullname]%' ";
        }
        if ($_d) {
            $strSql .= "AND w.d_create BETWEEN '$info[d_start] 00:00:00' and '$info[d_end] 23:59:00'  ";
        }
        $strSql .= "order by s_type,d_create desc, s_username ,s_status  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
