<?php

@session_start();

class vipService {

    public function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT s_main from tb_cs_user_map group by s_main";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    public function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT * from tb_cs_user_map where s_main='$seq'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function import($db, $fileImport) {
        require_once "../common/excel.php";
        $arrSQL = array();
        $xlsx = new SimpleXLSX($fileImport['tmp_name']);

        list($cols, ) = $xlsx->dimension();
        $sport_firs = "Sports";
        $sport_end = "Sports Total =";
        $sport = FALSE;

        $casino_firs = "Live Casino & Casino Games";
        $casino_end = "Live Casino & Casino Games Total =";
        $casino = FALSE;

        $datestamp = "";
        $i = 1;
        foreach ($xlsx->rows() as $k => $r) {
            $col1 = ( (isset($r[0])) ? $r[0] : NULL );
            $col2 = ( (isset($r[1])) ? $r[1] : NULL );
            if ($k == 0) {
                if ($col1 != NULL) {
                    $datestamp = $this->getDate($col1);
                    continue;
                }
            }



            if ($col1 != NULL) {
                if ($col1 == $sport_end || $col1 == $casino_end) {
                    $sport = FALSE;
                    $casino = FALSE;
                    continue;
                }

                if ($col1 == $sport_firs) {
                    $sport = TRUE;
                    continue;
                }
                if ($col1 == $casino_firs) {
                    $casino = TRUE;
                    continue;
                }

                if ($sport || $casino) {
                    $state = $this->createStatement(
                            $i++, $datestamp, ($sport ? $sport_firs : $casino_firs), ($col1 != NULL ? $col1 : ''), ($col2 != NULL ? $col2 : '')
                    );
                    array_push($arrSQL, $state);
                }
            }
        }
        $reslut = FALSE;
        if (count($arrSQL) > 0) {
            $this->deleteOld($db, $datestamp);
            $reslut = $db->insert_for_upadte($arrSQL);
        }

        return $reslut;
    }

    function createStatement($i, $datestamp, $type, $col1, $col2) {
        $sql = " insert into tb_cs_excel (i_running , s_date_range , s_type , s_user , f_turnover) ";
        $sql .= " values ";
        $sql .= " ($i , '$datestamp' , '$type' , '$col1' , $col2 ) ";
        return array("query" => "$sql");
    }

    function deleteOld($db, $datestamp) {
//        $strSql = "delete from tb_cs_excel where s_date_range = '$datestamp' ";
        $strSql = "delete from tb_cs_excel ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {
        $arrSQL = array();
        $subCnt = 0;
        $index = 1;
        foreach ($info as $subVal) {
            $subCnt++;
            if ($subCnt < 4) {
                continue;
            }
            if ($subVal != "" && $subVal != NULL) {
//        for ($i = 1; $i <= $this->getCountSub($info); $i++) {
                array_push($arrSQL, $this->createStatementAdd($index, $info[s_main], $subVal));
                $index++;
            }
//        }
        }
        if ($arrSQL == NULL) {
            return false;
        }
        $reslut = $db->insert_for_upadte($arrSQL);
        return $reslut;
    }

    function edit($db, $info) {
        $arrSQL = array();
        $index = 1;

        if ($this->delete($db, $info[s_main])) {

            foreach ($info as $subVal) {
                $subCnt++;
                if ($subCnt < 4) {
                    continue;
                }
                if ($subVal != "" && $subVal != NULL) {
//        for ($i = 1; $i <= $this->getCountSub($info); $i++) {
//            array_push($arrSQL, $this->createStatementEdit($index, $info[s_main], $subVal));
                    array_push($arrSQL, $this->createStatementAdd($index, $info[s_main], $subVal));
                    $index++;
                }
//        }
            }
            if ($arrSQL == NULL) {
                return false;
            }

            $reslut = $db->insert_for_upadte($arrSQL);
            return $reslut;
        } else {
            return false;
        }
    }

    function createStatementAdd($i, $main, $sub) {
        $sql = " insert into tb_cs_user_map ( i_index , s_main , s_sub) ";
        $sql .= " values ";
        $sql .= " ($i ,'$main' , '$sub' ) ";
        return array("query" => "$sql");
    }

    function createStatementEdit($i, $main, $sub) {
        $sql = " update tb_cs_user_map ";
        $sql .= " set ";
        $sql .= " s_sub = '$sub' ";
        $sql .= " where i_index = $i and s_main = '$main'";
        return array("query" => "$sql");
    }

    function validMain($db, $s_main) {
        $strSql = "select count(*) cnt from tb_cs_user_map  where s_main = '$s_main' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data[0][cnt] > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function validSub($db, $s_sub) {
        $strSql = "select count(*) cnt from tb_cs_user_map  where s_sub = '$s_sub' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data[0][cnt] > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function selectMain($db, $s_sub) {
        $strSql = "select distinct s_main  from tb_cs_user_map  where s_sub = '$s_sub' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data[0][s_main];
    }

    function validSubEdit($db, $s_sub, $s_main) {
        $strSql = "select count(*) cnt from tb_cs_user_map  where s_sub = '$s_sub' and s_main <> '$s_main' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data[0][cnt] > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function selectMainEdit($db, $s_sub, $s_main) {
        $strSql = "select distinct s_main  from tb_cs_user_map  where s_sub = '$s_sub' and s_main <> '$s_main' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data[0][s_main];
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_user_map WHERE s_main = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_user_map WHERE s_main in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function getDate($txt) {
        $split1 = strpos($txt, '(', 0);
        $split1 = $split1 + 1;
        $txt = substr($txt, $split1);
        $split2 = strpos($txt, ' ~', 0);
        return substr($txt, 0, $split2);
    }

    public function getCountSub($info) {
        return count($info) - 3;
    }

}
