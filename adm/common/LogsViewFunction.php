<?php

@session_start();

function getLanguageMenu($value) {
    if ($value == "REGISTER") {
        return $_SESSION[register];
    } else if ($value == "DEPOSIT") {
        return $_SESSION[deposit];
    } else if ($value == "WITHDRAW") {
        return $_SESSION[withdraw];
    }
}

function getLanguageAction($value) {
    if ($value == "INSERT") {
        return $_SESSION[insert];
    } else if ($value == "UPDATE") {
        return $_SESSION[update];
    } else if ($value == "DELETE") {
        return $_SESSION[delete];
    }
}

function getLanguageStatus($db, $value) {
    $strSql = "select * from tb_status where s_status = '$value' and s_type = 'CS' ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" ? $_data[0][s_detail_th] : $_data[0][s_detail_en]);
}

function getLanguageStatusMail($db, $value) {
    if ($value == NULL) {
        return "";
    }
    return ($value == "Y" ? $_SESSION[lb_status_email_y] : $_SESSION[lb_status_email_n]);
}

function getLanguageWebFind($db, $value) {
    $strSql = "select * from tb_cs_seo where i_seo = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" ? $_data[0][s_detail_th] : $_data[0][s_detail_en]);
}

function getLanguageWebsite($db, $value) {
    $strSql = "select * from tb_website where i_web = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return $_data[0][s_website];
}

function getLanguageGame($db, $value) {
    $strSql = "select * from tb_cs_game where i_game = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return $_data[0][s_game];
}

function getLanguageBank($db, $value) {
    $strSql = "select * from tb_master_bank where i_bank = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" ? $_data[0][s_bank_th] : $_data[0][s_bank_en]);
}

function getLanguagePromotion($db, $value) {
    $strSql = "select * from tb_cs_promotion where i_promotion = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" ? $_data[0][s_detail_th] : $_data[0][s_detail_en]);
}

function getLanguageChanel($db, $value) {
    $strSql = "select * from tb_cs_chanel where i_chanel = $value ";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" ? $_data[0][s_detail_th] : $_data[0][s_detail_en]);
}

function getLanguageBankDeposit($db, $value) {
    $strSql = "select m.*,s.* from tb_master_bank m , tb_cs_bank s where s.i_bank = $value ";
    $strSql .= "and m.i_bank = s.i_ref";
    $_data = $db->Search_Data_FormatJson($strSql);
    if ($_data == NULL) {
        return "";
    }
    return ($_SESSION[lan] == "th" 
            ? $_data[0][s_bank_th]." (".$_data[0][s_bank_name_th]." : " .$_data[0][s_bank_no].")"
            : $_data[0][s_bank_en]." (".$_data[0][s_bank_name_th]." : " .$_data[0][s_bank_no].")"
            );
}

function getUpdateBeforeAfter($db, $ref) {
    $strSql = "select * from tb_logs where s_ref = '$ref' order by i_log asc limit 2";
    $_data = $db->Search_Data_FormatJson($strSql);
    return $_data;
}






