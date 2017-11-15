<?php

@session_start();

class registerService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select u.*,s.s_detail_th status_th, s.s_detail_en status_en from tb_cs_user u , tb_status s ";
        $strSql .= "where u.s_status = s.s_status ";
        $strSql .= "and s.s_type = 'CS' ";
        $strSql .= "order by u.d_create desc , u.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select u.*,d.f_amount , d.f_bonus , d.f_total , d.d_dp_date , d.d_dp_time , d.i_bank i_bank_dp , d.i_promotion , d.f_special_bonus,d.i_web , d.i_game ";
        $strSql .= " from tb_cs_user u , tb_cs_dp d where u.i_user =" . $seq;
        $strSql .= " and u.s_ref_deposit = d.s_ref_deposit ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_cs_user where s_username ='" . $info[s_username] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_user != $info[id]  ";
        }
        $strSql .= " and s_status = 'APPR'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_user WHERE i_user = '" . $seq . "' ";

        $strSql = "";
        $strSql .= "delete from tb_cs_dp  ";
        $strSql .= "where s_first_deposit = 'Y' ";
        $strSql .= "AND s_ref_deposit not in ( ";
        $strSql .= "select s_ref_deposit from tb_cs_user where s_status = 'APPR' ";
        $strSql .= ") ";


        $arr = array(
            array("query" => "$strSQL"),
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_user WHERE i_user in ($query) ";

        $strSql = "";
        $strSql .= "delete from tb_cs_dp  ";
        $strSql .= "where s_first_deposit = 'Y' ";
        $strSql .= "AND s_ref_deposit not in ( ";
        $strSql .= "select s_ref_deposit from tb_cs_user where s_status = 'APPR' ";
        $strSql .= ") ";

        $arr = array(
            array("query" => "$strSQL"),
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {
        $ref_deposit = date("YmdHis");
        $ref_friend = "";
        if ($info[i_seo] == "2") {
            $ref_friend = $info[s_friend];
        }

        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_cs_user ( ";
        $strSql .= "    s_firstname, ";
        $strSql .= "    s_lastname, ";
        $strSql .= "    s_phone, ";
        $strSql .= "    s_email, ";
        $strSql .= "    s_line, ";

        $strSql .= "    i_bank, ";
        $strSql .= "    s_account_no, ";
        $strSql .= "    s_account_name, ";
        $strSql .= "    s_username, ";
//        $strSql .= "    s_password, ";
        $strSql .= "    s_security, ";
//        $strSql .= "    i_seo_by, ";
//        $strSql .= "    s_friend, ";
//        $strSql .= "    i_contact_time, ";
        $strSql .= "    s_flg_email, ";

        $strSql .= "    s_ref_deposit, ";

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

        $strSql .= "  $info[i_bank], ";
        $strSql .= "  '$info[s_account_no]', ";
        $strSql .= "  '$info[s_account_name]', ";
        $strSql .= "  '$info[s_username]', ";
//        $strSql .= "  '$info[s_password]', ";
        $strSql .= "  '$info[s_security]', ";
//        $strSql .= "  $info[i_seo], ";
//        $strSql .= "  '$ref_friend', ";
//        $strSql .= "  $info[i_time], ";
        $strSql .= "  '$info[s_flg_email]', ";

        $strSql .= "  '$ref_deposit', ";

        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";






        $strSql2 = "";
        $strSql2 .= "INSERT ";
        $strSql2 .= "INTO ";
        $strSql2 .= "  tb_cs_dp( ";
        $strSql2 .= "    s_username, ";
//        $strSql2 .= "    s_phone, ";
        $strSql2 .= "    i_web, ";
        $strSql2 .= "    i_game, ";
        $strSql2 .= "    f_amount, ";
        $strSql2 .= "    f_bonus, ";
        $strSql2 .= "    f_total, ";
        $strSql2 .= "    s_security, ";
        $strSql2 .= "    d_dp_date, ";
        $strSql2 .= "    d_dp_time, ";
        $strSql2 .= "    i_bank, ";
        $strSql2 .= "    i_promotion, ";
        $strSql2 .= "    f_special_bonus, ";
        $strSql2 .= "    s_ref_deposit, ";
        $strSql2 .= "    s_first_deposit, ";
        $strSql2 .= "    d_create, ";
        $strSql2 .= "    d_update, ";
        $strSql2 .= "    s_create_by, ";
        $strSql2 .= "    s_update_by, ";
        $strSql2 .= "    s_status ";
        $strSql2 .= "  ) ";
        $strSql2 .= "VALUES( ";
        $strSql2 .= "  '$info[s_username]', ";
        $strSql2 .= "  $info[i_web], ";
        $strSql2 .= "  $info[i_game], ";
//        $strSql2 .= "  '$info[s_phone]', ";
        $strSql2 .= "  $info[f_amount], ";
        $strSql2 .= "  $info[f_bonus], ";
        $strSql2 .= "  $info[f_total], ";
        $strSql2 .= "  '$info[s_security]', ";
        $strSql2 .= "  '$info[d_date]', ";
        $strSql2 .= "  '$info[d_time]', ";
        $strSql2 .= "  $info[i_bank_pay], ";
        $strSql2 .= "  $info[i_promotion], ";
        $strSql2 .= "  $info[f_special_bonus], ";
        $strSql2 .= "  '$ref_deposit', ";
        $strSql2 .= "  'Y', ";
        $strSql2 .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql2 .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql2 .= "  '$_SESSION[username]', ";
        $strSql2 .= "  '$_SESSION[username]', ";
        $strSql2 .= "  '$info[status]' ";
        $strSql2 .= ") ";



        $arr = array(
            array("query" => "$strSql"),
            array("query" => "$strSql2")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info) {
        $ref_friend = "";
        if ($info[i_seo] == "2") {
            $ref_friend = $info[s_friend];
        }


        $strSql = "";
        $strSql .= "update tb_cs_user ";
        $strSql .= "set  ";
        $strSql .= "s_firstname = '$info[s_firstname]', ";
        $strSql .= "s_lastname = '$info[s_lastname]', ";
        $strSql .= "s_phone = '$info[s_phone]', ";
        $strSql .= "s_email = '$info[s_email]', ";
        $strSql .= "s_line = '$info[s_line]', ";
        $strSql .= "i_bank = $info[i_bank], ";
        $strSql .= "s_account_no = '$info[s_account_no]', ";
        $strSql .= "s_account_name = '$info[s_account_name]', ";
        $strSql .= "s_username = '$info[s_username]', ";
//        $strSql .= "s_password = '$info[s_password]', ";
        $strSql .= "s_security = '$info[s_security]', ";
//        $strSql .= "i_seo_by = $info[i_seo], ";
//        $strSql .= "s_friend = '$ref_friend', ";
//        $strSql .= "i_contact_time = $info[i_time], ";
        $strSql .= "s_flg_email = '$info[s_flg_email]', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_user = $info[id] ";

        //s_ref_deposit
        $strSql2 = " update tb_cs_dp ";
        $strSql2 .= " set ";
        $strSql2 .= " i_web = $info[i_web], ";
        $strSql2 .= " i_game = $info[i_game], ";
        $strSql2 .= " f_amount = $info[f_amount], ";
        $strSql2 .= " f_bonus = $info[f_bonus], ";
        $strSql2 .= " f_total = $info[f_total], ";
        $strSql2 .= " f_special_bonus = $info[f_special_bonus], ";
        $strSql2 .= " i_bank = $info[i_bank_pay], ";
        $strSql2 .= " i_promotion = $info[i_promotion], ";

        $strSql2 .= " d_dp_date = '$info[d_date]', ";
        $strSql2 .= " d_dp_time = '$info[d_time]' ";
        $strSql2 .= " where s_ref_deposit = '$info[s_ref_deposit]' ";



        $arr = array(
            array("query" => "$strSql"),
            array("query" => "$strSql2")
        );


        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
