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



$controller = new KBANK();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class KBANK {

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
            $COOKIEFILE = $PATH . 'protect/kk-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
//            $USERNAME = $info[username];
//            $PASSWORD = $info[password];
            $ACCOUNT_NAME = $info[account];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);

// use cookie
//            curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);

            $form_field = array();
            $form_field['isConfirm	'] = 'T';
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

// pre login page
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/preLogin/popupPreLogin.jsp?lang=th&isConfirm=T');
            $data = curl_exec($ch);

// load login
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/login.do');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $form_field['userName'] = $USERNAME;
            $form_field['password'] = $PASSWORD;

            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

// login
            curl_setopt($ch, CURLOPT_REFERER, 'https://online.kasikornbankgroup.com/K-Online/login.do');
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/login.do');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/indexHome.jsp');
            $data = curl_exec($ch);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_REFERER, 'https://online.kasikornbankgroup.com/K-Online/indexHome.jsp');
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/checkSession.jsp');
            $data = curl_exec($ch);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_REFERER, 'https://online.kasikornbankgroup.com/K-Online/indexHome.jsp');
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/clearSession.jsp');
            $data = curl_exec($ch);


// redirect after login
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/ib/redirectToIB.jsp?r=7027');
            $data = curl_exec($ch);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

// welcom page
            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/security/Welcome.do');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);






            $listTransaction = array();






