<?php

@session_start();

class uiGalleryService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  sl.*, ";
        $strSql .= "  s.s_detail_th status_th, ";
        $strSql .= "  s.s_detail_en status_en, ";
        $strSql .= "  p.s_detail_th point_th, ";
        $strSql .= "  p.s_detail_en point_en, ";
        $strSql .= "  t.s_type_th, ";
        $strSql .= "  t.s_type_en, ";
        $strSql .= "  m.s_media_th, ";
        $strSql .= "  m.s_media_en ";
        $strSql .= "FROM ";
        $strSql .= "  tb_ui_gallery sl, ";
        $strSql .= "  tb_status s, ";
        $strSql .= "  tb_ui_type t, ";
        $strSql .= "  tb_ui_media m, ";
        $strSql .= "  tb_pointion p ";
        $strSql .= "WHERE ";
        $strSql .= "  sl.i_pointion = p.i_pointion AND sl.i_type = t.i_type AND sl.i_sv_media = m.i_sv_media AND sl.i_sv_media IS NOT NULL AND sl.s_status = s.s_status ";
        $strSql .= "UNION ";
        $strSql .= "SELECT ";
        $strSql .= "  sl.*, ";
        $strSql .= "  s.s_detail_th status_th, ";
        $strSql .= "  s.s_detail_en status_en, ";
        $strSql .= "  p.s_detail_th point_th, ";
        $strSql .= "  p.s_detail_en point_en, ";
        $strSql .= "  t.s_type_th, ";
        $strSql .= "  t.s_type_en, ";
        $strSql .= "  '' s_media_th, ";
        $strSql .= "  '' s_media_en ";
        $strSql .= "FROM ";
        $strSql .= "  tb_ui_gallery sl, ";
        $strSql .= "  tb_status s, ";
        $strSql .= "  tb_ui_type t, ";
        $strSql .= "  tb_pointion p ";
        $strSql .= "WHERE ";
        $strSql .= "  sl.i_pointion = p.i_pointion AND sl.i_type = t.i_type AND sl.i_sv_media IS NULL AND sl.s_status = s.s_status ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_ui_gallery where i_gallery =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_img_p1 img from tb_ui_gallery ";
        $strSql .= "union ";
        $strSql .= "select s_img_p2 img from tb_ui_gallery ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_ui_gallery WHERE i_gallery = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_ui_gallery WHERE i_gallery in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_ui_gallery WHERE i_gallery = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_ui_gallery WHERE i_gallery in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1, $img2) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }

        $strSql = "";
        $strSql .= "update tb_ui_gallery ";
        $strSql .= "set  ";
        $strSql .= "    i_pointion=$info[i_pointion], ";
        $strSql .= "    i_type=$info[i_type], ";
        $strSql .= "    i_index=$info[i_index], ";
        $strSql .= "    s_desc_th='$info[s_desc_th]', ";
        $strSql .= "    s_desc_en='$info[s_desc_en]', ";

        if ($info[i_type] == "1") {
            $strSql .= "    i_sv_media=$info[i_sv_media], ";
            $strSql .= "    s_src_media='$info[s_src_media]', ";
            $strSql .= "    s_img_p1='$img1', ";
            $strSql .= "    s_img_p2='', ";
        } else if ($info[i_type] == "2") {
            $strSql .= "    i_sv_media=NULL, ";
            $strSql .= "    s_src_media='', ";
            $strSql .= "    s_img_p1='$img1', ";
            $strSql .= "    s_img_p2='$img2', ";
        }

        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_gallery = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info, $img1, $img2) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_ui_gallery( ";
        $strSql .= "    i_pointion, ";
        $strSql .= "    i_type, ";
        $strSql .= "    i_index, ";
        $strSql .= "    s_desc_th, ";
        $strSql .= "    s_desc_en, ";

        if ($info[i_type] == "1") {
            $strSql .= "    i_sv_media, ";
            $strSql .= "    s_src_media, ";
            $strSql .= "    s_img_p1, ";
        } else if ($info[i_type] == "2") {
            $strSql .= "    s_img_p1, ";
            $strSql .= "    s_img_p2, ";
        }

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_pointion], ";
        $strSql .= "  '$info[i_type]', ";
        $strSql .= "  '$info[i_index]', ";
        $strSql .= "  '$info[s_desc_th]', ";
        $strSql .= "  '$info[s_desc_en]', ";

        if ($info[i_type] == "1") {
            $strSql .= "  '$info[i_sv_media]', ";
            $strSql .= "  '$info[s_src_media]', ";
            $strSql .= "  '$img1', ";
        } else if ($info[i_type] == "2") {
            $strSql .= "  '$img1', ";
            $strSql .= "  '$img2', ";
        }

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
