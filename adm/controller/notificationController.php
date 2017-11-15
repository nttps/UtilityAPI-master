<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new notificationController();
switch ($info[func]) {
    case "listNotify":
        echo $controller->listNotify();
        break;
}

class notificationController {

    public function listNotify() {
        include '../service/notificationService.php';
        include '../common/Utility.php';
        $service = new notificationService();
        $util = new Utility();
        $_dataTable = $service->listNotify();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['time'] = $util->dateTimeAgo($_dataTable[$key]['time']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

}
