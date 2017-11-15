<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new registerADMController();
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

class registerADMController {

    public function dataTable() {
        include '../service/registerADMService.php';
        $service = new registerADMService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                if ($_dataTable[$key]['s_type'] == "A") {
                    $_dataTable[$key]['s_type'] = $_SESSION[lb_type_admin];
                } else {
                    $_dataTable[$key]['s_type'] = $_SESSION[lb_stype_staff];
                }
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/registerADMService.php';
        include '../common/upload.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new registerADMService();
        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../images/profile/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_image'] != NULL && $arr_img[$key]['s_image'] != "") {
                    if ($arr_img[$key]['s_image'] != "default.png") {
                        $upload->add_FileName($arr_img[$key]['s_image']);
                    }
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
            include '../service/registerADMService.php';
            require_once('../common/ConnectDB.php');
            include '../common/upload.php';
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new registerADMService();
            $query = $util->arr2strQuery($info[data], "I");
            $arr_img = $service->SelectByArray($db, $query);
            if ($service->deleteAll($db, $query)) {
                $upload = new upload();
                $upload->Initial_and_Clear();
                $upload->set_path("../images/profile/");
                foreach ($arr_img as $key => $value) {
                    if ($arr_img[$key]['s_image'] != NULL && $arr_img[$key]['s_image'] != "") {
                        if ($arr_img[$key]['s_image'] != "default.png") {
                            $upload->add_FileName($arr_img[$key]['s_image']);
                        }
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
        include '../service/registerADMService.php';
        $service = new registerADMService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/registerADMService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $doc = new upload();
            $doc->set_path("../images/profile/");
            $db = new ConnectDB();
            $db->conn();
            $service = new registerADMService();
            $valid = $service->validUser($db, $info);

            if ($valid[0][cnt] != "0") {
                echo $_SESSION['cd_2007'];
                return;
            }

            if ($_FILES["s_img"][error] == 0) {
                $doc->add_FileName($_FILES["s_img"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    $utils = new Utility();
                    if ($service->add($db, $info, $tmpDoc[0])) {
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
                if ($service->add($db, $info, 'default.png')) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/registerADMService.php';
            include '../common/upload.php';
            require_once('../common/ConnectDB.php');
            $doc = new upload();
            $doc->set_path("../images/profile/");
            $db = new ConnectDB();
            $db->conn();
            $service = new registerADMService();
            $valid = $service->validUser($db, $info);

            if ($valid[0][cnt] != "0") {
                echo $_SESSION['cd_2007'];
                return;
            }

            if ($_FILES["s_img"][error] == 0) {
                $doc->add_FileName($_FILES["s_img"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    $utils = new Utility();
                    if ($service->edit($db, $info, $tmpDoc[0])) {
                        if ($info[tmp_s_img] != "default.png") {
                            $doc->Initial_and_Clear();
                            $doc->set_path("../images/profile/");
                            $doc->add_FileName($info[tmp_s_img]);

                            if ($doc->deleteFile()) {
                                $db->commit();
                                echo $_SESSION['cd_0000'];
                                $this->setMainSessionCurrent($info, $tmpDoc[0]);
                            } else {
                                $db->rollback();
                                echo $_SESSION['cd_2001'];
                            }
                        } else {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                            $this->setMainSessionCurrent($info, NULL);
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
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                    $this->setMainSessionCurrent($info, NULL);
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    public function setMainSessionCurrent($info, $img) {
        if ($info[s_user] == $_SESSION["username"]) {
            $_SESSION["password"] = $info[s_pass];
            if ($img != NULL) {
                $_SESSION["img_profile"] = $img;
            }
            $_SESSION["full_name"] = $info['s_firstname'] . " " . $info['s_lastname'];
            $_SESSION["perm"] = $info['s_type'];
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        include '../common/Utility.php';
        $util = new Utility();
        if ($util->isEmpty($info[s_firstname])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_firstname'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_lastname])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_lastname'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_phone])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2099);
            echo $return2099;
        } else if (!$util->isPhoneNumber($info[s_phone])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2097);
            echo $return2097;
        } else if ($util->isEmpty($info[s_email])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_email'], $return2099);
            echo $return2099;
        } else if (!filter_var($info[s_email], FILTER_VALIDATE_EMAIL)) {
            echo $_SESSION['cd_2006'];
//        } else if ($util->isEmpty($info[s_line])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_line'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[status])) {
            $return2099 = eregi_replace("field", $_SESSION['label_status'], $return2099);
            echo $return2099;
        } else if ($util->isEmptyReg($info[s_user]) && $info[func] != "edit") {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username'], $return2099);
            echo $return2099;
        } else if ($util->isEmptyReg($info[s_pass])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_password'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
