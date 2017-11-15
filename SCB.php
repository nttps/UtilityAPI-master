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




$controller = new SCB();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
}

class SCB {

    public function __construct() {
        require_once './simple_html_dom.php';
        require_once './function.php';
        require_once './common/Utility.php';
        require_once './common/license.php';
    }

    public function date_minus($i) {
        $date = date_create(date("d/m/Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'd/m/Y');
    }

    function InquiryTransaction($info) {



        if ($this->valid($info) == 1) {
            $process = new Utility();

            $info = $this->getValueLicense($info);
            $this->licenseVerify($info);






            $PATH = dirname(__FILE__) . '/';
            $COOKIEFILE = $PATH . 'protect/scb-cookies';
            $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
            $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
//            $USERNAME = $info[username];
//            $PASSWORD = $info[password];
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
//            curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);

            $acc_id = 0;

            $form_field = array();

            $form_field['LOGIN'] = $USERNAME;
            $form_field['PASSWD'] = $PASSWORD;
            $form_field['LANG'] = 'T';
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);

// login
            curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/lgn/login.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);


            //echo "76 : ".$data; return;

            $html = str_get_html("$data");
//              echo "79"; return;
            $sessioneasy = $html->find('input[name="SESSIONEASY"]', 0)->value;
//              echo "80"; return;



            $form_field = array();
            $form_field['SESSIONEASY'] = $sessioneasy;
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);
            curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_mpg.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

// get AccBal ID
            $html = str_get_html($data);
            foreach ($html->find('a[id*="DataProcess_SaCaGridView_SaCa_LinkButton_"]') as $a) {
                $text = $a->outertext;
                $s = substr($ACCOUNT_NAME, 4);
                $pos = strpos($text, $s);
                if ($pos !== false) {
                    $href = htmlspecialchars_decode($a->href, ENT_QUOTES);
                    $href = str_replace("javascript:__doPostBack('", '', $href);
                    $href = str_replace("','')", '', $href);
                    $acc_href = $href;
                    break;
                }
            }



            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $form_field['__EVENTTARGET'] = $acc_href;
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }
            $post_string = substr($post_string, 0, -1);
            curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_mpg.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            /**
             * 
             * @var ******** Used with acc_bnk_tst
             * 
             */
            $acc_bnk_tst = $data;



            $util = new Utility();
            // #f1 form redirect
            $html = str_get_html($data);
            $form_field = array();
            foreach ($html->find('form#f1 input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }




            $post_string = substr($post_string, 0, -1);
            curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_bln.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);

            $acc_bnk_blance = $data;

// filter table
            $html = str_get_html($data);
            $table = $html->find('table[cellpadding="2"]', 0);
            $listTotal = array();

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




// #f1 form redirect
//            $html = str_get_html($data);
            $html = str_get_html($acc_bnk_tst);
            $form_field = array();
            foreach ($html->find('form#f1 input') as $element) {
                $form_field[$element->name] = $element->value;
            }
            $post_string = '';
            foreach ($form_field as $key => $value) {
                $post_string .= $key . '=' . urlencode($value) . '&';
            }


            $listTransaction = array();
            $util = new Utility();
            $post_string = substr($post_string, 0, -1);
            curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_tst.aspx');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            $data = curl_exec($ch);



// filter table
            $html = str_get_html($data);
            $table = $html->find('table#DataProcess_GridView', 0);
            $s = 'วันที่'; //iconv("windows-874", "utf-8", 'วันที่');
            $s2 = 'รวม'; //iconv("windows-874", "utf-8", 'รวม');

            if (!(empty($table))) {
                foreach ($table->find('tr') as $tr) {
                    $td1 = clean($tr->find('td', 0)->plaintext);
                    if ($util->isEmpty($td1)) {
                        continue;
                    }

                    $pos = strpos($td1, $s);
                    if ($pos !== false) {
                        continue;
                    }
                    $pos = strpos($td1, $s2);
                    if ($pos !== false) {
                        continue;
                    }

                    $list = array();
                    $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext)) . " " . clean($tr->find('td', 1)->plaintext);
                    $list['transactionCode'] = clean($tr->find('td', 2)->plaintext);
                    $list['channel'] = clean($tr->find('td', 3)->plaintext);
                    $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 4)->plaintext));
                    $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 5)->plaintext));
                    $list['info'] = clean($tr->find('td', 6)->plaintext);


                    $dateTime[] = $list['datetime'];


                    $listTransaction[] = $list;
                }
            }




            //load page history
