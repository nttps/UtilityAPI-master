<?php

@session_start();
date_default_timezone_set('Asia/Bangkok');

class Logs {

    private $_refKey;

    public function __construct() {
        $this->_refKey = date("YmdHis");
    }

    function ReadJSON($_json) {
        $json = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $_json), true);
        return $json;
    }

    function WriteJSON($_object) {
        $jsonString = json_encode($_object,JSON_UNESCAPED_UNICODE);
        if ($jsonString == NULL) {
            $jsonString = "";
        }
        return $jsonString;
    }

    function saveBefore_by_Transaction($db, $type, $action, $id) {
        $strSql = $this->SQL_Before($type, $id);
        $_object = $db->Search_Data_FormatJson($strSql);
        $sqlLogs = $this->SQL_InsertLogs($db, $type, $action, $this->WriteJSON($_object));
        $arr = array(
            array("query" => "$sqlLogs")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function saveAfter_by_Transaction($db, $type, $action, $id) {
        $strSql = $this->SQL_After($type, $action, $id);
        $_object = $db->Search_Data_FormatJson($strSql);
        $sqlLogs = $this->SQL_InsertLogs($db, $type, $action, $this->WriteJSON($_object));
        $arr = array(
            array("query" => "$sqlLogs")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SQL_Before($type, $id) {
        if ($type == "DEPOSIT") {
            $str = " select * from tb_cs_dp where i_dp = $id ";
        } else if ($type == "WITHDRAW") {
            $str = " select * from tb_cs_wd where i_wd = $id ";
        } else if ($type == "REGISTER") {
            $str = " select * from tb_cs_user where i_user = $id ";
        }
        return $str;
    }

    function SQL_After($type, $action, $id) {
        $str = "";
        if ($action == "UPDATE") {
            if ($type == "DEPOSIT") {
                $str = " select * from tb_cs_dp where i_dp = $id ";
            } else if ($type == "WITHDRAW") {
                $str = " select * from tb_cs_wd where i_wd = $id ";
            } else if ($type == "REGISTER") {
                $str = " select * from tb_cs_user where i_user = $id ";
            }
        } else if ($action == "INSERT") {
            if ($type == "DEPOSIT") {
                $str = " select * from tb_cs_dp order by i_dp desc limit 1 ";
            } else if ($type == "WITHDRAW") {
                $str = " select * from tb_cs_wd order by i_wd desc limit 1 ";
            } else if ($type == "REGISTER") {
                $str = " select * from tb_cs_user order by i_user desc limit 1 ";
            }
        }
        return $str;
    }

    function SQL_InsertLogs($db, $type, $action, $json) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_logs( ";
        $strSql .= "    s_type, ";
        $strSql .= "    s_ref, ";
        $strSql .= "    s_action, ";
        $strSql .= "    s_data, ";
        $strSql .= "    d_create, ";
        $strSql .= "    s_create_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$type', ";
        $strSql .= "  '$this->_refKey', ";
        $strSql .= "  '$action', ";
        $strSql .= "  '$json', ";
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";

        return $strSql;
    }

}
