<?php

@session_start();
class depositService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
 //       $strSql = "select d.*,m.s_img s_img_bank ,m.s_bank_th , m.s_bank_en ,b.s_bank_no,b.s_bank_name_th ,b.s_bank_name_en,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql = "select d.*,m.s_img s_img_bank ,w.s_website , g.s_game , m.s_bank_th , m.s_bank_en ,b.s_bank_no,b.s_bank_name_th ,b.s_bank_name_en,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from tb_cs_dp d , tb_status s , tb_cs_bank b , tb_master_bank m  ";
        $strSql .= "  , tb_website w , tb_cs_game g ";
        $strSql .= " where d.s_status = s.s_status ";
        $strSql .= " and s.s_type = 'CS' ";
        $strSql .= " and d.i_bank = b.i_bank ";
        $strSql .= " and b.i_ref = m.i_bank ";
        $strSql .= " and d.s_first_deposit = 'N' ";
        $strSql .= " and d.i_web = w.i_web ";
        $strSql .= " and d.i_game = g.i_game ";
        $strSql .= " order by d.d_create desc , d.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_dp where i_dp =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_dp WHERE i_dp = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_dp WHERE i_dp in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_cs_dp WHERE i_dp = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_cs_dp WHERE i_dp in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info, $img1) {
//        $strSql = "SELECT * FROM tb_cs_promotion WHERE i_promotion = $info[i_promotion] ";
//        $_data = $db->Search_Data_FormatJson($strSql);
//        $percen = $_data[0][f_percen];
//        $maxbath = $_data[0][f_max_bath];
//
//        if ($info[i_promotion] != 0) {
//            $bonus = $info[f_amount] * ($percen / 100);
//            $total = ($info[f_amount] + $bonus);
//        } else {
//            $bonus = 0;
//            $total = $info[f_amount];
//        }



        if ($img1 == NULL) {
            $img1 = "";
        }
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_cs_dp( ";
        $strSql .= "    s_username, ";
//        $strSql .= "    s_firstname, ";
        $strSql .= "    s_phone, ";
        $strSql .= "    f_amount, ";
        $strSql .= "    f_bonus, ";
        $strSql .= "    f_total, ";
//        $strSql .= "    s_security, ";

        $strSql .= "    d_dp_date, ";
        $strSql .= "    d_dp_time, ";

//        $strSql .= "    i_chanel, ";
        $strSql .= "    i_bank, ";
        $strSql .= "    i_promotion, ";
        $strSql .= "    f_special_bonus, ";
        $strSql .= "    i_web, ";
        $strSql .= "    i_game, ";
        $strSql .= "    s_img, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_username]', ";
//        $strSql .= "  '$info[s_firstname]', ";
        $strSql .= "  '$info[s_phone]', ";
        $strSql .= "  $info[f_amount], ";
        $strSql .= "  $info[f_bonus], ";
        $strSql .= "  $info[f_total], ";
//        $strSql .= "  '$info[s_security]', ";

        $strSql .= "  '$info[d_date]', ";
        $strSql .= "  '$info[d_time]', ";

//        $strSql .= "  $info[i_chanel], ";
        $strSql .= "  $info[i_bank], ";
        $strSql .= "  $info[i_promotion], ";
        $strSql .= "  $info[f_special_bonus], ";
        $strSql .= "  $info[i_web], ";
        $strSql .= "  $info[i_game], ";
        $strSql .= "  '$img1', ";

        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql"),
            array("query" => $this->createSQLPromotion($db, $info))
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info, $img) {



        $strSql = "";
        $strSql .= "update tb_cs_dp ";
        $strSql .= "set  ";
        $strSql .= "s_username = '$info[s_username]', ";
//        $strSql .= "s_firstname = '$info[s_firstname]', ";
        $strSql .= "s_phone = '$info[s_phone]', ";
        $strSql .= "f_amount = $info[f_amount], ";
        $strSql .= "f_bonus = $info[f_bonus], ";
        $strSql .= "f_total = $info[f_total], ";
//        $strSql .= "s_security = $info[s_security], ";
        $strSql .= "d_dp_date = '$info[d_date]', ";
        $strSql .= "d_dp_time = '$info[d_time]', ";
//        $strSql .= "i_chanel = '$info[i_chanel]', ";
        $strSql .= "i_bank = '$info[i_bank]', ";
        $strSql .= "i_promotion = $info[i_promotion], ";
        $strSql .= "f_special_bonus = $info[f_special_bonus], ";
        $strSql .= "i_web = $info[i_web], ";
        $strSql .= "i_game = $info[i_game], ";
        if ($img != NULL) {
            $strSql .= "s_img = '$img', ";
        }
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_dp = $info[id] ";
        $arr = array(
            array("query" => "$strSql"),
            array("query" => $this->createSQLPromotion($db, $info))
        );
        $reslut = $db->insert_for_upadte($arr);
        if ($reslut) {
            $this->reverseUse($db, $info);
        }
        return $reslut;
    }

    public function createSQLPromotion($db, $info) {
        $_data = $this->checkInsertUpdate($db, $info);
        $flgInsert = FALSE;
        if ($_data != NULL) {
            $use = (int) ($_data[0][i_use] + 1);
        } else {
            $flgInsert = TRUE;
            $use = 1;
        }
        if ($flgInsert) {
            $sql = " insert into tb_map_promotion (s_username , i_promotion , i_use)";
            $sql .= " values ";
            $sql .= " ('$info[s_username]',$info[i_promotion],$use) ";
        } else {
            $sql = " update tb_map_promotion set ";
            $sql .= " i_use =  $use ";
            $sql .= " where s_username = '$info[s_username]' and i_promotion = $info[i_promotion] ";
        }
        return $sql;
    }

    public function checkUserPromotion($db, $info) {
        $strSql = "SELECT * FROM tb_cs_promotion WHERE i_promotion = $info[i_promotion] ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $useMax = $_data[0][i_use];
        if ($useMax == 0) {
            return FALSE;
        }

        $strSql = "SELECT * FROM tb_map_promotion WHERE s_username = '$info[s_username]' and i_promotion = $info[i_promotion]";
        $_data = $db->Search_Data_FormatJson($strSql);
        $use = ($_data[0][i_use] != null ? $_data[0][i_use] : 0);

        if ($use < $useMax) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkInsertUpdate($db, $info) {
        $strSql2 = "SELECT * FROM tb_map_promotion WHERE s_username = '$info[s_username]' and i_promotion = $info[i_promotion]";
        $_data = $db->Search_Data_FormatJson($strSql2);
        return $_data;
    }

    public function reverseUse($db, $info) {

        if ($info[func] != "add") {
            if ($info[i_promotion] != $info[tmp_i_promotion]) {
                $sql = " update tb_map_promotion set i_use = i_use-1 where s_username = '$info[s_username]' and i_promotion=$info[tmp_i_promotion] ";
                $arrSQL = array(
                    array("query" => "$sql")
                );
                $reslut = $db->insert_for_upadte($arrSQL);
            }
        }
    }

}