/////////////////////////////////////////////////////


            if ($info[db_function] != "LV1") {


                if ($info[db_function] == "LV2") {
                    $date_period = $this->date_minus(1);
                    $date_period_end = $this->date_minus(1);
                } else if ($info[db_function] == "LV3") {
                    $date_period = ($info[d_start] != NULL ? $this->_dateFormat($info[d_start], "d/m/Y") : $this->date_minus(1));
                    $date_period_end = ($info[d_end] != NULL ? $this->_dateFormat($info[d_end], "d/m/Y") : $this->date_minus(1));
                    if ($date_period_end == date('d/m/Y')) {
                        $date_period_end = $this->date_minus(1);
                    }
                }


                if ($info[db_function] == "LV2" || ($info[db_function] == "LV3" && $this->_dateFormat($info[d_start], "d/m/Y") != date('d/m/Y'))) {

                    // transaction statement page
                    curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/accountinfo/AccountStatementInquiry.do');
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                    $data = curl_exec($ch);

                    $data = iconv("windows-874", "utf-8", $data);

                    $html = str_get_html($data);
                    $form_field = array();
                    foreach ($html->find('form[name="StatementForm"] input') as $element) {
                        $form_field[$element->name] = $element->value;
                    }



                    // $date_period = $this->date_minus(1);
                    // $date_period_end = $this->date_minus(1);



                    $form_field['selDateFrom'] = $date_period;
                    $form_field['selDateTo'] = $date_period_end;

                    $form_field['selDayFrom'] = $this->subStringDate($date_period, 'dd');
                    $form_field['selMonthFrom'] = $this->subStringDate($date_period, 'mm');
                    $form_field['selYearFrom'] = $this->subStringDate($date_period, 'yyyy');

                    $form_field['selDayTo'] = $this->subStringDate($date_period_end, 'dd');
                    $form_field['selMonthTo'] = $this->subStringDate($date_period_end, 'mm');
                    $form_field['selYearTo'] = $this->subStringDate($date_period_end, 'yyyy');

                    $form_field['period'] = '3';
// select account
                    $s = $ACCOUNT_NAME;
                    foreach ($html->find('select[name="accountNo"] option') as $element) {
                        $text = clean($element->plaintext);
                        $pos = strpos($text, $s);
                        if ($pos !== false) {
                            $form_field['accountNo'] = $element->value;
                        }
                    }
                    $post_string = '';
                    foreach ($form_field as $key => $value) {
                        $post_string .= $key . '=' . urlencode($value) . '&';
                    }
                    $post_string = substr($post_string, 0, -1);


                    curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/accountinfo/AccountStatementInquiry.do');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
                    $data = curl_exec($ch);
                    $s = 'วันที่';
                    $html = str_get_html($data);
                    $table = $html->find('table[rules="rows"]', 0);
                    if (!(empty($table))) {
                        foreach ($table->find('tr') as $tr) {
                            $td1 = clean($tr->find('td', 0)->plaintext);
                            $pos = strpos($td1, $s);
                            if ($pos !== false)
                                continue;
                            if ($td1 == "ไม่พบรายการนี้.")
                                continue;


                            $list = array();
                            $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                            $list['channel'] = clean($tr->find('td', 5)->plaintext);
                            $list['type'] = '';
                            $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 2)->plaintext));
                            $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                            $list['bankno'] = '';
                            $list['info'] = clean($tr->find('td', 1)->plaintext);

                            $dateTime[] = $list['datetime'];


                            $listTransaction[] = $list;
                        }
                    }

                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                    curl_setopt($ch, CURLOPT_REFERER, 'https://online.kasikornbankgroup.com/K-Online/indexHome.jsp');
                    curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/checkSession.jsp');
                    $data = curl_exec($ch);


                    $lpM = 0;

                    $ahref_link = $html->find('a');
                    $pattern = '^/retail/accountinfo/AccountStatementInquiry.do\\?action=sa_detail';
                    if (!(empty($ahref_link))) {
                        foreach ($ahref_link as $element) {
                            if (ereg($pattern, $element->href)) {
                                if ($lpM == 0) {
                                    //first
                                    curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com' . $element->href);
                                    curl_setopt($ch, CURLOPT_POST, 0);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                                    $data = curl_exec($ch);

                                    $s = 'วันที่';
                                    $html = str_get_html($data);
                                    $table = $html->find('table[rules="rows"]', 0);
                                    if (!(empty($table))) {
                                        foreach ($table->find('tr') as $tr) {
                                            $td1 = clean($tr->find('td', 0)->plaintext);
                                            $pos = strpos($td1, $s);
                                            if ($pos !== false)
                                                continue;
                                            if ($td1 == "ไม่พบรายการนี้.")
                                                continue;


                                            $list = array();
                                            $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                                            $list['channel'] = clean($tr->find('td', 5)->plaintext);
                                            $list['type'] = '';
                                            $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 2)->plaintext));
                                            $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                                            $list['bankno'] = '';
                                            $list['info'] = clean($tr->find('td', 1)->plaintext);


                                            $dateTime[] = $list['datetime'];

                                            $listTransaction[] = $list;
                                        }
                                    }
                                }
                                $lpM++;
                            }
                        }
                    }

                    if ($lpM > 0) {
                        for ($i = 0; $i < $lpM; $i++) {
                            if ($i != 0) {

                                $html = str_get_html($data);
                                $ahref_link = $html->find('a');
                                if (!(empty($ahref_link))) {
                                    $lpS = 0;
                                    foreach ($ahref_link as $element) {
                                        if (ereg($pattern, $element->href)) {
                                            if ($i == $lpS) {
                                                curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com' . $element->href);
                                                curl_setopt($ch, CURLOPT_POST, 0);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                                                $data = curl_exec($ch);

                                                $s = 'วันที่';
                                                $html = str_get_html($data);
                                                $table = $html->find('table[rules="rows"]', 0);
                                                if (!(empty($table))) {
                                                    foreach ($table->find('tr') as $tr) {
                                                        $td1 = clean($tr->find('td', 0)->plaintext);
                                                        $pos = strpos($td1, $s);
                                                        if ($pos !== false)
                                                            continue;
                                                        if ($td1 == "ไม่พบรายการนี้.")
                                                            continue;


                                                        $list = array();
                                                        $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                                                        $list['channel'] = clean($tr->find('td', 5)->plaintext);
                                                        $list['type'] = '';
                                                        $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 2)->plaintext));
                                                        $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                                                        $list['bankno'] = '';
                                                        $list['info'] = clean($tr->find('td', 1)->plaintext);


                                                        $dateTime[] = $list['datetime'];

                                                        $listTransaction[] = $list;
                                                    }
                                                }
                                            }
                                            $lpS++;
                                        }
                                    }
                                }
                            }
                        }
                    }





                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                    curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/checkSession.jsp');
                    $data = curl_exec($ch);
                }
            }

























































































