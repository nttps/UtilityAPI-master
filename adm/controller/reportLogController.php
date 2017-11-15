<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new reportLogController();
switch ($info[func]) {
    case "search":
        echo $controller->search($info);
        break;
}

class reportLogController {

    public function search($info) {
        include '../service/reportLogService.php';
        include '../common/Utility.php';
        $service = new reportLogService();
        $util = new Utility();

        $date = (($util->isEmpty($info[d_date]) && $util->isEmpty($info[d_end])) ? FALSE : TRUE );
        $menu = ($info[s_menu] == "ALL" ? FALSE : TRUE );
        $action = ($info[s_action] == "ALL" ? FALSE : TRUE );
        $user = ($util->isEmpty($info[username]) ? FALSE : TRUE );
        $other = ($util->isEmpty($info[other]) ? FALSE : TRUE );

        if ($date) {
            $info[d_start] = $util->DateSQL($info[d_start]);
            $info[d_end] = $util->DateSQL($info[d_end]);
        }

        $_dataTable = $service->search($info, $date, $menu, $action, $user, $other);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['s_menu'] = $this->getLanguageMenu($_dataTable[$key]['s_menu']);
                $_dataTable[$key]['s_action'] = $this->getLanguageAction( $_dataTable[$key]['s_action']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    function getLanguageMenu($value) {
        if ($value == "REGISTER") {
            return $_SESSION[register];
        } else if ($value == "DEPOSIT") {
            return $_SESSION[deposit];
        } else if ($value == "WITHDRAW") {
            return $_SESSION[withdraw];
        }
    }

    function getLanguageAction($value) {
        if ($value == "INSERT") {
            return $_SESSION[insert];
        } else if ($value == "UPDATE") {
            return $_SESSION[update];
        } else if ($value == "DELETE") {
            return $_SESSION[delete];
        }
    }

}
