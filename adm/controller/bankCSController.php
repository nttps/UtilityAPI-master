<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new bankCSController();
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

class bankCSController {

    public function dataTable() {
        include '../service/bankCSService.php';
        $service = new bankCSService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['f_amount_current'] = $service->getAmountCurrent($_dataTable[$key]['f_amount_base'],$_dataTable[$key]['i_bank']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/bankCSService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new bankCSService();
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
            include '../service/bankCSService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new bankCSService();
            $query = $util->arr2strQuery($info[data], "I");
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
        include '../service/bankCSService.php';
        $service = new bankCSService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/bankCSService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new bankCSService();
            if ($service->edit($db, $info)) {
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
            include '../service/bankCSService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new bankCSService();
            if ($service->add($db, $info)) {
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
        if ($util->isEmpty($info[s_bank_no])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_bankno'], $return2099);
            echo $return2099;
        } else if (!$util->isAccountNo($info[s_bank_no])) {
            $return2097 = eregi_replace("field", $_SESSION['lb_cs_bankno'], $return2097);
            echo $return2097;
        } else if ($util->isEmpty($info[s_bank_name_th])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_bank_name_th'], $return2099);
            echo $return2099;
//        } else if ($util->isEmpty($info[s_bank_name_en])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_cs_bank_name_en'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[f_amount_base])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_bank_amt_base'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_amount_base])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_bank_amt_base'], $return2003);
            echo $return2003;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
