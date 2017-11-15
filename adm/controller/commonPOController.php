<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commonPOController();
switch ($info[func]) {
    case "DDLStatusALL":
        echo $controller->DDLStatusALL();
        break;
    case "DDLPointion":
        echo $controller->DDLPointion();
        break;
    case "DDLPointionVIDEO":
        echo $controller->DDLPointionVIDEO();
        break;
    case "DDLPointionNEWS":
        echo $controller->DDLPointionNEWS();
        break;
    case "DDLServer":
        echo $controller->DDLServer();
        break;
}

class commonPOController {

    public function DDLStatusALL() {
        include '../service/commonPOService.php';
        $service = new commonPOService();
        $_dataTable = $service->DDLStatusALL();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLPointion() {
        include '../service/commonPOService.php';
        $service = new commonPOService();
        $_dataTable = $service->DDLPointion();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLPointionVIDEO() {
        include '../service/commonPOService.php';
        $service = new commonPOService();
        $_dataTable = $service->DDLPointionVIDEO();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLPointionNEWS() {
        include '../service/commonPOService.php';
        $service = new commonPOService();
        $_dataTable = $service->DDLPointionNEWS();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLServer() {
        include '../service/commonPOService.php';
        $service = new commonPOService();
        $_dataTable = $service->DDLServer();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_sv_media'],
                    'text' => $_dataTable[$key]['s_media_' . $_SESSION["lan"]],
                    'img' => $_dataTable[$key]['s_src_media']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

}
