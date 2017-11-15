<?php

@session_start();

class licenseService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select  ";
        $strSql .= "	d.*,  ";
        $strSql .= "	f.s_th , f.s_en ,  ";
        $strSql .= "	s.s_detail_th status_th,  ";
        $strSql .= "	s.s_detail_en status_en  ";
        $strSql .= "from  ";
        $strSql .= "	tb_license d,  ";
        $strSql .= "	tb_status s,  ";
        $strSql .= "	tb_function f ";
        $strSql .= "where  ";
        $strSql .= "	d.s_status = s.s_status  ";
        $strSql .= "	and s.s_type = 'ALL'  ";
        $strSql .= "    and d.s_function = f.s_function  ";
        $strSql .= "order by d.d_create desc , d.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_license where i_license =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getDataById($db, $info) {

        $info[domain] = str_replace("'", "", $info[domain]);
        $info[license] = str_replace("'", "", $info[license]);

        $strSql = " select * from tb_license where s_domain ='" . $info[domain] . "' and s_license_key = '$info[license]' and s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_license WHERE i_license = " . $seq . " ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_license WHERE i_license in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_license ( ";
        $strSql .= "    s_domain, ";
        $strSql .= "    s_license_key, ";
        $strSql .= "    s_function, ";
        $strSql .= "    s_kbank, ";
        $strSql .= "    s_scb, ";
        $strSql .= "    s_bbl, ";
        $strSql .= "    s_ktb, ";
        $strSql .= "    s_bay, ";
        $strSql .= "    s_truewallet, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_domain]', ";
        $strSql .= "  '$info[s_license_key]', ";
        $strSql .= "  '$info[s_function]', ";

        $strSql .= "  '$info[kbank]', ";
        $strSql .= "  '$info[scb]', ";
        $strSql .= "  '$info[bbl]', ";
        $strSql .= "  '$info[ktb]', ";
        $strSql .= "  '$info[bay]', ";
        $strSql .= "  '$info[truewallet]', ";

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
        $strSql .= "update tb_license ";
        $strSql .= "set  ";
        $strSql .= "s_domain = '$info[s_domain]', ";
        $strSql .= "s_license_key = '$info[s_license_key]', ";
        $strSql .= "s_function = '$info[s_function]', ";
        $strSql .= "s_kbank = '$info[kbank]', ";
        $strSql .= "s_scb = '$info[scb]', ";
        $strSql .= "s_bbl = '$info[bbl]', ";
        $strSql .= "s_ktb = '$info[ktb]', ";
        $strSql .= "s_bay = '$info[bay]', ";
        $strSql .= "s_truewallet = '$info[truewallet]', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_license = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
