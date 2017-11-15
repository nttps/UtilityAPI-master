<?php

class ConnectDB {

    protected $_host = "localhost";
//    protected $_user = "root";
//    protected $_pass = "";
    protected $_dbname = "cp724538_nagieosinfo";
    protected $_user = "admin_root";
    protected $_pass = "p@ssw0rd1";
//    protected $_dbname = "admin_demo";
    protected $_conn;
    protected $_email_host = "0.0.0.0";
    protected $_email_port = "25";
    protected $_email_charset = "utf-8";
    protected $_web = "info@test.com";

    function Sysdate($sysdate) {
        if ($sysdate) {
            return "now()";
        } else {
            return date('Y-m-d');
        }
    }

    function web_server() {
        return $this->_web;
    }

    function email_host() {
        return $this->_email_host;
    }

    function email_port() {
        return $this->_email_port;
    }

    function email_charset() {
        return $this->_email_charset;
    }

    function host() {
        return $this->_host;
    }

    function user() {
        return $this->_user;
    }

    function pass() {
        return $this->_pass;
    }

    function dbname() {
        return $this->_dbname;
    }
    
    function fortest() {
        return $this->_conn;
    }

    function conn() {
        $this->_conn = @mysql_connect($this->_host, $this->_user, $this->_pass) or die("Cannot Connect DB");
        mysql_select_db($this->_dbname) or die("Cannot Select DB");
        mysql_query("set names utf8");
    }

    function begin() {
        $null = mysql_query("START TRANSACTION", $this->_conn);
        return mysql_query("BEGIN", $this->_conn);
    }

    function Search_Data_FormatJson($strSQL) {
        $this->conn();
        $rs = mysql_query($strSQL);
        $temp = array();
        while ($objResultLeague = mysql_fetch_array($rs)) {
            $temp[] = $objResultLeague;
        }
        $result = json_encode($temp);
        return json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $result), true);

        // Example Search_Data_FormatJson($strSQL);
        //        $db = new ConnectDB();
        //        $sql = "SELECT * from config_email"; //";
        //        $_data = $db->Search_Data_FormatJson($sql);
        //        foreach ($_data as $key => $value) {
        //            echo $key . "=>";
        //            echo $_data[$key]['conf_mail_id'] . " " . $_data[$key]['email_address'] . "<br>";
        //        }
        //        $call->close_conn();
    }

    function insert_for_upadte($sql) {
        $retval = 1;
        $this->begin();

        foreach ($sql as $qa) {
            $result = mysql_query($qa['query'], $this->_conn);
            if ((mysql_affected_rows() == 0 && !$result) || !$result) {
                $retval = 0;
            }
        }


        return ($retval == 0 ? FALSE : TRUE);
        // return mysql_query($sql) or die(mysql_error());
    }

    function close_conn() {
        mysql_close($this->_conn);
    }

    function commit() {
        return mysql_query("COMMIT", $this->_conn);
    }

    function rollback() {
        return mysql_query("ROLLBACK", $this->_conn);
    }

    /**
     * ******************************
     * @param undefined $table
     * @param undefined $data
     * 
     * @return
     */
    //$db->add_db("table",array("field"=>"value")); 
    function add_db($table = "table", $data = "data") {
        global $insert_last_id;
        $key = array_keys($data);
        $value = array_values($data);
        $sumdata = count($key);
        for ($i = 0; $i < $sumdata; $i++) {
            if (empty($add)) {
                $add = "(";
            } else {
                $add = $add . ",";
            }
            if (empty($val)) {
                $val = "(";
            } else {
                $val = $val . ",";
            }
            $add = $add . $key[$i];
            $val = $val . "'" . $value[$i] . "'";
        }
        $add = $add . ")";
        $val = $val . ")";
        $sql = "INSERT INTO " . $table . " " . $add . " VALUES " . $val;
        if (mysql_query($sql)) {
            $insert_last_id = mysql_insert_id();
            return true;
        } else {
            $this->_error();
            return false;
        }
    }

    //$db->update_db("tabel",array("field"=>"value"),"where"); 
    function update_db($table = "table", $data = "data", $where = "where") {
        $key = array_keys($data);
        $value = array_values($data);
        $sumdata = count($key);
        $set = "";
        for ($i = 0; $i < $sumdata; $i++) {
            if (!empty($set)) {
                $set = $set . ",";
            }
            $set = $set . $key[$i] . "='" . $value[$i] . "'";
        }
        $sql = "UPDATE " . $table . " SET " . $set . " WHERE " . $where;
        if (mysql_query($sql)) {
            return true;
        } else {
            $this->_error();
            return false;
        }
    }

    //$db->del("table","where"); 
    function del($table = "table", $where = "where") {
        $sql = "DELETE FROM " . $table . " WHERE " . $where;
        if (mysql_query($sql)) {
            return true;
        } else {
            $this->_error();
            return false;
        }
    }

    //$db->num_rows("table","field","where"); 
    function num_rows($table = "table", $field = "field", $where = "where") {
        if ($where == "") {
            $where = "";
        } else {
            $where = " WHERE " . $where;
        }
        $sql = "SELECT " . $field . " FROM " . $table . $where;
        if ($res = mysql_query($sql)) {
            return mysql_num_rows($res);
        } else {
            $this->_error();
            return false;
        }
    }

    //Query 
    //$res = $db->select_query('SELECT field FROM table WHERE where'); 
    function select_query($sql = "sql") {
        if ($res = mysql_query($sql)) {
            return $res;
        } else {
            $this->_error();
            return false;
        }
    }

    //$res = $db->select_query('SELECT field FROM table WHERE where'); 
    //$rows = $db->rows($res); 
    function rows($sql = "sql") {
        if ($res = mysql_num_rows($sql)) {
            return $res;
        } else {
            $this->_error();
            return false;
        }
    }

    //? array
    function fetch($sql = "sql") {
        if ($res = mysql_fetch_assoc($sql)) {
            return $res;
        } else {
            $this->_error();
            return false;
        }
    }

    //????
    function _error() {
        $this->error[] = mysql_errno();
    }

}

?>