//            $html = str_get_html($acc_bnk_blance);

            if ($info[db_function] != "LV1") {
                $html = str_get_html($data);
                $form_field = array();
                foreach ($html->find('form#f1 input') as $element) {
                    $form_field[$element->name] = $element->value;
                }
                $post_string = '';
                foreach ($form_field as $key => $value) {
                    $post_string .= $key . '=' . urlencode($value) . '&';
                }




                $post_string = substr($post_string, 0, -1);
                curl_setopt($ch, CURLOPT_REFERER, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_bln.aspx');
                curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_hst.aspx');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
                $data = curl_exec($ch);





                //find data page history
                $form_field = array();
                $html = str_get_html($data);
                foreach ($html->find('form[id="form1"] input') as $element) {
                    $form_field[$element->name] = $element->value;
                }


                $date = $this->date_minus(1);
                $dd = substr($date, 0, 2);
                $mm = substr($date, 3, 2);
                $yyyy = substr($date, 6, 4);







                $form_field['__EVENTTARGET'] = 'ctl00$DataProcess$ddlMonth';
                $form_field['ctl00$DataProcess$ddlMonth'] = $mm . $yyyy;
                $form_field['SESSIONEASY'] = $sessioneasy;
                unset($form_field['ctl00$DataProcess$btnBack']);

                $post_string = '';
                foreach ($form_field as $key => $value) {
                    $post_string .= $key . '=' . urlencode($value) . '&';
                }
                $post_string = substr($post_string, 0, -1);
                //curl_setopt($ch, CURLOPT_REFERER, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_hst.aspx');
                curl_setopt($ch, CURLOPT_URL, 'https://www.scbeasy.com/online/easynet/page/acc/acc_bnk_hst.aspx');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
                $data = curl_exec($ch);


                $html = str_get_html($data);
                $table = $html->find('table#DataProcess_GridView', 0);

//            if($table!=NULL){
//                echo "table success";

                if (!(empty($table))) {
                    foreach ($table->find('tr') as $tr) {
                        $td1 = clean($tr->find('td', 0)->plaintext);
                        if ($util->isEmpty($td1)) {
                            continue;
                        }

                        $pos = strpos($td1, $s);
                        if ($pos !== false) {
                            continue;
                        }
                        $pos = strpos($td1, $s2);
                        if ($pos !== false) {
                            continue;
                        }

                        $list = array();
                        $list['datetime'] = $this->convertDateSort(clean($tr->find('td', 0)->plaintext)) . " " . clean($tr->find('td', 1)->plaintext);
                        $list['transactionCode'] = clean($tr->find('td', 2)->plaintext);
                        $list['channel'] = clean($tr->find('td', 3)->plaintext);
                        $list['out'] = (float) str_replace(',', '', clean($tr->find('td', 6)->plaintext));
                        $list['in'] = (float) str_replace(',', '', clean($tr->find('td', 7)->plaintext));
                        $list['info'] = clean($tr->find('td', 4)->plaintext);


                        if ($info[db_function] == "LV2") {
                            if ($date == clean($tr->find('td', 0)->plaintext)) {
                                $dateTime[] = $list['datetime'];
                                $listTransaction[] = $list;
                            }
                        } else if ($info[db_function] == "LV3") {
                            $dateTime[] = $list['datetime'];
                            $listTransaction[] = $list;
                        }
                    }
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
        if ($info[db_scb] == "N") {
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
