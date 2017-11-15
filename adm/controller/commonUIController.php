<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commonUIController();
switch ($info[func]) {
    case "DDLStatusALL":
        echo $controller->DDLStatusALL();
        break;
    case "DDLPointion":
        echo $controller->DDLPointion();
        break;
    case "DDLPointionGL":
        echo $controller->DDLPointionGallery();
        break;
    case "DDLType":
        echo $controller->DDLType();
        break;
    case "DDLTypeGL":
        echo $controller->DDLTypeGallery();
        break;
    case "DDLServerSL":
        echo $controller->DDLServerSL();
        break;
    case "DDLServerGL":
        echo $controller->DDLServerGL();
        break;
}

class commonUIController {

    public function DDLStatusALL() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLStatusALL();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLPointion() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLPointion();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLPointionGallery() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLPointionGallery();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLType() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLType();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLTypeGallery() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLTypeGallery();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    

    public function DDLServerSL() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLServerSL();
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
    
    public function DDLServerGL() {
        include '../service/commonUIService.php';
        $service = new commonUIService();
        $_dataTable = $service->DDLServerGL();
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