////////////////////////////////////////////////////
// transaction statement page today 
            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/cashmanagement/TodayAccountStatementInquiry.do');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);

            $data = iconv("windows-874", "utf-8", $data);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form[name="TodayStatementForm"] input') as $element) {
                $form_field[$element->name] = $element->value;
            }
// select account
            $s = $ACCOUNT_NAME;
            foreach ($html->find('select[name="acctId"] option') as $element) {
                $text = clean($element->plaintext);
                $pos = strpos($text, $s);
                if ($pos !== false) {
                    $form_field['acctId'] = $element->value;
                }
            }
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/cashmanagement/TodayAccountStatementInquiry.do');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            $s = 'วันที่';
            $html = str_get_html($data);
            $table = $html->find('table[rules="rows"]', 0);
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td1 = clean($tr->find('td', 0)->plaintext);
                    $pos = strpos($td1, $s);
                    if ($pos !== false)
                        continue;
                    if ($td1 == "ไม่พบรายการนี้.")
                        continue;


                    $list = array();
                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                    $list['channel'] = clean($tr->find('td', 1)->plaintext);
                    $list['type'] = clean($tr->find('td', 2)->plaintext);
                    $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                    $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 4)->plaintext));
                    $list['bankno'] = clean($tr->find('td', 5)->plaintext);
                    $list['info'] = clean($tr->find('td', 6)->plaintext);

                    $dateTime[] = $list['datetime'];

                    $listTransaction[] = $list;
                }
            }

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_REFERER, 'https://online.kasikornbankgroup.com/K-Online/indexHome.jsp');
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/checkSession.jsp');
            $data = curl_exec($ch);

            $lpM = 0;
            $ahref_link = $html->find('a');
            $pattern = '^/retail/cashmanagement/TodayAccountStatementInquiry.do\\?action=sa_detail';
            if (!(empty($ahref_link))) {
                foreach ($ahref_link as $element) {
                    if (ereg($pattern, $element->href)) {
                        if ($lpM == 0) {
                            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com' . $element->href);
                            curl_setopt($ch, CURLOPT_POST, 0);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                            $data = curl_exec($ch);

                            $s = 'วันที่';
                            $html = str_get_html($data);
                            $table = $html->find('table[rules="rows"]', 0);
                            if (!(empty($table))) {
                                foreach ($table->find('tr') as $tr) {
                                    $td1 = clean($tr->find('td', 0)->plaintext);
                                    $pos = strpos($td1, $s);
                                    if ($pos !== false)
                                        continue;
                                    if ($td1 == "ไม่พบรายการนี้.")
                                        continue;


                                    $list = array();
                                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                                    $list['channel'] = clean($tr->find('td', 1)->plaintext);
                                    $list['type'] = clean($tr->find('td', 2)->plaintext);
                                    $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                                    $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 4)->plaintext));
                                    $list['bankno'] = clean($tr->find('td', 5)->plaintext);
                                    $list['info'] = clean($tr->find('td', 6)->plaintext);

                                    $dateTime[] = $list['datetime'];

                                    $listTransaction[] = $list;
                                }
                            }
                        }
                    }
                }
            }

            if ($lpM > 0) {
                for ($i = 0; $i < $lpM; $i++) {
                    if ($i != 0) {

                        $html = str_get_html($data);
                        $ahref_link = $html->find('a');
                        if (!(empty($ahref_link))) {
                            $lpS = 0;
                            foreach ($ahref_link as $element) {
                                if (ereg($pattern, $element->href)) {
                                    if ($i == $lpS) {
                                        curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com' . $element->href);
                                        curl_setopt($ch, CURLOPT_POST, 0);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, null);
                                        $data = curl_exec($ch);

                                        $s = 'วันที่';
                                        $html = str_get_html($data);
                                        $table = $html->find('table[rules="rows"]', 0);
                                        if (!(empty($table))) {
                                            foreach ($table->find('tr') as $tr) {
                                                $td1 = clean($tr->find('td', 0)->plaintext);
                                                $pos = strpos($td1, $s);
                                                if ($pos !== false)
                                                    continue;
                                                if ($td1 == "ไม่พบรายการนี้.")
                                                    continue;


                                                $list = array();
                                                $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext));
                                                $list['channel'] = clean($tr->find('td', 1)->plaintext);
                                                $list['type'] = clean($tr->find('td', 2)->plaintext);
                                                $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 3)->plaintext));
                                                $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 4)->plaintext));
                                                $list['bankno'] = clean($tr->find('td', 5)->plaintext);
                                                $list['info'] = clean($tr->find('td', 6)->plaintext);


                                                $dateTime[] = $list['datetime'];

                                                $listTransaction[] = $list;
                                            }
                                        }
                                    }
                                    $lpS++;
                                }
                            }
                        }
                    }
                }
            }















            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            curl_setopt($ch, CURLOPT_URL, 'https://online.kasikornbankgroup.com/K-Online/checkSession.jsp');
            $data = curl_exec($ch);


            // Balance page
            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/cashmanagement/AccountDetail.do');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, null);
            $data = curl_exec($ch);

            $data = iconv("windows-874", "utf-8", $data);

            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form[name="DetailForm"] input') as $element) {
                $form_field[$element->name] = $element->value;
            }
