<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new poEmailController();
switch ($info[func]) {
    case "send":
        echo $controller->send($info);
        break;
    case "test":
        echo $controller->send($info);
        break;
}

class poEmailController {

    public function send($info) {

        include '../common/phpmailer.php';
        include '../common/Utility.php';
        include '../service/poEmailService.php';
        if ($this->isValid($info) == 1) {


            $util = new Utility();
            $mail = new PHPMailer(TRUE);
            $util->CopyTemplatedMail("../email/Email.html", "../email/Email_Temp.html", $info[detail]);
            $body = $mail->getFile('../email/Email_Temp.html');


            $service = new poEmailService();
            $_data = $service->getListEmail();

            if ($info[func] == "send") {
                if ($_data != NULL) {
                    foreach ($_data as $key => $value) {
                        $mail->Host = "expwebdesign.com";
                        $mail->Hostname = "expwebdesign.com";
                        $mail->Port = 587;
                        $mail->CharSet = 'utf-8';
                        $mail->From = "noreply@expwebdesign.com";
                        $mail->FromName = "EXPWEBDESIGN";
                        $mail->Subject = "$info[subject]";
                        $mail->MsgHTML($body);
                        $mail->AddAddress($_data[$key]['s_email']);
                        $mailcommit = $mail->Send();
                    }
                    array_map('unlink', glob("../email/tmp_img/*.jpg"));
                    array_map('unlink', glob("../email/tmp_img/*.JPG"));
                    array_map('unlink', glob("../email/tmp_img/*.png"));
                    array_map('unlink', glob("../email/tmp_img/*.PNG"));
                    echo $_SESSION['cd_0000'];
                } else {
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $mail->Host = "expwebdesign.com";
                $mail->Hostname = "expwebdesign.com";
                $mail->Port = 587;
                $mail->CharSet = 'utf-8';
                $mail->From = "noreply@expwebdesign.com";
                $mail->FromName = "EXPWEBDESIGN";
                $mail->Subject = "$info[subject]";
                $mail->MsgHTML($body);
                $mail->AddAddress($util->getEmail());
                $mailcommit = $mail->Send();
                echo $_SESSION['cd_0000'];
            }
        }
    }

    public function isValid($info) {

        $valid = new Utility();
        $intReturn = 0;

        if ($valid->isEmpty($info[subject])) {
            $return2099 = $_SESSION['cd_2099'];
            $return2099 = eregi_replace("field", $_SESSION['lb_po_mail_subject'], $return2099);
            echo $return2099;
        } else if ($valid->isEmpty($info[detail])) {
            $return2099 = $_SESSION['cd_2099'];
            $return2099 = eregi_replace("field", $_SESSION['lb_po_mail_detail'], $return2099);
            echo $return2099;
        } else {
            $intReturn = 1;
        }
        return $intReturn;
    }

}
