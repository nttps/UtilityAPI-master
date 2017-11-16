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
$info[func] = "InquiryTransaction";
$controller = new TMB();
switch ($info[func]) {
    case "InquiryTransaction":
        echo $controller->InquiryTransaction($info);
        break;
    default: echo json_encode(array('code' => '9999', 'description' => 'Call function Fail'));
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
//        if ($this->valid($info) == 1) {
        $process = new Utility();
//            $info = $this->getValueLicense($info);
//            $this->licenseVerify($info);
        $PATH = dirname(__FILE__) . '/';
        $COOKIEFILE = $PATH . 'protect/tmb-cookies';
        $USERNAME = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[username]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
        $PASSWORD = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($info[key]), base64_decode($info[password]), MCRYPT_MODE_CBC, md5(md5($info[key]))), "\0");
        $ACCOUNT_NAME = str_replace("-", "", $info[account]);
        $USERNAME = "natdanai2533";
        $PASSWORD = "Na12345678";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/authService/100000004/appconfig");


        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Kony-App-Secret: 9bca06a1518df6af31382131cd911009",
            "X-Kony-App-Key: ae8cd4fb292a12727a4833c9fdb8ccb0"
        ));



        $response = curl_exec($ch);
        $jsonAppconfig = json_decode($response, true);

        //=================================================================================

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/authService/100000002/login");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Kony-SDK-Version: SDK-GA-7.3.0.9",
            "X-Kony-App-Secret: 9bca06a1518df6af31382131cd911009",
            "X-Kony-Platform-Type: windows",
            "X-Kony-App-Key: ae8cd4fb292a12727a4833c9fdb8ccb0",
            "X-Kony-SDK-Type: js"
        ));

        $response = curl_exec($ch);
        $jsonLogin = json_decode($response, true);

        //=================================================================================

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/getPhrases");
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Kony-Authorization: " . $jsonLogin["claims_token"]["value"],
            "X-Kony-API-Version: 1.0"
        ));

        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['timestamp'] = '';
        $form_field['localeId'] = 'en_US';
        $form_field['platform1'] = 'D';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'getPhrases';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = '';
        $form_field['httpheaders'] = '{}';
        $form_field['konyreportingparams'] = $this->getKony($jsonAppconfig, "frmIBPreLogin", "getPhrases");

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);


        $response = curl_exec($ch);
        $jsonGetPhrases = json_decode($response, true);



        //=================================================================================



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $COOKIEFILE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $PATH . "cacert.pem");
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/GetCampaign");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Kony-Authorization: " . $jsonLogin["claims_token"]["value"],
            "X-Kony-API-Version: 1.0"
        ));

        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['widgetName'] = 'segCampaignImage';
        $form_field['formName'] = 'frmIBPreLogin';
        $form_field['appChannel'] = 'I';
        $form_field['prelogin'] = 'Y';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'GetCampaign';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = '';
        $form_field['httpheaders'] = '{}';
        $form_field['konyreportingparams'] = $this->getKony($jsonAppconfig, "frmIBPreLogin", "GetCampaign");

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        
        
        $response = curl_exec($ch);
        $jsonGetCampaign = json_decode($response, true);
        print_r($jsonGetCampaign);
        
        
        
        
        
        
        
        exit(0);












































        curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "accept-language: th-TH, th;
        q = 0.8",
                "x-kony-app-key: ae8cd4fb292a12727a4833c9fdb8ccb0",
                "x-kony-app-secret: 9bca06a1518df6af31382131cd911009",
                "x-kony-platform-type: windows",
                "x-kony-sdk-type: js",
                "x-kony-sdk-version: SDK-GA-7.3.0.9"
            ),
        ));
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/authService/100000002/login");
        $response = curl_exec($ch);
        $jsonLogin = json_decode($response, true);

        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));
        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['widgetName'] = 'segCampaignImage';
        $form_field['formName'] = 'frmIBPreLogin';
        $form_field['appChannel'] = 'I';
        $form_field['prelogin'] = 'Y';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'GetCampaign';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = '';
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBPreLogin", "GetCampaign");
        $form_field['konyreportingparams'] = $konyreportingparams;

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/GetCampaign");
        $response = curl_exec($ch);
        $jsonCampaign = json_decode($response, true);
        print_r($jsonCampaign);
        exit(0);


        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "host: www.tmbdirect.com",
                "origin: https://www.tmbdirect.com",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));

        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['loginId'] = $USERNAME;
        $form_field['userid'] = $USERNAME;
        $form_field['password'] = $PASSWORD;
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'IBVerifyLoginEligibility';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = $jsonCampaign['tknid'];
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBPreLogin", "IBVerifyLoginEligibility");
        $form_field['konyreportingparams'] = $konyreportingparams;
        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService9/IBVerifyLoginEligibility");
        $response = curl_exec($ch);
        $IBVerfiy = json_decode($response, true);
        //LoginProcessServiceExecute
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "Connection: keep-alive",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "host: www.tmbdirect.com",
                "origin: https://www.tmbdirect.com",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));

        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['rqUUId'] = '';
        $form_field['LoginInd'] = 'login';
        $form_field['TriggerEmail'] = 'true';
        $form_field['activationCompleteFlag'] = 'login';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'LoginProcessServiceExecuteIB';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = $IBVerfiy['tknid'];
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBPreLogin", "LoginProcessServiceExecuteIB");
        $form_field['konyreportingparams'] = $konyreportingparams;

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/LoginProcessServiceExecuteIB");
        $response = curl_exec($ch);
        $ecuteIB = json_decode($response, true);
        //customerAccountInquiry
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "host: www.tmbdirect.com",
                "origin: https://www.tmbdirect.com",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));

        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['activationCompleteFlag'] = 'true';
        $form_field['upgradeSkip'] = '';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'customerAccountInquiry';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = $IBVerfiy['tknid'];
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBPreLogin", "customerAccountInquiry");
        $form_field['konyreportingparams'] = $konyreportingparams;

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService5/customerAccountInquiry");
        $response = curl_exec($ch);
        $accountInquiry = json_decode($response, true);
        //CalendarInquiry
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "host: www.tmbdirect.com",
                "origin: https://www.tmbdirect.com",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));
        //setDate for search Transaction
        $dateStart = $this->date_minus(30);
        $dateEnd = $this->date_minus(0);
        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['startDate'] = $dateStart;
        $form_field['endDate'] = $dateEnd;
        $form_field['bankCd'] = '11';
        $form_field['accountDetailsFromLink'] = '';
        $form_field['reloadFlag'] = '1';

        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'customerAccountInquiry';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = $IBVerfiy['tknid'];
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBPostLoginDashboard", "CalendarInquiry");
        $form_field['konyreportingparams'] = $konyreportingparams;

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/CalendarInquiry");
        $response = curl_exec($ch);
        $accountInquiry = json_decode($response, true);
        echo $response;
        //logout
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: th-TH,th;q=0.8",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "host: www.tmbdirect.com",
                "origin: https://www.tmbdirect.com",
                "pragma: no-cache",
                "referer: https://www.tmbdirect.com/tmb/kdw1.15.7",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
                "x-kony-api-version: 1.0",
                "x-kony-authorization: " . $jsonLogin['claims_token']['value'] . ""),
        ));
        $form_field = array();
        $form_field['events'] = '[]';
        $form_field['channelId'] = '01';
        $form_field['timeOut'] = 'true';
        $form_field['deviceId'] = 'onIdleTimeOutIB';
        $form_field['languageCd'] = 'TH';
        $form_field['appID'] = 'TMBUI';
        $form_field['appver'] = '1.0.12.34';
        $form_field['serviceID'] = 'logOutTMB';
        $form_field['locale'] = 'th_TH';
        $form_field['app_name'] = 'TMBUI';
        $form_field['channel'] = 'wap';
        $form_field['platform'] = 'thinclient';
        $form_field['cacheid'] = '';
        $form_field['tknid'] = $jsonCampaign['tknid'];
        $form_field['httpheaders'] = '{}';
        $konyreportingparams = $this->getKony($jsonAppconfig, "frmIBAccntSummary", "logOutTMB");
        $form_field['konyreportingparams'] = $konyreportingparams;

        $post_string = '';
        foreach ($form_field as $key => $value) {
            $post_string .= $key . '=' . urlencode($value) . '&';
        }
        $post_string = substr($post_string, 0, -1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.tmbdirect.com/services/TMBMIBService0/logOutTMB");
        $response = curl_exec($ch);
        //echo $IBVerfiy;
        //echo $claims_token;
        // echo $data;
        exit(0);
    }

    public function date_minus($i) {
        $date = date_create(date("d.m.Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'd.m.Y');
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

    public function getKony($jsonAppconfig, $fid, $svCID) {
        $konyreportingparams = '{    
            "os": "61",
            "dm": "",
            "did": "1510758722441-cef8-f406-ab99",
            "ua": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
            "aid": "' . $jsonAppconfig['baseId'] . '",
            "aname": "TMBMIB_R76_5",
            "chnl": "desktop",
            "plat": "windows",
            "aver": "1.0.12.34",
            "atype": "spa",
            "stype": "b2c",
            "kuid": "",
            "mfaid": "' . $jsonAppconfig['appId'] . '",
            "mfbaseid": "' . $jsonAppconfig['baseId'] . '",
            "mfaname": "TMBMIB_R76_5",
            "sdkversion": "SDK-GA-7.3.0.9",
            "sdktype": "js",
            "fid": "' . $fid . '",
            "svcid": "' . $svCID . '"
        }';
    }

}
