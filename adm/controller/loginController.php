<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}
//$info['func'] = 'captcha';

$controller = new loginController();
switch ($info[func]) {
    case "login":
        echo $controller->login($info);
        break;
    case "forgot":
        echo $controller->forgot($info);
        break;
    case "captcha":
        echo $controller->captcha();
        break;
}

class loginController {

    public function forgot($info) {
        include '../service/loginService.php';
        include '../common/Utility.php';
        $servic = new loginService();
        $util = new Utility();
        $util->setPathXML("../language/language_common.xml");
        $util->LanguageConfig("en");
        $util->setPathXML("../language/language_page.xml");
        $util->LanguageConfig("th");

        if ($util->isEmpty($info[email])) {
            $return2099 = $_SESSION['cd_2099'];
            $return2099 = eregi_replace("field", $_SESSION['email'], $return2099);
            echo $return2099;
        } else if (!filter_var($info[email], FILTER_VALIDATE_EMAIL)) {
            echo $_SESSION['cd_2006'];
        } else {
            $_data = $servic->checkEmail($info);
            if ($_data != NULL) {
                include '../common/phpmailer.php';
                $mail = new PHPMailer(TRUE);

                foreach ($_data as $key => $value) {
                    $util->CopyTemplatedMailForgot("../email/Email_Forgot.html", "../email/Email_Forgot_Temp.html", $_data[$key]['s_firstname'], $_data[$key]['s_lastname'], $_data[$key]['s_user'], $_data[$key]['s_pass']);
                    $body = $mail->getFile('../email/Email_Forgot_Temp.html');

                    $mail->Host = "expwebdesign.com";
                    $mail->Hostname = "expwebdesign.com";
                    $mail->Port = 587;
                    $mail->CharSet = 'utf-8';
                    $mail->From = "noreply@expwebdesign.com";
                    $mail->FromName = "EXPWEBDESIGN";
                    $mail->Subject = "EXPWEBDESIGN : FORGOT PASSWORD";
                    $mail->MsgHTML($body);
                    $mail->AddAddress($_data[$key]['s_email']);
                    $mailcommit = $mail->Send();
                }
                echo $_SESSION['cd_0000'];
            } else {
                echo $_SESSION['cd_2009'];
            }
        }
    }

    public function login($info) {
        include '../service/loginService.php';
        include '../common/Utility.php';
        $servic = new loginService();
        $util = new Utility();
        $util->setPathXML("../language/language_common.xml");
        $util->LanguageConfig("th");
        $util->setPathXML("../language/language_page.xml");
        $util->LanguageConfig("th");
        $_SESSION["lan"] = "th";
        $_SESSION["selected_lan_pic"] = "th.png";
        $_SESSION["selected_lan_name"] = "TH";

//        $util->setPathXML("../language/language_common.xml");
//        $util->LanguageConfig("en");
//        $util->setPathXML("../language/language_page.xml");
//        $util->LanguageConfig("en");
//        $_SESSION["lan"] = "en";
//        $_SESSION["selected_lan_pic"] = "us.png";
//        $_SESSION["selected_lan_name"] = "US";

        $flgUser = $util->isEmptyReg($info[username]);

        if ($flgUser) {
            echo $_SESSION['cd_4001'];
            return;
        }


        $flgPass = $util->isEmptyReg($info[password]);
        if ($flgPass && !$flgUser) {
            echo $_SESSION['cd_4002'];
            return;
        }

        if (strtoupper($info[captcha]) != strtoupper($_SESSION[captcha][code])) {
            echo $_SESSION['cd_4004'];
            return;
        }

        if (!$flgUser && !$flgPass) {
            $_data = $servic->login($info);

            if ($_data != NULL) {
                foreach ($_data as $key => $value) {
                    $_SESSION["i_user"] = $_data[$key]['i_user'];
                    $_SESSION["username"] = $_data[$key]['s_user'];
                    $_SESSION["user_email"] = $_data[$key]['s_email'];
                    $_SESSION["password"] = $_data[$key]['s_pass'];
                    $_SESSION["img_profile"] = $_data[$key]['s_image'];
                    $_SESSION["full_name"] = $_data[$key]['s_firstname'] . " " . $_data[$key]['s_lastname'];
                    $_SESSION["perm"] = $_data[$key]['s_type'];
                }
                $_SESSION[mode_lock] = FALSE;
                echo $_SESSION['cd_0000'];
            } else {
                echo $_SESSION['cd_4003'];
            }
        }
    }

    public function captcha() {
        include '../captcha/simple-php-captcha.php';
        $_SESSION = array();
        $_SESSION['captcha'] = simple_php_captcha();
        echo $_SESSION['captcha'][image_src];
    }

}
