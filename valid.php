<?php

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Asia/Bangkok');
error_reporting(0);
flush();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

//$info = array();
//$info[func] = "menu";
//$info[domain] = "www.nagieos.com";
//$info[license] = "nagieos";

$controller = new valid();
switch ($info[func]) {
    case "valid":
        echo $controller->validate($info);
        break;
    case "menu":
        echo $controller->menu($info);
        break;
}

class valid {

    //put your code here
    public function __construct() {
        require_once './common/Utility.php';
    }

    function validate($info) {
        if ($this->valid($info) == 1) {


            $level = $this->getValueLicense($info);
            $result = array(
                'level' => $level
            );
            return json_encode($result);
        }
    }

    function menu($info) {
        if ($this->valid($info) == 1) {
            $menu = $this->getValueLicenseMenu($info);
            $result = array(
                'menu' => $menu
            );
            return json_encode($result);
        }
    }

    function valid($info) {
        $intReturn = 0;
        $valid = new Utility();
        if ($valid->isEmpty($info[domain])) {
            echo "1000,LicenseKey not Verify.";
        } else if ($valid->isEmpty($info[license])) {
            echo "1001,Function not Verify.";
        } else {
            $intReturn = 1;
        }
        return $intReturn;
    }

    public function getValueLicense($info) {
        $info2 = array();
        $info2[domain] = $info[domain];
        $info2[license] = $info[license];
        require_once './adm/common/ConnectDB.php';
        require_once './adm/controller/licenseController.php';
        require_once './adm/service/licenseService.php';
        $db = new ConnectDB();
        $_controller = new licenseController();
        $_data = json_decode($_controller->checkLicense($db, new licenseService(), $info2), true);

        if ($_data != NULL) {
            return $_data[0]['s_function'];
        } else {
            return "LV1";
        }
    }

    public function getValueLicenseMenu($info) {
        $info2 = array();
        $info2[domain] = $info[domain];
        $info2[license] = $info[license];
        require_once './adm/common/ConnectDB.php';
        require_once './adm/controller/licenseController.php';
        require_once './adm/service/licenseService.php';
        $db = new ConnectDB();
        $_controller = new licenseController();  
        $_data = json_decode($_controller->checkLicense($db, new licenseService(), $info2), true);

        $kbank = 'N';
        $scb = 'N';
        $bbl = 'N';
        $ktb = 'N';
        $bay = 'N';


        if ($_data != NULL) {
            $kbank = $_data[0]['s_kbank'];
            $scb = $_data[0]['s_scb'];
            $bbl = $_data[0]['s_bbl'];
            $ktb = $_data[0]['s_ktb'];
            $bay = $_data[0]['s_bay'];
        }

        $result = array(
            'kbank' => $kbank,
            'scb' => $scb,
            'bbl' => $bbl,
            'ktb' => $ktb,
            'bay' => $bay
        );


        return json_encode($result);
    }

    public function convertDateSort($date) {
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        return $yyyy . "/" . $mm . "/" . $dd;
    }

}
