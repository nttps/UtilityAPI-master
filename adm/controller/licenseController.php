<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new licenseController();
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
}

class licenseController {

    public function __construct() {
        
    }

    public function checkLicense($db, $service, $info) {
        $_dataTable = $service->getDataById($db, $info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function dataTable() {
        include '../service/licenseService.php';
        $service = new licenseService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        include '../service/licenseService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new licenseService();
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
            include '../service/licenseService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new licenseService();
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
        include '../service/licenseService.php';
        $service = new licenseService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/licenseService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $info = $this->setCheckBox($info);
            $service = new licenseService();
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
            include '../service/licenseService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $info = $this->setCheckBox($info);
            $service = new licenseService();
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


        include '../common/Utility.php';
        $util = new Utility();
        if ($util->isEmpty($info[s_domain])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_co_domain'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_license_key])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_co_license'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    public function setCheckBox($info) {
        $info['kbank'] = ($info['kbank'] == NULL ? "N" : "Y");
        $info['scb'] = ($info['scb'] == NULL ? "N" : "Y");
        $info['bbl'] = ($info['bbl'] == NULL ? "N" : "Y");
        $info['ktb'] = ($info['ktb'] == NULL ? "N" : "Y");
        $info['bay'] = ($info['bay'] == NULL ? "N" : "Y");
        $info['truewallet'] = ($info['truewallet'] == NULL ? "N" : "Y");
        return $info;
    }

}
