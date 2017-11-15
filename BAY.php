
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


$controller = new BAY();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class BAY {

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
            $COOKIEFILE = $PATH . 'protect/bay-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $ACCOUNT_NAME = str_replace("-", "", $info[account]);
//        $USERNAME = "avbet789";
//        $PASSWORD = "avbank6868";
//        $ACCOUNT_NAME = str_replace("-", "", "068-7-18915-9");


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



            curl_setopt($ch, CURLOPT_URL, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Common/Login.aspx');
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Common/Login.aspx?language=TH');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);
            $html = str_get_html($data);

            $form_field = array();
            foreach ($html->find('form[name="aspnetForm"] input') as $element) {
                $form_field[$element->name] = $element->value;
            }

            unset($form_field['__EVENTTARGET']);
            unset($form_field['ctl00$cphForLogin$btnDefault']);
            unset($form_field['ctl00$cphForLogin$lbtnLoginNew']);
            unset($form_field['ctl00$cphForLogin$btnNewLogin']);
            unset($form_field['ctl00$cphForLogin$lbtnLoginNew']);
            unset($form_field['ctl00$cphForLogin$btnNewLogin']);
            unset($form_field['ctl00$btnDefaultButton']);
            $form_field['user'] = '';
            $form_field['password'] = '';
            $form_field['username'] = '';
            $form_field['password'] = '';
            $form_field['ctl00$cphForLogin$username'] = $USERNAME;
            $form_field['ctl00$cphForLogin$password'] = '';
            $form_field['ctl00$cphForLogin$hdPassword'] = $PASSWORD;
            $form_field['ctl00$cphForLogin$hddLanguage'] = 'TH';
            $form_field['__EVENTTARGET'] = 'ctl00$cphForLogin$lbtnLoginNew';




            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

            curl_setopt($ch, CURLOPT_URL, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Common/Login.aspx');
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Common/Login.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);


            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_URL, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Pages/MyPortfolio.aspx?d');
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Common/Login.aspx');

            $data = curl_exec($ch);


            $util = new Utility();

            $html = str_get_html($data);
            $table = $html->find('table[class="myport_table"]', 0);
            $listTotal = array();
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $list = array();
                    $list['detail'] = "ประเภทบัญชี";
                    $list['value'] = clean($tr->find('td', 0)->plaintext);

                    if ($util->isEmpty($list['value'])) {
                        continue;
                    }
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = "ชื่อเรียกแทนบัญชี";
                    $list['value'] = clean($tr->find('td', 1)->plaintext);
                    $listTotal[] = $list;


                    $list = array();
                    $list['detail'] = "ยอดเงินที่ใช้ได้";

                    $list['value'] = clean($tr->find('td', 2)->plaintext);
                    $listTotal[] = $list;


                    $list = array();
                    $list['detail'] = "ยอดเงินในบัญชี";
                    $list['value'] = clean($tr->find('td', 3)->plaintext);
                    $listTotal[] = $list;
                }
            }

            if (count($listTotal) == 0) {
                echo $process->return_code("2006", "Process is not Found.");
                return;
            }



            //today
            $ahref_link = $html->find('a');
            $pattern = '^/BAY.KOL.WebSite/Pages/MyAccount.aspx\\?token=';
            if (!(empty($ahref_link))) {
                foreach ($ahref_link as $element) {
                    if (ereg($pattern, $element->href)) {
                        curl_setopt($ch, CURLOPT_URL, 'https://www.krungsrionline.com' . $element->href);
                        curl_setopt($ch, CURLOPT_REFERER, 'https://www.krungsrionline.com/BAY.KOL.WebSite/Pages/MyPortfolio.aspx?d');
                        curl_setopt($ch, CURLOPT_POST, 0);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                        $data = curl_exec($ch);
                    }
                }
            }
            //echo $data;
            // exit(0);



            $html = str_get_html($data);
            $table = $html->find('table[class="deposit_accsum_table"]', 0);
            $listTransaction = array();
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td0 = clean($tr->find('td', 0)->plaintext);
                    if ($util->isEmpty($td0)) {
                        continue;
                    }
                    if ($td0 == "รายการวันนี้") {
                        continue;
                    }
                    if ($td0 == "NO TRANSACTION TODAY") {
                        continue;
                    }



                    $list = array();
                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                    $list['total'] = clean($tr->find('td', 4)->plaintext);
                    $list['channel'] = clean($tr->find('td', 5)->plaintext);
                    $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 2)->plaintext));
                    $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                    $list['info'] = clean($tr->find('td', 1)->plaintext);
                    $dateTime[] = $list['datetime'];


                    $listTransaction[] = $list;
                }
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
        } else if ($valid->isEmpty($info[account])) {
            echo $valid->return_code("2003", "Account No is Empty.");
        } else if (!$valid->validAccountKBANK($info[account])) {
            echo $valid->return_code("2004", "Accoun No format Not found.");
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
        if ($info[db_bay] == "N") {
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
