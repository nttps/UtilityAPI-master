<?php

header('Access-Control-Allow-Origin: *');
session_start();
date_default_timezone_set('Asia/Bangkok');
error_reporting(0);
flush();

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



$controller = new KTB();
switch ($info[func]) {
    case "InquiryTransactionCaptchaAuto":
        echo $controller->InquiryTransactionCaptchaAuto($info);
        break;
    case "InquiryTransactionCaptcha":
        echo $controller->InquiryTransactionCaptcha($info);
        break;
    case "GetCaptcha":
        echo $controller->GetCaptcha($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class KTB {

    public function __construct() {
        require_once './simple_html_dom.php';
        require_once './function.php';
        require_once './common/Utility.php';
        require_once './common/license.php';
        require_once './common/deathbycaptcha.php';
    }

    function GetCaptcha($info) {
        $PATH = dirname(__FILE__) . '/';
        $COOKIEFILE = $PATH . 'protect/ktb-cookies';
        $MAIN_URL = 'https://www.ktbnetbank.com';
        mkdir($PATH . 'captcha/' . $info[folder_domain], 0777, true);

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

        curl_setopt($ch, CURLOPT_URL, 'https://www.ktbnetbank.com/consumer/');
        $data = curl_exec($ch);





        curl_setopt($ch, CURLOPT_URL, 'https://www.ktbnetbank.com/consumer/captcha/verifyImg');
        $captcha_data = curl_exec($ch);
        $fp = fopen($PATH . 'captcha/' . $info[folder_domain] . '/cap_client.png', 'w');
        fwrite($fp, $captcha_data);
        fclose($fp);

        $result = array(
            'sessionId' => time(),
            'image' => $info[folder_domain] . '/cap_client.png'
        );

        return json_encode($result);
    }

    function InquiryTransactionCaptcha($info) {

        if ($this->valid($info) == 1) {
            $process = new Utility();


            $info = $this->getValueLicense($info);
            $this->licenseVerify($info);


            $PATH = dirname(__FILE__) . '/';
            $COOKIEFILE = $PATH . 'protect/ktb-cookies';

            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $ACCOUNT_NAME = $info[account];

            $MAIN_URL = 'https://www.ktbnetbank.com';
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



            $form_field = array();
            $form_field['cmd'] = 'login';
            $form_field['imageCode'] = $info[imageCode];
            $form_field['userId'] = $USERNAME;
            $form_field['password'] = $PASSWORD;

            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);


// do login
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/consumer/');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/Login.do');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            preg_match("/sessionKey = '(.*)'/", $data, $output_array);
            $session_key = $output_array[1];

            $r = microtime(true);
            $form_field = array();
            $form_field['from_date'] = '';
            $form_field['to_date'] = '';
            $form_field['radios'] = '';
            $form_field['specific_peroid'] = '';
            $form_field['accountNo'] = str_replace('-', '', $ACCOUNT_NAME);
            $form_field['accountNoDisp'] = $ACCOUNT_NAME;
            $form_field['newAliasName'] = '';
            $form_field['oldAliasName'] = '';
            $form_field['accountSelectedItem'] = '';
            $form_field['amount'] = '';
            $form_field['radiosEditAmount'] = '';
            $form_field['note'] = '';
            $form_field['sessId'] = $session_key;

            $listTotal = array();
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/Netbank/myaccount/saving/saving_accountdetail.jsp');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/SavingAccount.do?cmd=init&sessId=' . $session_key . '&_=7777');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_field);
            $data = curl_exec($ch);
            $xml = simplexml_load_string($data);
            if ($xml == NULL) {
                return $process->return_code("2006", "Process is not Found.");
            }
            foreach ($xml->children() as $xmlValue) {
                if ((string) $xmlValue->ACCOUNTNODISPLAY == $ACCOUNT_NAME) {
                    $list = array();
                    $list['detail'] = 'ชื่อบัญชี';
                    $list['value'] = (string) $xmlValue->ACCOUNT_NAME;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'เลขที่บัญชี';
                    $list['value'] = (string) $xmlValue->ACCOUNTNODISPLAY;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ประเภทบัญชี';
                    $list['value'] = (string) $xmlValue->TYPE;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ชื่อแทนบัญชี';
                    $list['value'] = (string) $xmlValue->ALIAS;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ยอดเงินคงเหลือ';
                    $list['value'] = (string) $xmlValue->AMOUNT;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ยอดเงินที่ถอนได้';
                    $list['value'] = (string) $xmlValue->WITHDRAWABLE;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'สกุลเงิน';
                    $list['value'] = (string) $xmlValue->CURRENCY;
                    $listTotal[] = $list;
                }
            }

            //previous 6 month
            //$date_period_end = date('d-m-Y');
            //$date_period = $this->date_minus(1);

            if ($info[db_function] == "LV1") {
                $date_period = date('d-m-Y');
                $date_period_end = date('d-m-Y');
            } else if ($info[db_function] == "LV2") {
                $date_period = $this->date_minus(1);
                $date_period_end = date('d-m-Y');
            } else if ($info[db_function] == "LV3") {
                $date_period = ($info[d_start] != NULL ? $this->_dateFormat($info[d_start], "d-m-Y") : $this->date_minus(1));
                $date_period_end = ($info[d_end] != NULL ? $this->_dateFormat($info[d_end], "d-m-Y") : date('d-m-Y'));
            }





            $form_field = array();
            $form_field['acctNo'] = str_replace('-', '', $ACCOUNT_NAME);
            $form_field['fromDate'] = $date_period;
            $form_field['radio'] = 'date_peroid';
            $form_field['sessId'] = $session_key;
            $form_field['specificAmtFrom'] = '';
            $form_field['specificAmtTo'] = '';
            $form_field['toDate'] = $date_period_end;
            $form_field['txnRefNoFrom	'] = '';
            $form_field['txnRefNoTo'] = '';

            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);


            $r = microtime(true);
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/consumer/main.jsp');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/SearchSpecific.do?cmd=search&r=' . $r);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_field);
            $data = curl_exec($ch);

            $html = str_get_html($data);
            $table = $html->find('table.subcontenttable', 0);
            $s = 'วันที่';
            $listTransaction = array();
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td1 = clean($tr->find('td', 0)->plaintext);
                    $pos = strpos($td1, $s);
                    if ($pos !== false)
                        continue;
                    if (empty($td1))
                        continue;

                    $list = array();
                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                    $list['info'] = clean($tr->find('td', 1)->plaintext);
                    $list['check'] = clean($tr->find('td', 2)->plaintext);
                    $amount = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                    if ($amount >= 0) {
                        $list['in'] = $amount;
                        $list['out'] = 0;
                    } else {
                        $list['in'] = 0;
                        $list['out'] = $amount;
                    }
                    $list['branch'] = clean($tr->find('td', 5)->plaintext);


                    $dateTime[] = $list['datetime'];

                    $listTransaction[] = $list;
                }
            }

            if (count($listTotal) == 0) {
                return $process->return_code("2006", "Process is not Found.");
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

    function InquiryTransactionCaptchaAuto($info) {

        if ($this->valid($info) == 1) {
            $process = new Utility();

            $info = $this->getValueLicense($info);
            $this->licenseVerify($info);



            $captcha_username = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[captcha_username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $captcha_password = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[captcha_password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $client = new DeathByCaptcha_SocketClient($captcha_username, $captcha_password);


            $balance = (int) $client->balance;
            if (empty($balance) || $balance <= 0) {
                echo $process->return_code("2010", "Not enough money (Captcha)");
                return;
            }



            $PATH = dirname(__FILE__) . '/';
            $COOKIEFILE = $PATH . 'protect/ktb-cookies';
            mkdir($PATH . 'captcha/' . $info[folder_domain], 0777, true);

            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $ACCOUNT_NAME = $info[account];

            $MAIN_URL = 'https://www.ktbnetbank.com';
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

            curl_setopt($ch, CURLOPT_URL, 'https://www.ktbnetbank.com/consumer/');
            $data = curl_exec($ch);





            curl_setopt($ch, CURLOPT_URL, 'https://www.ktbnetbank.com/consumer/captcha/verifyImg');
            $captcha_data = curl_exec($ch);
            $fp = fopen($PATH . 'captcha/' . $info[folder_domain] . '/cap.png', 'w');
            fwrite($fp, $captcha_data);
            fclose($fp);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }

            $img = $PATH . 'captcha/' . $info[folder_domain] . '/cap.png';
            if (!$captcha = $client->decode($img, DeathByCaptcha_Client::DEFAULT_TIMEOUT)) {
                //echo "CAPTCHA {$captcha['captcha']} solved: {$captcha['text']}\n";

                echo $process->return_code("2011", "Captcha is Error.");
                return;
            }
            $form_field['imageCode'] = $captcha['text'];
            $form_field['userId'] = $USERNAME;
            $form_field['password'] = $PASSWORD;
            $form_field['cmd'] = 'login';

            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);


// do login
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/consumer/');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/Login.do');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            preg_match("/sessionKey = '(.*)'/", $data, $output_array);
            $session_key = $output_array[1];



////////////////////////////////////////////////////////////////////////////////////////////////////
            $r = microtime(true);
            $form_field = array();
            $form_field['from_date'] = '';
            $form_field['to_date'] = '';
            $form_field['radios'] = '';
            $form_field['specific_peroid'] = '';
            $form_field['accountNo'] = str_replace('-', '', $ACCOUNT_NAME);
            $form_field['accountNoDisp'] = $ACCOUNT_NAME;
            $form_field['newAliasName'] = '';
            $form_field['oldAliasName'] = '';
            $form_field['accountSelectedItem'] = '';
            $form_field['amount'] = '';
            $form_field['radiosEditAmount'] = '';
            $form_field['note'] = '';
            $form_field['sessId'] = $session_key;

            $listTotal = array();
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/Netbank/myaccount/saving/saving_accountdetail.jsp');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/SavingAccount.do?cmd=init&sessId=' . $session_key . '&_=7777');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_field);
            $data = curl_exec($ch);
            $xml = simplexml_load_string($data);
            if ($xml == NULL) {
                echo $process->return_code("2006", "Process is not Found.");
                return;
            }
            foreach ($xml->children() as $xmlValue) {
                if ((string) $xmlValue->ACCOUNTNODISPLAY == $ACCOUNT_NAME) {
                    $list = array();
                    $list['detail'] = 'ชื่อบัญชี';
                    $list['value'] = (string) $xmlValue->ACCOUNT_NAME;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'เลขที่บัญชี';
                    $list['value'] = (string) $xmlValue->ACCOUNTNODISPLAY;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ประเภทบัญชี';
                    $list['value'] = (string) $xmlValue->TYPE;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ชื่อแทนบัญชี';
                    $list['value'] = (string) $xmlValue->ALIAS;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ยอดเงินคงเหลือ';
                    $list['value'] = (string) $xmlValue->AMOUNT;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'ยอดเงินที่ถอนได้';
                    $list['value'] = (string) $xmlValue->WITHDRAWABLE;
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = 'สกุลเงิน';
                    $list['value'] = (string) $xmlValue->CURRENCY;
                    $listTotal[] = $list;
                }
            }

