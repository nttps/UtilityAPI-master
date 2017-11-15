<?php

@session_start();

class poNewsService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  i.*, ";
        $strSql .= "  s.s_detail_th status_th, ";
        $strSql .= "  s.s_detail_en status_en, ";
        $strSql .= "  p.s_detail_th point_th, ";
        $strSql .= "  p.s_detail_en point_en ";
        $strSql .= "FROM ";
        $strSql .= "  tb_ps_news i, ";
        $strSql .= "  tb_status s, ";
        $strSql .= "  tb_pointion p ";
        $strSql .= "WHERE ";
        $strSql .= "  i.i_pointion = p.i_pointion ";
        $strSql .= " AND i.s_status = s.s_status ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_ps_news where i_news =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_img_p1 img from tb_ps_news ";
        $strSql .= " union ";
        $strSql .= " select s_img_p2 img from tb_ps_news ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_ps_news WHERE i_news = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_ps_news WHERE i_news in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_ps_news WHERE i_news = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_ps_news WHERE i_news in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1, $img2, $img3) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }

        $strSql = "";
        $strSql .= "update tb_ps_news ";
        $strSql .= "set  ";
        $strSql .= "    i_pointion=$info[i_pointion], ";
        $strSql .= "    s_img_p1='$img1', ";
        $strSql .= "    s_img_p2='$img2', ";
        $strSql .= "    s_link='$info[s_link]', ";
        $strSql .= "    i_index=$info[i_index], ";
        $strSql .= "    s_subject_th='$info[s_subject_th]', ";
        $strSql .= "    s_subject_en='$info[s_subject_en]', ";
        $strSql .= "    s_detail_th='$info[s_detail_th]', ";
        $strSql .= "    s_detail_en='$info[s_detail_en]', ";

        $strSql .= "    i_view=$info[i_view], ";
        $strSql .= "    i_vote=$info[i_vote], ";


        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_news = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info, $img1, $img2, $img3) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }
        if ($img3 == NULL) {
            $img3 = "";
        }


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_ps_news( ";
        $strSql .= "    i_pointion, ";
        $strSql .= "    s_img_p1, ";
        $strSql .= "    s_img_p2, ";
        $strSql .= "    s_link, ";
        $strSql .= "    i_index, ";
        $strSql .= "    s_subject_th, ";
        $strSql .= "    s_subject_en, ";
        $strSql .= "    s_detail_th, ";
        $strSql .= "    s_detail_en, ";

        $strSql .= "    i_view, ";
        $strSql .= "    i_vote, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_pointion], ";
        $strSql .= "  '$img1', ";
        $strSql .= "  '$img2', ";
        $strSql .= "  '$info[s_link]', ";
        $strSql .= "  $info[i_index], ";
        $strSql .= "  '$info[s_subject_th]', ";
        $strSql .= "  '$info[s_subject_en]', ";
        $strSql .= "  '$info[s_detail_th]', ";
        $strSql .= "  '$info[s_detail_en]', ";

        $strSql .= "  $info[i_view], ";
        $strSql .= "  $info[i_vote], ";


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

}
