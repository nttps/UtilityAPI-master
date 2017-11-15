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

$controller = new BBL();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class BBL {

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
            $COOKIEFILE = $PATH . 'protect/bbl-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $ACCOUNT_NAME = str_replace("-", "", $info[account]);

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

            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/SignOn.aspx');
            $data = curl_exec($ch);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) 
            {
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

// login
            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/SignOn.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            
            $data = curl_exec($ch);
            
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/workspace/16AccountActivity/wsp_AccountSummary_AccountSummaryPage.aspx');
            $data = curl_exec($ch);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }

// find AccIndex ctl00_ctl00_C_CW_gvDepositAccts_ctl02_lnkDepositAccts
// javascript:dataPostPage('wsp_AccountActivity_SavingCurrent.aspx', '../navigator/nav_AccountActivity.aspx', '3', '1234567890')
            $acc_target = $html->find("a[href*=$ACCOUNT_NAME]", 0)->outertext;
            $acc_target = html_entity_decode($acc_target, ENT_QUOTES, 'UTF-8');
            $acc_target = explode(',', $acc_target);
            $acc_index = str_replace("'", '', $acc_target[2]);

            $form_field['AcctID'] = $ACCOUNT_NAME;
            $form_field['AcctIndex'] = (int) $acc_index;
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/workspace/16AccountActivity/wsp_AccountActivity_SavingCurrent.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);
            $html = str_get_html($data);


            $table = $html->find('table[id="ctl00_ctl00_C_CW_tblSummary"]', 0);
            $listTotal = array();

            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $list = array();
                    $list['detail'] = clean($tr->find('td', 0)->plaintext);
                    $list['value'] = ( empty(clean($tr->find('td', 1)->plaintext)) ? "-" : clean($tr->find('td', 1)->plaintext));
                    $listTotal[] = $list;

                    $list = array();
                    $list['detail'] = clean($tr->find('td', 2)->plaintext);
                    $list['value'] = clean($tr->find('td', 3)->plaintext);
                    $listTotal[] = $list;
                }
            }
            if (count($listTotal) == 0) {
                echo $process->return_code("2006", "Process is not Found.");
                return;
            }




            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $form_field['DES_Group'] = 'MAINGROUP';
            //previous 6 month

            if ($info[db_function] == "LV1") {
                $date_period = date('m/d/Y');
                $date_period_end = date('m/d/Y');
            } else if ($info[db_function] == "LV2") {
                $date_period = $this->date_minus(1);
                $date_period_end = date('m/d/Y');
            } else if ($info[db_function] == "LV3") {
                $date_period = ($info[d_start] != NULL ? $this->_dateFormat($info[d_start], "m/d/Y") : $this->date_minus(1));
                $date_period_end = ($info[d_end] != NULL ? $this->_dateFormat($info[d_end], "m/d/Y") : date('m/d/Y'));
            }




            $form_field['ctl00$ctl00$C$CW$IBCalendarDateFrom$hidDateValue'] = $date_period;
            $form_field['ctl00$ctl00$C$CW$IBCalendarDateTo$hidDateValue'] = $date_period_end;

            $form_field['ctl00$ctl00$C$CN$NavAcctActivity1$ddlAccount'] = $html->find("option[selected]", 0)->value;
//            $form_field['__VIEWSTATE'] = $html->find('input[id="__VIEWSTATE"]', 0)->value;

            unset($form_field['ctl00$ctl00$C$btnDownloadClose']);
            unset($form_field['ctl00$ctl00$C$btnDownload']);
            unset($form_field['ctl00$ctl00$C$radDownloadTextFormat']);
            unset($form_field['ctl00$ctl00$C$CW$imgbtnDownload']);

            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/workspace/16AccountActivity/wsp_AccountActivity_SavingCurrent.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_field);
            $data = curl_exec($ch);
            $html = str_get_html($data);




            //$data = iconv("windows-874", "utf-8", $data);
            $listTransaction = array();
            $s = iconv("windows-874", "utf-8", 'วันที่');

            $table = $html->find('table#ctl00_ctl00_C_CW_gvAccountTrans', 0);
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td1 = clean($tr->find('td', 1)->plaintext);

                    $pos = strpos($td1, $s);
                    if ($pos !== false)
                        continue;
                    if (empty($td1))
                        continue;
                    //convert
                    $td1 = $this->convertDate($td1);

                    if (empty($td1))
                        continue;


                    $list = array();
                    $list['datetime'] = $td1;
                    $list['info'] = clean($tr->find('td', 2)->plaintext);
                    $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                    $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 4)->plaintext));
                    $list['total'] = (float) str_replace(',', '', clean($tr->find('td', 5)->plaintext));
                    $list['channel'] = clean($tr->find('td', 6)->plaintext);

                    $dateTime[] = $list['datetime'];

                    $listTransaction[] = $list;
                }
            }



            curl_setopt($ch, CURLOPT_URL, 'https://ibanking.bangkokbank.com/LogOut.aspx');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);
            curl_close($ch);



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

    function convertDate($tdDate) {
        $td1 = "";
        list($d, $m, $y, $h) = explode(' ', $tdDate);
        $month_thai = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $month_num = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $m = str_replace($month_thai, $month_num, $m);
        $y = (int) $y;
        $y = $y - 543;
        $tdDate = $y . '/' . $m . '/' . $d . ' ' . $h;
        $check_date = $d . '-' . $m . '-' . $y . ' ' . $h;
//        if (date('Ymd') != date('Ymd', strtotime($check_date))) {
//            $td1 = NULL;
//        } else {
        $td1 = $tdDate;
//        }
        return $td1;
    }

    public function date_minus($i) {
        $date = date_create(date("m/d/Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'm/d/Y');
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
        if ($info[db_bbl] == "N") {
            echo $valids->return_code("1001", "Function not Verify.");
            exit(0);
        }
    }

    public function convertDateSort($date) {
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        return $yyyy . "/" . $mm . "/" . $dd;
    }

}
