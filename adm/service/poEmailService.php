<?php


class poEmailService {

    function getListEmail() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $sql = " select * from tb_cs_user where s_status = 'APPR' and s_flg_email = 'Y' ";

        $_data = $db->Search_Data_FormatJson($sql);
        $db->close_conn();
        return $_data;
    }

}
