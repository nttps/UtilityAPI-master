<?php

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Asia/Bangkok');
error_reporting(0);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}
if ($info == NULL) {
    $info['func'] = $_GET['func'];
    $info['key'] = $_GET['key'];
    $info['username'] = base64_decode($_GET['username']);
    $info['password'] = base64_decode($_GET['password']);
    $info['account'] = $_GET['account'];
    $info['d_start'] = $_GET['d_start'];
    $info['d_end'] = $_GET['d_end'];
    $info['domain'] = $_GET['domain'];
    $info['license'] = $_GET['license'];
    $info['captcha_username'] = base64_decode($_GET['captcha_username']);
    $info['captcha_password'] = base64_decode($_GET['captcha_password']);
    $info['folder_domain'] = $_GET['folder_domain'];
}



$controller = new TrueWallet();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class TrueWallet {

    //put your code here
    public function __construct() {

        require_once './simple_html_dom.php';
        require_once './function.php';
        require_once './common/Utility.php';
        require_once './common/license.php';
    }

    function InquiryTransaction($info) {



        if ($this->valid($info) == 1) {
            $process = new Utility();

            $info = $this->getValueLicense($info);
            $this->licenseVerify($info);

            $PATH = dirname(__FILE__) . '/';
            $COOKIEFILE = $PATH . 'protect/truewallet-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");




            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);


            curl_setopt($ch, CURLOPT_URL, 'wallet.truemoney.com');
            curl_setopt($ch, CURLOPT_REFERER, 'https://wallet.truemoney.com/wallet');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);
            $html = str_get_html($data);

            $form_field = array();
            $form_field['email'] = $USERNAME;
            $form_field['password'] = $PASSWORD;

            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);


            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($ch, CURLOPT_URL, 'https://wallet.truemoney.com/user/login');
            curl_setopt($ch, CURLOPT_REFERER, 'https://wallet.truemoney.com/');
            $data = curl_exec($ch);


            $start = strpos($data, "{\"fullname\":");
            $end = strpos($data, "true}");
            $jsonString = substr($data, $start, ($end - $start + 5));

            $util = new Utility();
            $profile = json_decode($jsonString, true);





            $listTotal = array();
            $list = array();
            $list['detail'] = 'Fullname';
            $list['value'] = $profile[fullname];
            $listTotal[] = $list;

            $list = array();
            $list['detail'] = 'Balance';
            $list['value'] = number_format($profile[balance], 2);
            $listTotal[] = $list;

            $list = array();
            $list['detail'] = 'Mobile Number';
            $list['value'] = $profile[mobileNumber];
            $listTotal[] = $list;

            if (count($listTotal) == 0) {
                echo $process->return_code("2006", "Process is not Found.");
                return;
            }



            $arrayDetail = array();
            curl_setopt($ch, CURLOPT_URL, 'https://wallet.truemoney.com/v1web/api/transaction_history');
            curl_setopt($ch, CURLOPT_REFERER, 'https://wallet.truemoney.com/wallet');
            $data = curl_exec($ch);
            $tmp = json_decode($data, TRUE);
            $tmp = $tmp['data']['activities'];
            $listTransaction = array();
            foreach ($tmp as $key => $value) {
                $reportID = $tmp[$key]['reportID'];
                $url = curl_setopt($ch, CURLOPT_URL, 'https://wallet.truemoney.com/v1web/api/transaction_history_detail?reportID=' . $reportID);
                curl_setopt($ch, CURLOPT_REFERER, 'https://wallet.truemoney.com/wallet');
                $data = curl_exec($ch);
                $tmpDetail = json_decode($data, TRUE);

                $dateTimestamp = $tmpDetail['data']['section4']['column1']['cell1']['value'];
                $totalAmount = $tmpDetail['data']['section3']['column1']['cell2']['value'];
                $tranId = $tmpDetail['data']['section4']['column2']['cell1']['titleTh'] . " " . $tmpDetail['data']['section4']['column2']['cell1']['value'];
                $fromTranferID = $tmpDetail['data']['section2']['column1']['cell1']['value'];
                $creditor = $tmpDetail['data']['section1']['titleEn'];
                $creditorTh = $tmpDetail['data']['section1']['titleTh'];
                $fullInfo = $tranId . " " . $creditorTh . " (Acc. " . $fromTranferID . ")";

                $incomeCheck = ($creditor == "creditor" ? TRUE : FALSE);
                $serviceType = $tmpDetail['data']['serviceType'];



                $list = array();
                $list['datetime'] = $this->convertDateSort($dateTimestamp);
                $list['total'] = $totalAmount;
                $list['channel'] = $serviceType;
                $list['out'] = (float) (!$incomeCheck ? $totalAmount : 0);
                $list['in'] = (float) ($incomeCheck ? $totalAmount : 0);
                $list['info'] = $fullInfo;
                $dateTime[] = $list['datetime'];

                $listTransaction[] = $list;
            }

            array_multisort($dateTime, SORT_DESC, SORT_STRING, $listTransaction);



            $result = array(
                'total' => $listTotal,
                'transaction' => $listTransaction,
                'code' => '0000',
                'description' => 'success'
            );



            return json_encode($result);
        }
    }

    function valid($info) {
        $intReturn = 0;
        $valid = new Utility();
        $license = new license();
        if ($valid->isEmpty($info[key])) {
            echo $valid->return_code("2005", "Key is Empty.");
        } else if ($valid->isEmpty($info[username])) {
            echo $valid->return_code("2001", "Username is Empty.");
        } else if ($valid->isEmpty($info[password])) {
            echo $valid->return_code("2002", "Password is Empty.");
        } else if ($valid->isEmpty($info[domain])) {
            echo $valid->return_code("1000", "LicenseKey not Verify.");
        } else if ($valid->isEmpty($info[license])) {
            echo $valid->return_code("1001", "Function not Verify.");
        } else {
            $intReturn = 1;
        }
        return $intReturn;
    }

    public function getValueLicense($info) {
        require_once './adm/common/ConnectDB.php';
        require_once './adm/controller/licenseController.php';
        require_once './adm/service/licenseService.php';
        $db = new ConnectDB();
        $_controller = new licenseController();
        $_data = json_decode($_controller->checkLicense($db, new licenseService(), $info), true);

        if ($_data != NULL) {
            $info['db_domain'] = $_data[0]['s_domain'];
            $info['db_license'] = $_data[0]['s_license_key'];
            $info['db_function'] = $_data[0]['s_function'];
            $info['db_kbank'] = $_data[0]['s_kbank'];
            $info['db_scb'] = $_data[0]['s_scb'];
            $info['db_bbl'] = $_data[0]['s_bbl'];
            $info['db_ktb'] = $_data[0]['s_ktb'];
            $info['db_bay'] = $_data[0]['s_bay'];
            $info['db_truewallet'] = $_data[0]['s_truewallet'];
            return $info;
        } else {
            return $info;
        }
    }

    public function licenseVerify($info) {
        $valids = new Utility();
        if ($info[db_domain] == NULL) {
            echo $valids->return_code("1000", "LicenseKey not Verify.");
            exit(0);
        }
        if ($info[db_truewallet] == "N") {
            echo $valids->return_code("1001", "Function not Verify.");
            exit(0);
        }
    }

    public function convertDateSort($date) {
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 2);
        $hh = substr($date, 9, 2);
        $ss = substr($date, 12, 2);
        return "20" . $yyyy . "/" . $mm . "/" . $dd . " " . $hh . ":" . $ss;
    }

}
