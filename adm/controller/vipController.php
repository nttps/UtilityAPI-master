<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


//$func = ($info[func]!=null?$info[func]:$info[func2]);

$controller = new vipController();
switch ($info[func]) {
    case "import":
        echo $controller->import($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
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
}

class vipController {

    public function dataTable() {
        include '../service/vipService.php';
        $service = new vipService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function add($info) {
        if ($this->isValidAdd($info)) {
            include '../service/vipService.php';
            require_once('../common/ConnectDB.php');
            $duppMain = FALSE;
            $db = new ConnectDB();
            $db->conn();
            $service = new vipService();

            if ($this->getCountSubValid($info) < 4) {
                echo $_SESSION['cd_2219'];
                return;
            }


            if ($service->validMain($db, $info[s_main])) {
                echo $_SESSION['cd_2215'];
                return;
            }

            $arrDuplicate = array();

//            for ($i = 1; $i <= $this->getCountSub($info); $i++) {
            $subCnt = 0;
            foreach ($info as $subVal) {
                $subCnt++;
                if ($subCnt < 4) {
                    continue;
                }
                if ($subVal != "" && $subVal != NULL) {
                    array_push($arrDuplicate, $subVal);
                    if ($service->validSub($db, $subVal)) {
                        $userMain = $service->selectMain($db, $subVal);
                        $return2216 = $_SESSION['cd_2216'];
                        $return2216 = eregi_replace("field", $subVal, $return2216);
                        $return2216 = eregi_replace("f1", $userMain, $return2216);
                        echo $return2216;
                        return;
                    }

                    if ($info[s_main] == $subVal) {
                        $duppMain = TRUE;
                    }
                }
            }
//            }

            if ($duppMain) {
                echo $_SESSION['cd_2218'];
                return;
            }

            if (count(array_unique($arrDuplicate)) < count($arrDuplicate)) {
                echo $_SESSION['cd_2217'];
                return;
            }


            if ($service->add($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function edit($info) {

        include '../service/vipService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new vipService();

        $arrDuplicate = array();
        $subCnt = 0;
        foreach ($info as $subVal) {
            $subCnt++;
            if ($subCnt < 4) {
                continue;
            }
//        for ($i = 1; $i <= $this->getCountSub($info); $i++) {
            if ($subVal != "" && $subVal != NULL) {

                array_push($arrDuplicate, $subVal);
                if ($service->validSubEdit($db, $subVal, $info[s_main])) {
                    $userMain = $service->selectMainEdit($db, $subVal, $info[s_main]);
                    $return2216 = $_SESSION['cd_2216'];
                    $return2216 = eregi_replace("field", $subVal, $return2216);
                    $return2216 = eregi_replace("f1", $userMain, $return2216);
                    echo $return2216;
                    return;
                }

                if ($info[s_main] == $subVal) {
                    $duppMain = TRUE;
                }
            }
//        }
        }

        if ($duppMain) {
            echo $_SESSION['cd_2218'];
            return;
        }

        if (count(array_unique($arrDuplicate)) < count($arrDuplicate)) {
            echo $_SESSION['cd_2217'];
            return;
        }


        if ($service->edit($db, $info)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function delete($seq) {
        include '../service/vipService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new vipService();
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
            include '../service/vipService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new vipService();
            $query = $util->arr2strQuery($info[data], "S");
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
        include '../service/vipService.php';
        $service = new vipService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function import($info) {
        if ($this->isValidImport($info)) {
            include '../service/vipService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new vipService();
            if ($service->import($db, $_FILES["file_excel"])) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function isValidImport($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        include '../common/Utility.php';
        $util = new Utility();
        if (($_FILES["file_excel"]["error"] == 4 || $_FILES["file_excel"] == NULL)) {
            echo $_SESSION['cd_2214'];
        } else {
            $intReturn = TRUE;
        }




        return $intReturn;
    }

    public function isValidAdd($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        include '../common/Utility.php';
        $util = new Utility();
        if ($util->isEmpty($info[s_main])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_main_user'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    public function getCountSub($info) {
        return count($info) - 3;
    }

    public function getCountSubValid($info) {
        return count($info);
    }

}
