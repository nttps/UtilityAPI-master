<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new registerController();
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
    case "sendmail":
        echo $controller->sendmail($info);
        break;
}

class registerController {

    public function __construct() {
        require_once('../common/Logs.php');
    }

    public function sendmail($info) {

        include '../common/phpmailer.php';
        include '../common/Utility.php';
        if ($this->isValidSendMail($info) == 1) {


            $util = new Utility();
            $mail = new PHPMailer(TRUE);
//            $util->CopyTemplatedMail("../email/Email_Register.html", "../email/Email_Register_Temp.html", $info[detail]);
            $util->CopyTemplatedMailForgot("../email/Email_Register.html", "../email/Email_Register_Temp.html", $info['s_firstname'], $info['s_lastname'], $info['s_username'], $info['s_password']);
            $body = $mail->getFile('../email/Email_Register_Temp.html');

            $mail->Host = "VPSB17.socsets.com";
            $mail->Hostname = "expwebdesign.com";
            $mail->Port = 143;
            $mail->CharSet = 'utf-8';
            $mail->From = "noreply@expwebdesign.com";
            $mail->FromName = "EXPWEBDESIGN";
            $mail->Subject = "Register Website Expwebdesign.com Completed.";
            $mail->MsgHTML($body);
            $mail->AddAddress($info[s_email]);
            $mailcommit = $mail->Send();

            array_map('unlink', glob("../email/tmp_img/*.jpg"));
            array_map('unlink', glob("../email/tmp_img/*.JPG"));
            array_map('unlink', glob("../email/tmp_img/*.png"));
            array_map('unlink', glob("../email/tmp_img/*.PNG"));
            echo $_SESSION['cd_0000'];
        }
    }

    public function dataTable() {
        include '../service/registerService.php';
        $service = new registerService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/registerService.php';
        require_once('../common/ConnectDB.php');
        $log = new Logs();
        $db = new ConnectDB();
        $db->conn();
        $log->saveBefore_by_Transaction($db, "REGISTER", "DELETE", $seq);
        $service = new registerService();
        if ($service->delete($db, $seq)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function deleteAll($info) {
        if ($info[data] == NULL) {
            echo $_SESSION['cd_2005'];
        } else {
            include '../service/registerService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new registerService();
            $query = $util->arr2strQuery($info[data], "I");
            $log = new Logs();
            foreach ($info[data] as $value) {
                $log->saveBefore_by_Transaction($db, "REGISTER", "DELETE", $value);
            }
            if ($service->deleteAll($db, $query)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function getInfo($seq) {
        include '../service/registerService.php';
        include '../common/Utility.php';
        $util = new Utility();
        $service = new registerService();
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

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/registerService.php';
            require_once('../common/ConnectDB.php');
            $log = new Logs();
            $db = new ConnectDB();
            $db->conn();
            $service = new registerService();
            $utils = new Utility();
            $info[d_date] = $utils->DateSQL($info[d_date]);
            if ($info[status] == "APPR") {
                $valid = $service->validUser($db, $info);
                if ($valid[0][cnt] != "0") {
                    echo $_SESSION['cd_2007'];
                    return;
                }
            }

            if ($service->add($db, $info)) {
                $log->saveAfter_by_Transaction($db, "REGISTER", "INSERT", NULL);
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            $log = new Logs();
            include '../service/registerService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new registerService();
            $utils = new Utility();
            $info[d_date] = $utils->DateSQL($info[d_date]);
            $log->saveBefore_by_Transaction($db, "REGISTER", "UPDATE", $info[id]);
            if ($info[status] == "APPR") {
                $valid = $service->validUser($db, $info);
                if ($valid[0][cnt] != "0") {
                    echo $_SESSION['cd_2007'];
                    return;
                }
            }


            if ($service->edit($db, $info)) {
                $log->saveAfter_by_Transaction($db, "REGISTER", "UPDATE", $info[id]);
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
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
//        }  else if ($util->isEmpty($info[s_line])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_line'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[i_bank])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_bank'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_account_name])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_account_name'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_account_no])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_account_no'], $return2099);
            echo $return2099;
        } else if (!$util->isAccountNo($info[s_account_no])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_account_no'], $return2097);
            echo $return2097;
//        } else if ($util->isEmpty($info[i_seo])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_seo'], $return2099);
//            echo $return2099;
//        } else if ($util->isEmpty($info[i_time])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_time'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[status])) {
            $return2099 = eregi_replace("field", $_SESSION['label_status'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_security])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2099);
            echo $return2099;
        } else if (!$util->isSecurity($info[s_security])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2097);
            echo $return2097;
        } else if ($util->isEmpty($info[s_username])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username'], $return2099);
            echo $return2099;
//        } else if ($util->isEmpty($info[s_password])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_password'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[f_amount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_dp_amount'], $return2003);
            echo $return2003;
        } else if (!is_numeric($info[f_amount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_dp_amount'], $return2003);
            echo $return2003;
        } else if ($info[f_amount] < 0) {
            echo $_SESSION['cd_2220'];
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    function isValidSendMail($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        $util = new Utility();
        if ($info[status] == "APPR") {
            if ($util->isEmpty($info[s_firstname])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_cs_firstname'], $return2099);
                echo $return2099;
            } else if ($util->isEmpty($info[s_lastname])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_cs_lastname'], $return2099);
                echo $return2099;
            } else if ($util->isEmpty($info[s_username])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_cs_username'], $return2099);
                echo $return2099;
//            } else if ($util->isEmpty($info[s_password])) {
//                $return2099 = eregi_replace("field", $_SESSION['lb_cs_password'], $return2099);
//                echo $return2099;
            } else if ($util->isEmpty($info[s_email])) {
                $return2099 = eregi_replace("field", $_SESSION['lb_cs_email'], $return2099);
                echo $return2099;
            } else if (!filter_var($info[s_email], FILTER_VALIDATE_EMAIL)) {
                echo $_SESSION['cd_2006'];
            } else {
                $intReturn = TRUE;
            }
        } else {
            $intReturn = FALSE;
        }

        return $intReturn;
    }

}
