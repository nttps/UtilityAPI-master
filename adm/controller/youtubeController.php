<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new youtubeController();
switch ($info[func]) {
    case "getInfo":
        echo $controller->getInfo();
        break;
    case "edit":
        echo $controller->edit($info);
        break;
}

class youtubeController {

    public function getInfo() {
        include '../service/youtubeService.php';
        $service = new youtubeService();
        $_dataTable = $service->getInfo();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/youtubeService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new youtubeService();
            if ($service->edit($db, $info)) {
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
        if ($util->isEmpty($info[url_id])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_po_pass_youtube'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }

        return $intReturn;
    }

}
