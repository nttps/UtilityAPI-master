<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commonCSController();
switch ($info[func]) {
    case "DDLStatus":
        echo $controller->DDLStatus();
        break;
    case "DDLStatusALL":
        echo $controller->DDLStatusALL();
        break;
    case "DDLBank":
        echo $controller->DDLBank();
        break;
    case "DDLBankDeposit":
        echo $controller->DDLBankDeposit();
        break;
    case "DDLBankWidhdraw":
        echo $controller->DDLBankWidhdraw($info);
        break;
    case "DDLTime":
        echo $controller->DDLTime();
        break;
    case "DDLSEO":
        echo $controller->DDLSEO();
        break;
    case "DDLChanel":
        echo $controller->DDLChanel();
        break;
    case "DDLPromotion":
        echo $controller->DDLPromotion();
        break;
    case "DDLPromotionRG":
        echo $controller->DDLPromotionRG();
        break;
    case "ValidSecurity":
        echo $controller->ValidSecurity($info);
        break;
    case "DDLWebsite":
        echo $controller->DDLWebsite();
        break;
    case "DDLBonus":
        echo $controller->DDLBonus();
        break;
    case "DDLGame":
        echo $controller->DDLGame();
        break;
    case "DDLFunction":
        echo $controller->DDLFunction();
        break;
    
}

class commonCSController {

    public function DDLStatus() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLStatus();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLWebsite() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLWebsite();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    public function DDLFunction() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLFunction();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    public function DDLGame() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLGame();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLBonus() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLBonus();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLStatusALL() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLStatusALL();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLBank() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLBank();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_bank'],
                    'text' => $_dataTable[$key]['s_bank_' . $_SESSION["lan"]],
                    'img' => $_dataTable[$key]['s_img']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLBankDeposit() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLBankDeposit();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_bank'],
                    'text' => $_dataTable[$key]['s_bank_' . $_SESSION["lan"]],
                    'img' => $_dataTable[$key]['s_img'],
                    'name' => $_dataTable[$key]['s_bank_name_' . $_SESSION["lan"]],
                    'no' => $_dataTable[$key]['s_bank_no']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLBankWidhdraw($info) {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLBankWidhdraw($info);
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_bank'],
                    'text' => $_dataTable[$key]['s_bank_' . $_SESSION["lan"]],
                    'img' => $_dataTable[$key]['s_img'],
                    'name' => $_dataTable[$key]['s_account_name'],
                    'no' => $_dataTable[$key]['s_account_no']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function ValidSecurity($info) {
        include '../service/commonCSService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $service = new commonCSService();
        $_data = $service->SelectById($db, $info);
        $_dataTable = $service->ValidSecurity($db);
        $db->close_conn();

        $user = $_SESSION[lb_cs_res_user_null];
        $security = $_SESSION[lb_cs_res_secu_null];
        $phone = $_SESSION[lb_cs_res_phone_null];
        $bank = $_SESSION[lb_cs_res_bank_null];
        $me = FALSE;
        $sh_user = "Y";
        $sh_security = "N";
        $sh_phone = "N";
        $sh_bank = "N";
        $succ_user = "N";
        $succ_security = "N";
        $succ_phone = "N";
        $succ_bank = "N";

        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                if ($_data[0][s_username] == $_dataTable[$key]['s_username']) {
                    $user = $_SESSION[lb_cs_res_user];
                    $me = TRUE;
                    $succ_user = "Y";
                }
            }
            if ($me) {
                $sh_security = "Y";
                $sh_phone = "Y";
                $sh_bank = "Y";
                foreach ($_dataTable as $key => $value) {
                    if ($_data[0][s_security] == $_dataTable[$key]['s_security']) {
                        $security = $_SESSION[lb_cs_res_secu];
                        $succ_security = "Y";
                    }
                    if ($_data[0][s_phone] == $_dataTable[$key]['s_phone']) {
                        $phone = $_SESSION[lb_cs_res_phone];
                        $succ_phone = "Y";
                    }
                    if ($_data[0][i_bank] == $_dataTable[$key]['i_bank'] && $_data[0][s_account_no] == $_dataTable[$key]['s_account_no'] && $_data[0][s_account_name] == $_dataTable[$key]['s_account_name']) {
                        $bank = $_SESSION[lb_cs_res_bank];
                        $succ_bank = "Y";
                    }
                }
            }
            $tmp = array(
                'username' => $user,
                'sh_username' => $sh_user,
                'succ_username' => $succ_user,
                'security' => $security,
                'sh_security' => $sh_security,
                'succ_security' => $succ_security,
                'phone' => $phone,
                'sh_phone' => $sh_phone,
                'succ_phone' => $succ_phone,
                'bank' => $bank,
                'sh_bank' => $sh_bank,
                'succ_bank' => $succ_bank
            );
            $tmpReturn[] = $tmp;
            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLTime() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLTime();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLSEO() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLSEO();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLChanel() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLChanel();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_chanel'],
                    'text' => $_dataTable[$key]['s_detail_' . $_SESSION["lan"]],
                    'img' => $_dataTable[$key]['s_img']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLPromotion() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLPromotion();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function DDLPromotionRG() {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->DDLPromotionRG();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function ValidUserAndSecurity($db, $username, $security) {
        include '../service/commonCSService.php';
        $service = new commonCSService();
        $_dataTable = $service->ValidUserAndSecurity($db, $username, $security);
        return $_dataTable;
    }

}
