<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new dashboardCSController();
switch ($info[func]) {
    case "blockmenu":
        echo $controller->BlockMenu();
        break;
    case "chart":
        echo $controller->chart();
        break;
}

class dashboardCSController {

    public function BlockMenu() {
        $service = new dashboardCSService();
        $_dataTable = $service->BlockMenu();
        if ($_dataTable != NULL) {
            return $_dataTable;
        } else {
            return NULL;
        }
    }

     public function range_date($i) {
        $date = date_create(date("Y-m-d", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'Y-m-d');
    }

    public function sumDP($i) {
        $date = date_create(date("Y-m-d", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        $condition = date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'Y-m-d');
        $service = new dashboardCSService();
        $_data = $service->sumDP($condition);
        return $_data[0][cnt];
    }
    
    public function sumWD($i) {
        $date = date_create(date("Y-m-d", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        $condition = date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'Y-m-d');
        $service = new dashboardCSService();
        $_data = $service->sumWD($condition);
        return $_data[0][cnt];
    }

}
