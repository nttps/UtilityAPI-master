<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new profileController();
switch ($info[func]) {
    case "getInfo":
        echo $controller->getInfo($info[id]);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "editPassowrd":
        echo $controller->editPassword($info);
        break;
    case "editPicture":
        echo $controller->editPicture($info);
        break;
}

class profileController {

    public function getInfo($seq) {
        include '../service/profileService.php';
        $service = new profileService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['s_type'] = ( $_dataTable[$key]['s_type'] == "A" ? $_SESSION['type_admin'] : $_SESSION['type_user']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/profileService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new profileService();
            if ($service->edit($db, $info)) {
                $db->commit();
                $_SESSION["full_name"] = $info['s_firstname'] . " " . $info['s_lastname'];
                $_SESSION["user_email"] = $info['s_email'];
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function editPassword($info) {
        require_once('../common/ConnectDB.php');
        include '../service/profileService.php';
        $service = new profileService();
        $db = new ConnectDB();
        $db->conn();
        if ($this->isValidPassword($info, $db, $service)) {

            if ($service->editPassword($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function editPicture($info) {
        if ($this->isValidPicture($info)) {
            require_once('../common/ConnectDB.php');
            include '../service/profileService.php';
            include '../common/upload.php';

            $service = new profileService();
            $db = new ConnectDB();
            $db->conn();

            $doc = new upload();
            $doc->set_path("../images/profile/");
            $doc->add_FileName($_FILES["s_image"]);
            $flg = $doc->AddFile();
            if ($flg) {
                $tmpDoc = $doc->get_FilenameResult();
                if ($service->editPicture($db, $tmpDoc[0])) {
                    if ($info[old_picture] != "default.png") {
                        $doc->Initial_and_Clear();
                        $doc->set_path("../images/profile/");
                        $doc->add_FileName($info[old_picture]);
                        if ($doc->deleteFile()) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                            $_SESSION[img_profile] = $tmpDoc[0];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFail();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        $db->commit();
                        $_SESSION[img_profile] = $tmpDoc[0];
                        echo $_SESSION['cd_0000'];
                    }
                } else {
                    $doc->clearFileAddFail();
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $doc->clearFileAddFail();
                echo $doc->get_errorMessage();
            }
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
            $return2099 = eregi_replace("field", $_SESSION['lb_pf_name'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_lastname])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_pf_lastname'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_email])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_email'], $return2099);
            echo $return2099;
        } else if (!filter_var($info[s_email], FILTER_VALIDATE_EMAIL)) {
            echo $_SESSION['cd_2008'];
        } else if ($util->isEmpty($info[s_phone])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2099);
            echo $return2099;
        } else if (!$util->isPhoneNumber($info[s_phone])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2097);
            echo $return2097;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    public function isValidPassword($info, $db, $service) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        include '../common/Utility.php';
        $util = new Utility();

        $_data = $service->getOldPassword($db);
        $oldPassword = $_data[0][s_pass];


        if ($util->isEmpty($info[s_pass_old])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_pf_pass_old'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_pass])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_pf_pass'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_pass_confirm])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_pf_pass_confirm'], $return2099);
            echo $return2099;
        } else if ($info[s_pass] != $info[s_pass_confirm]) {
            echo $_SESSION['cd_4102'];
        } else if ($oldPassword != $info[s_pass_old]) {
            echo $_SESSION['cd_4101'];
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    public function isValidPicture($info) {
        $intReturn = 0;
        if ($_FILES["s_image"]["error"] == 4) {
            echo $_SESSION['cd_2207'];
        } else {
            $intReturn = 1;
        }
        return $intReturn;
    }

}
