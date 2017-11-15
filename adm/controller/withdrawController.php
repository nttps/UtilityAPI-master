<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new withdrawController();
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
    case "add":
        echo $controller->add($info);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "findBank":
        echo $controller->findBank($info);
        break;
}

class withdrawController {

    public function __construct() {
        require_once('../common/Logs.php');
        require_once '../service/commonCSService.php';
    }

    public function findBank($info) {
        include '../service/withdrawService.php';
        $service = new withdrawService();
        $_dataTable = $service->findBank($info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function dataTable() {
        include '../service/withdrawService.php';
        $service = new withdrawService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/withdrawService.php';
        require_once('../common/ConnectDB.php');
        $log = new Logs();
        $db = new ConnectDB();
        $db->conn();
        $log->saveBefore_by_Transaction($db, "WITHDRAW", "DELETE", $seq);
        $service = new withdrawService();
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
            include '../service/withdrawService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new withdrawService();
            $query = $util->arr2strQuery($info[data], "I");
            $log = new Logs();
            foreach ($info[data] as $value) {
                $log->saveBefore_by_Transaction($db, "WITHDRAW", "DELETE", $value);
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
        include '../service/withdrawService.php';
        $service = new withdrawService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/withdrawService.php';
            require_once('../common/ConnectDB.php');
            $log = new Logs();
            $db = new ConnectDB();
            $db->conn();
            $log->saveBefore_by_Transaction($db, "WITHDRAW", "UPDATE", $info[id]);
            $service = new withdrawService();

            $valid = new commonCSService();
            if (!$valid->ValidUserAndSecurity($db, $info[s_username], NULL)) {
                echo $_SESSION['cd_2223'];
                return;
            }

            if (!$valid->ValidUserAndSecurity($db, $info[s_username], $info[s_security])) {
                echo $_SESSION['cd_2224'];
                return;
            }

            if ($service->validBankAccount($db, $info)) {
                echo $_SESSION['cd_2225'];
                return;
            }


            if ($service->edit($db, $info)) {
                $log->saveAfter_by_Transaction($db, "WITHDRAW", "UPDATE", $info[id]);
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/withdrawService.php';
            require_once('../common/ConnectDB.php');
            $log = new Logs();
            $db = new ConnectDB();
            $db->conn();
            $service = new withdrawService();

            $valid = new commonCSService();
            if (!$valid->ValidUserAndSecurity($db, $info[s_username], NULL)) {
                echo $_SESSION['cd_2223'];
                return;
            }

            if (!$valid->ValidUserAndSecurity($db, $info[s_username], $info[s_security])) {
                echo $_SESSION['cd_2224'];
                return;
            }
            
            if ($service->validBankAccount($db, $info)) {
                echo $_SESSION['cd_2225'];
                return;
            }


            if ($service->add($db, $info)) {
                $log->saveAfter_by_Transaction($db, "WITHDRAW", "INSERT", NULL);
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
        if ($util->isEmpty($info[s_username])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_security])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2099);
            echo $return2099;
        } else if (!$util->isSecurity($info[s_security])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_security'], $return2097);
            echo $return2097;
//        } else if ($util->isEmpty($info[s_phone])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2099);
//            echo $return2099;
//        } else if (!$util->isPhoneNumber($info[s_phone])) {
//            $return2097 = eregi_replace("field", $_SESSION['lb_cs_phone'], $return2097);
//            echo $return2097;
        } else if (!is_numeric($info[f_amount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_wd_amount'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_account_no]) && $info[func] == "add") {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_account_no'], $return2099);
            echo $return2099;
        } else if (!$util->isAccountNo($info[s_account_no])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_account_no'], $return2097);
            echo $return2097;
        } else if ($util->isEmpty($info[s_account_name])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_account_name'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
