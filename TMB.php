<?php

date_default_timezone_set('Asia/Bangkok');
error_reporting(0);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}
$controller = new TMB();
$info[func] = "InquiryTransaction";
switch ($info[func]) {
//switch ("InquiryTransaction") {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
}

class TMB {

    //put your code here
    public function __construct() {

        require_once './simple_html_dom.php';
        require_once './function.php';
        require_once './common/Utility.php';
        require_once './common/license.php';
    }

    function InquiryTransaction($info) {
        
        //if ($this->valid($info) == 1) {
            $PATH = dirname(__FILE__) . '/';
            $COOKIEFILE = $PATH . 'protect/tmb-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $ACCOUNT_NAME = str_replace("-", "", $info[account]);
//          $USERNAME = "avbet789";
//          $PASSWORD = "avbank1234";
//          $ACCOUNT_NAME = str_replace("-", "", "068-7-18915-9");
            $USERNAME = "natdanai2533";
            $PASSWORD = "Na12345678";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_URL, 'https://www.tmbdirect.com/tmb/kdw1.15.7');
            $data = curl_exec($ch);
            echo str_get_html($data);
            
            exit(0);
            
            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $form_field['txtID'] = $USERNAME;
            $form_field['txtPwd'] = $PASSWORD;
            $form_field['btnLogOn'] = '	Log On';
            $form_field['VAM_Group'] = 'GROUPMAIN';
            unset($form_field['btnLogOff']);
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);






















            $listTotal = array();
            $listTransaction = array();


            $result = array(
                'total' => $listTotal,
                'transaction' => $listTransaction
            );



            return json_encode($result);
        //}
    }

    function valid($info) {
        $intReturn = 0;
        $valid = new Utility();
        $license = new license();
        if ($valid->isEmpty($info[key])) {
            echo "2005,Key is Empty.";
        } else if ($valid->isEmpty($info[username])) {
            echo "2001,Username is Empty.";
        } else if ($valid->isEmpty($info[password])) {
            echo "2002,Password is Empty.";
        } else if ($valid->isEmpty($info[account])) {
            echo "2003,Account No is Empty.";
        } else if (!$valid->validAccountKBANK($info[account])) {
            echo "2004,Accoun No format Not found.";
        } else if (!$license->licenseKey($info[domain], $info[license])) {
            echo "1000,LicenseKey not Verify.";
        } else {
            $intReturn = 1;
        }
        return $intReturn;
    }

}
