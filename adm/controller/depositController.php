<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new depositController();
switch ($info[func]) {
    case "dataTable":
        echo $controller->dataTable($info);
        break;
    case "delete":
        echo $controller->delete($info[id]);
        break;
    case "deleteAll":
        echo $controller->deleteAll($info);
        break;
    case "getInfo":
        echo $controller->getInfo($info[id]);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
}

class depositController {

    public function __construct() {
        require_once('../common/Logs.php');
        require_once '../service/commonCSService.php';
    }

    public function dataTable() {
        include '../service/depositService.php';
        $service = new depositService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/depositService.php';
        include '../common/upload.php';
        require_once('../common/ConnectDB.php');
        $log = new Logs();
        $db = new ConnectDB();
        $db->conn();
        $log->saveBefore_by_Transaction($db, "DEPOSIT", "DELETE", $seq);
        $service = new depositService();
        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../upload/premise/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_img'] != NULL && $arr_img[$key]['s_img'] != "") {
                    $upload->add_FileName($arr_img[$key]['s_img']);
                }
            }
            if ($upload->deleteFile()) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function deleteAll($info) {
        if ($info[data] == NULL) {
            echo $_SESSION['cd_2005'];
        } else {
            include '../service/depositService.php';
            require_once('../common/ConnectDB.php');
            include '../common/upload.php';
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new depositService();
            $query = $util->arr2strQuery($info[data], "I");
            $log = new Logs();
            foreach ($info[data] as $value) {
                $log->saveBefore_by_Transaction($db, "DEPOSIT", "DELETE", $value);
            }

            $arr_img = $service->SelectByArray($db, $query);
            if ($service->deleteAll($db, $query)) {
                $upload = new upload();
                $upload->Initial_and_Clear();
                $upload->set_path("../upload/premise/");
                foreach ($arr_img as $key => $value) {
                    if ($arr_img[$key]['s_img'] != NULL && $arr_img[$key]['s_img'] != "") {
                        $upload->add_FileName($arr_img[$key]['s_img']);
                    }
                }
                if ($upload->deleteFile()) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function getInfo($seq) {
        include '../service/depositService.php';
        include '../common/Utility.php';
        $util = new Utility();
        $service = new depositService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['d_dp_date'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_dp_date']);
                $_dataTable[$key]['d_dp_time'] = substr($_dataTable[$key]['d_dp_time'], 0, 5);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {

            include '../service/depositService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $log = new Logs();
            $doc = new upload();
            $doc->set_path("../upload/premise/");
            $db = new ConnectDB();
            $db->conn();
            $service = new depositService();

            $utils = new Utility();
            $info[d_date] = $utils->DateSQL($info[d_date]);
            $log->saveBefore_by_Transaction($db, "DEPOSIT", "UPDATE", $info[id]);

            $valid = new commonCSService();
            if (!$valid->ValidUserAndSecurity($db, $info[s_username], NULL)) {
                echo $_SESSION['cd_2223'];
                return;
            }

            if (!$valid->ValidUserAndSecurity($db, $info[s_username], $info[s_security])) {
                echo $_SESSION['cd_2224'];
                return;
            }




//            if ($service->checkUserPromotion($db, $info)) {
//                $return2222 = $_SESSION['cd_2222'];
//                $return2222 = eregi_replace("#user", $info[username], $return2222);
//                echo $return2222;
//                return;
//            }

            if ($_FILES["s_img"][error] == 0) {
                $doc->add_FileName($_FILES["s_img"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    if ($service->edit($db, $info, $tmpDoc[0])) {
                        if ($info[tmp_s_img] != null && $info[tmp_s_img] != "") {
                            $doc->Initial_and_Clear();
                            $doc->set_path("../upload/premise/");
                            $doc->add_FileName($info[tmp_s_img]);
                            if ($doc->deleteFile()) {
                                $log->saveAfter_by_Transaction($db, "DEPOSIT", "UPDATE", $info[id]);
                                $db->commit();
                                echo $_SESSION['cd_0000'];
                                $_SESSION[img_profile] = $tmpDoc[0];
                            } else {
                                $db->rollback();
                                $doc->clearFileAddFail();
                                echo $_SESSION['cd_2001'];
                            }
                        } else {
                            $log->saveAfter_by_Transaction($db, "DEPOSIT", "UPDATE", $info[id]);
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        }
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            } else {
                if ($service->edit($db, $info, NULL)) {
                    $log->saveAfter_by_Transaction($db, "DEPOSIT", "UPDATE", $info[id]);
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/depositService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $log = new Logs();
            $doc = new upload();
            $doc->set_path("../upload/premise/");
            $db = new ConnectDB();
            $db->conn();
            $service = new depositService();

            $utils = new Utility();
            $info[d_date] = $utils->DateSQL($info[d_date]);

            $valid = new commonCSService();
            if (!$valid->ValidUserAndSecurity($db, $info[s_username], NULL)) {
                echo $_SESSION['cd_2223'];
                return;
            }

            if (!$valid->ValidUserAndSecurity($db, $info[s_username], $info[s_security])) {
                echo $_SESSION['cd_2224'];
                return;
            }


            if ($service->checkUserPromotion($db, $info)) {
                $return2222 = $_SESSION['cd_2222'];
                $return2222 = eregi_replace("#user", $info[username], $return2222);
                echo $return2222;
                return;
            }

            if ($_FILES["s_img"][error] == 0) {
                $doc->add_FileName($_FILES["s_img"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();



                    if ($service->add($db, $info, $tmpDoc[0])) {
                        $log->saveAfter_by_Transaction($db, "DEPOSIT", "INSERT", NULL);
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            } else {
                if ($service->add($db, $info, NULL)) {
                    $log->saveAfter_by_Transaction($db, "DEPOSIT", "INSERT", NULL);
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        include '../common/Utility.php';
        $util = new Utility();
//        if ($util->isEmpty($info[s_firstname])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_firstname'], $return2099);
//            echo $return2099;
//        } else 

        if ($util->isEmpty($info[s_username])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username'], $return2099);
            echo $return2099;
//        } else if ($util->isEmpty($info[s_security])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2099);
//            echo $return2099;
//        } else if (!$util->isSecurity($info[s_security])) {
//            $return2097 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2097);
//            echo $return2097;
//        } else if ($util->isEmpty($info[s_phone])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2099);
//            echo $return2099;
//        } else if (!$util->isPhoneNumber($info[s_phone])) {
//            $return2097 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2097);
//            echo $return2097;
        } else if (!is_numeric($info[f_amount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_dp_amount'], $return2003);
            echo $return2003;
        } else if ($info[f_amount] <= 0) {
            echo $_SESSION['cd_2220'];
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
