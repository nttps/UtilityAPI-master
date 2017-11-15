<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new reportController();
switch ($info[func]) {
    case "search":
        echo $controller->search($info);
        break;
}

class reportController {

    public function search($info) {
        include '../service/reportService.php';
        include '../common/Utility.php';
        $service = new reportService();
        $util = new Utility();

        $date = (($util->isEmpty($info[d_date]) && $util->isEmpty($info[d_end])) ? FALSE : TRUE );
//        $web = ($info[i_web] == "ALL" ? FALSE : TRUE );
        $user = ($util->isEmpty($info[s_username]) ? FALSE : TRUE );
        $name = ($util->isEmpty($info[fullname]) ? FALSE : TRUE );

        if ($date) {
            $info[d_start] = $util->DateSQL($info[d_start]);
            $info[d_end] = $util->DateSQL($info[d_end]);
        }

        $_dataTable = $service->search($info, $date, $web, $user, $name);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

}
