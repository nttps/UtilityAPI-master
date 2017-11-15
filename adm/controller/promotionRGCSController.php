<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new promotionRGCSController();
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

class promotionRGCSController {

    public function dataTable() {
        include '../service/promotionRGCSService.php';
        $service = new promotionRGCSService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/promotionRGCSService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new promotionRGCSService();
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
            include '../service/promotionRGCSService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new promotionRGCSService();
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
        include '../service/promotionRGCSService.php';
        $service = new promotionRGCSService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/promotionRGCSService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new promotionRGCSService();
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
            include '../service/promotionRGCSService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new promotionRGCSService();
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
        include '../common/Utility.php';
        $util = new Utility();
        if ($util->isEmpty($info[s_detail_th])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_pro_th'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_detail_en])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_pro_en'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[f_percen])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_promotion_bonus'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_percen])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_promotion_bonus'], $return2003);
            echo $return2003;
        }else if ($util->isEmpty($info[f_max_bath])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_promotion_maxbath'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_max_bath])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_cs_promotion_maxbath'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_condition_th])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_pro_condi_th'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_condition_en])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_pro_condi_en'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