////////////////////////////////////////////////////////////////////////////////////////////////////
// find sessionKey = 'xxxx';
            //previous 6 month
            //$date_period_end = date('d-m-Y');
            //$date_period = $this->date_minus(1);

            if ($info[db_function] == "LV1") {
                $date_period = date('d-m-Y');
                $date_period_end = date('d-m-Y');
            } else if ($info[db_function] == "LV2") {
                $date_period = $this->date_minus(1);
                $date_period_end = date('d-m-Y');
            } else if ($info[db_function] == "LV3") {
                $date_period = ($info[d_start] != NULL ? $this->_dateFormat($info[d_start], "d-m-Y") : $this->date_minus(1));
                $date_period_end = ($info[d_end] != NULL ? $this->_dateFormat($info[d_end], "d-m-Y") : date('d-m-Y'));
            }





            $form_field = array();
            $form_field['acctNo'] = str_replace('-', '', $ACCOUNT_NAME);
            $form_field['fromDate'] = $date_period;
            $form_field['radio'] = '1';
            $form_field['sessId'] = $session_key;
            $form_field['specificAmtFrom'] = '';
            $form_field['specificAmtTo'] = '';
            $form_field['toDate'] = $date_period_end;
            $form_field['txnRefNoFrom	'] = '';
            $form_field['txnRefNoTo'] = '';

            $r = microtime(true);
            curl_setopt($ch, CURLOPT_REFERER, $MAIN_URL . '/consumer/main.jsp');
            curl_setopt($ch, CURLOPT_URL, $MAIN_URL . '/consumer/SearchSpecific.do?cmd=search&r=' . $r);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_field);
            $data = curl_exec($ch);

            $html = str_get_html($data);

            $table = $html->find('table.subcontenttable', 0);
            $s = 'วันที่';
            $listTransaction = array();
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td1 = clean($tr->find('td', 0)->plaintext);
                    $pos = strpos($td1, $s);
                    if ($pos !== false)
                        continue;
                    if (empty($td1))
                        continue;

                    $list = array();
                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                    $list['info'] = clean($tr->find('td', 1)->plaintext);
                    $list['check'] = clean($tr->find('td', 2)->plaintext);
                    $amount = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                    if ($amount >= 0) {
                        $list['in'] = $amount;
                        $list['out'] = 0;
                    } else {
                        $list['in'] = 0;
                        $list['out'] = $amount;
                    }
                    $list['branch'] = clean($tr->find('td', 5)->plaintext);


                    $dateTime[] = $list['datetime'];

                    $listTransaction[] = $list;
                }
            }

            if (count($listTotal) == 0) {
                echo $process->return_code("2006", "Process is not Found.");
                return;
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

    public function date_minus($i) {
        $date = date_create(date("d-m-Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'd-m-Y');
    }

    public function _dateFormat($var, $format) {
        $date = str_replace('/', '-', $var);
        return date($format, strtotime($date));
    }

    function valid($info) {
        $intReturn = 0;
        $valid = new Utility();
        //$license = new license();
        if ($valid->isEmpty($info[key])) {
            echo $valid->return_code("2005", "Key is Empty.");
        } else if ($valid->isEmpty($info[username])) {
            echo $valid->return_code("2001", "Username is Empty.");
        } else if ($valid->isEmpty($info[password])) {
            echo $valid->return_code("2002", "Password is Empty.");
        } else if ($valid->isEmpty($info[account])) {
            echo $valid->return_code("2003", "Account No is Empty.");
        } else if (!$valid->validAccountKBANK($info[account])) {
            echo $valid->return_code("2004", "Accoun No format Not found.");
        } else if ($valid->isEmpty($info[domain])) {
            echo $valid->return_code("1000", "LicenseKey not Verify.");
        } else if ($valid->isEmpty($info[license])) {
            echo $valid->return_code("1001", "Function not Verify.");
        } else if ($valid->isEmpty($info[captcha_username]) && $info[func] != "InquiryTransactionCaptcha") {
            echo $valid->return_code("2007", "Captcha Username is Empty.");
        } else if ($valid->isEmpty($info[captcha_password]) && $info[func] != "InquiryTransactionCaptcha") {
            echo $valid->return_code("2008", "Captcha Password is Empty.");
        } else if ($valid->isEmpty($info[folder_domain])) {
            echo $valid->return_code("2009", "Folder Domain is Empty.");
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
        if ($info[db_ktb] == "N") {
            echo $valids->return_code("1001", "Function not Verify.");
            exit(0);
        }
    }

    public function convertDateSort($date) {
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        $hhss = substr($date, 10);
        return $yyyy . "/" . $mm . "/" . $dd . " " . $hhss;
    }

}
