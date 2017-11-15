<?php

@session_start();

class commonUIService {

    function DDLStatusALL() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'ALL' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLPointion() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_pointion where s_status = 'A' and s_app = 'CS'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
     function DDLPointionGallery() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_pointion where s_status = 'A' and s_app = 'GL'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }


    function DDLType() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ui_type where s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function DDLTypeGallery() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ui_type where s_status = 'A' and i_type not in (3) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLServerSL() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ui_media where s_status = 'A' and s_media_type = 'SLIDE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function DDLServerGL() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_ui_media where s_status = 'A' and s_media_type = 'GALLERY' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