// select account
            $s = $ACCOUNT_NAME;
            foreach ($html->find('select[name="accountid"] option') as $element) {
                $text = clean($element->plaintext);
                $pos = strpos($text, $s);
                if ($pos !== false) {
                    $form_field['accountid'] = $element->value;
                }
            }
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

            curl_setopt($ch, CURLOPT_URL, 'https://ebank.kasikornbankgroup.com/retail/cashmanagement/AccountDetail.do?action=view');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            $util = new Utility();
            $listTotal = array();
            $html = str_get_html($data);
            $table = $html->find('table[cellpadding="5"]', 0);
            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $list = array();
                    $list['detail'] = clean($tr->find('td', 0)->plaintext);
                    $list['value'] = clean($tr->find('td', 1)->plaintext);

                    if ($util->isEmpty($list['detail']) || $util->isEmpty($list['value'])) {
                        continue;
                    }

                    $listTotal[] = $list;
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
        $date = date_create(date("d/m/Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'd/m/Y');
    }

    public function _dateFormat($var, $format) {
        $date = str_replace('/', '-', $var);
        return date($format, strtotime($date));
    }

    public function subStringDate($date, $type) {
//        $dd = substr($date, 0, 2);
//        $mm = substr($date, 4, 2);
//        $yyyy = substr($date, 7, 4);
        $str = '';
        if ($type == 'dd') {
            $str = substr($date, 0, 2);
        } else if ($type == 'mm') {
            $str = substr($date, 3, 2);
        } else if ($type == 'yyyy') {
            $str = substr($date, 6, 4);
        }
        return $str;
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
        if ($info[db_kbank] == "N") {
            echo $valids->return_code("1001", "Function not Verify.");
            exit(0);
        }
    }

    public function convertDateSort($date) {
        $date = str_replace("/17 ", "/2017 ", $date);
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        $hhss = substr($date, 10);
        return $yyyy . "/" . $mm . "/" . $dd . " " . $hhss;
    }

}
