<?php

@session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utility
 *
 * @author 
 */
class Utility {

    protected $_pathXML = "language.xml";
    protected $_parameter = "";
    protected $_imageLoading = "images/preloader.gif";
    protected $_locationRedirectPremissionUser = "index.php";
    protected $_locationRedirectPremissionAdmin = "index.php";
    protected $_limitPaging = 16;
    protected $_email = "nagieos@gmail.com";

    function getEmail() {
        return $this->_email;
    }

    function getPathXML() {
        return $this->_pathXML;
    }

    function getLimitPaging() {
        return $this->_limitPaging;
    }

    function setLimitPaging($limitPaging) {
        $this->_limitPaging = $limitPaging;
    }

    function setPathXML($pathXML) {
        $this->_pathXML = $pathXML;
    }

    function getParameterAjax() {
        return $this->__parameter;
    }

    function ClearParameterAjax() {
        $this->__parameter = "";
    }

    function getImageLoading() {
        return $this->_imageLoading;
    }

    function setImageLoading($imageLoading) {
        $this->_imageLoading = $imageLoading;
    }

    function getlocationRedirectPremissionUser() {
        return $this->_locationRedirectPremissionUser;
    }

    function setlocationRedirectPremissionUser($locationRedirectPremission) {
        $this->_locationRedirectPremissionUser = $locationRedirectPremission;
    }

    function getlocationRedirectPremissionAdmin() {
        return $this->_locationRedirectPremissionAdmin;
    }

    function setlocationRedirectPremissionAdmin($locationRedirectPremission) {
        $this->_locationRedirectPremissionAdmin = $locationRedirectPremission;
    }

    function setParameterAjax($variable, $value, $endParameter) {
        $tmp = $variable . "=" . $value;
        $space = "&";
        if ($endParameter) {
            $space = "";
        }

        $this->__parameter = $this->__parameter . $tmp . $space;
    }

    function LanguageConfig($type) {

        $xml = simplexml_load_file($this->_pathXML) or die("Error: Cannot create object");
        foreach ($xml->children() as $languages) {
            if ($type == "th") {
                $_SESSION["$languages->variable"] = (string) $languages->th;
            } else if ($type == "en") {
                $_SESSION["$languages->variable"] = (string) $languages->en;
            }
        }
    }

    function AddModal_Action($modalName, $Action) {
        echo "<script type='text/javascript'>";
        echo "$('#$modalName').modal('$Action');";
        echo "</script>";
    }

    function AddAjaxGetResultResponseText($FunctionName, $element, $path, $modalName) {
        $newline = "\n";
        echo $script = '' . $newline;
        echo $script = '<script type="text/javascript">  ' . $newline;
        echo $script = ' function ' . $FunctionName . '(param,seq) { ' . $newline;
        echo $script = '                   $(\'#' . $modalName . '\').modal(\'show\'); ' . $newline; // parameter $modalName for project biotec
        echo $script = '                var xmlhttp = new XMLHttpRequest();  ' . $newline;
        echo $script = '                xmlhttp.onreadystatechange = function () { ' . $newline;
        echo $script = '                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { ' . $newline;
        echo $script = '                        var result = xmlhttp.responseText.split(","); ' . $newline;
        $cnt = 0;
        foreach ($element as $ele) {
            echo $script = '                        document.getElementById("' . $ele[0] . '").' . $ele[1] . ' = result[' . $cnt++ . ']; ' . $newline;
        }
        /**
         * 
         * @var ****** Start  Sctrip For Reload After read Contact
         * 
         */
        echo $script = '                  update_icon_text(seq);  ' . $newline;
        echo $script = '                   unloading();  ' . $newline;
        /**
         * 
         * @var ****** End  Sctrip For Reload After read Contact
         * 
         */
        echo $script = '                    } ' . $newline;
        echo $script = '                } ' . $newline;
        echo $script = '              ' . $newline;
        echo $script = '                xmlhttp.open("GET", "' . $path . '?" + param, true); ' . $newline;
        echo $script = '                xmlhttp.send(); ' . $newline;
        echo $script = '        } ' . $newline;
        echo $script = "  </script> " . $newline;
        ############################################ AJAX STEP BY STEP ##########################################
//        $util = new Utility();
//
//        //Set -> ElementID , Properties 
//        $element = array(
//            array("par", "innerHTML"),
//            array("txt1", "innerHTML"),
//            array("txtfield", "value")
//        ); 
//        //Set -> FunctionName , Element , PhpAjaxFile , modalName
//                $util->AddAjaxGetResultResponseText("ABC", $element, "ajax.php" ,"modalName")
//                $util->ClearParameterAjax(); 
//                $util->setParameterAjax("param", $i, TRUE);
//        <input type="button" value="OK" onclick="ABC('<?= $util->getParameterAjax() >');"/>
        ########################################## AJAX STEP BY STEP ##########################################
    }

    function setScriptPageLoading($loadJS_Client, $sec) {
        $sec = $sec * 1000;
        if ($loadJS_Client) {
            echo "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script>\n";
            echo "<script src='http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js'></script>\n";
        } else {
            echo "<script src='js/jquery1.5.2.js'></script>\n";
            echo "<script src='js/modern.js'></script>\n";
        }
        echo "<script> $(window).load(function () { $('.se-pre-con').delay(" . $sec . ").fadeOut('slow');   }); </script>\n";
    }

    function setCSSPageLoading() {
        $CSS = "";
        $CSS .= "<style> ";
        $CSS .= " ";
        $CSS .= "            .no-js #loader { display: none;  } ";
        $CSS .= "            .js #loader { display: block; position: absolute; left: 100px; top: 0; } ";
        $CSS .= "            .se-pre-con { ";
        $CSS .= "                width:100%; ";
        $CSS .= "                height:100%; ";
        $CSS .= "                position:fixed; ";
        $CSS .= "                top:0; ";
        $CSS .= "                left:0; ";
        $CSS .= "                z-index:999; ";
        $CSS .= "                background: rgba(255,255,255,.5) url(" . $this->_imageLoading . ")    no-repeat; ";
        $CSS .= "                background-size: 250px 150px; ";
        $CSS .= "                background-position: center center; ";
        $CSS .= "            } ";
        $CSS .= "        </style> ";

        echo $CSS;
    }

    function getPageLoading($loadJS_Client, $sec) {
        $this->setCSSPageLoading();
        $this->setScriptPageLoading($loadJS_Client, $sec);
        echo " <div class='se-pre-con' > </div>";
    }

    function CheckPermissionAdmin($Admin) {
        if ($Admin == null || $Admin == "") {
            header("location:" . $this->_locationRedirectPremissionAdmin);
        }
    }

    function CheckPermissionUser($User) {

        if ($User == null || $User == "") {
            header("location:" . $this->_locationRedirectPremissionUser);
        }
    }

    function isEmptyReg($value) {
        if ($value == null || $value == "") {
            return TRUE;
        } else {
            if (preg_match("/[^A-Za-z0-9]/", $value)) {
                return TRUE;
            }
            return FALSE;
        }
    }

    function isEmpty($tmp) {
        if ($tmp == NULL || trim($tmp) == '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function countObject($_data) {
        $no = 0;
        foreach ($_data as $key => $value) {
            $no++;
        }
        return $no;
    }

    function ContinueObject($page, $seq) {
        $max = $page * $this->_limitPaging;
        $min = $max - $this->_limitPaging;
        if (($seq > $min) && ($seq <= $max)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function CopyTemplatedMail($filemain, $filecopy, $msg) {
        $templatedMail = fopen($filemain, "r") or die("Unable to open file!");
        $txt = fread($templatedMail, filesize($filemain));
        fclose($templatedMail);
        $txt = eregi_replace("&detail;", $msg, $txt);
        $txt = eregi_replace("http://localhost/nagieos/app/nagieos/email/", "../email/", $txt);
        $txt = eregi_replace("http://sbobetsexy.com/app/nagieos/email/", "../email/", $txt);

        $temp = fopen($filecopy, "w") or die("Unable to open file!");
        fwrite($temp, $txt);
        fclose($temp);
    }

    function CopyTemplatedMailForgot($filemain, $filecopy, $name, $lastname, $user, $password) {
        $templatedMail = fopen($filemain, "r") or die("Unable to open file!");
        $txt = fread($templatedMail, filesize($filemain));
        fclose($templatedMail);
        $txt = eregi_replace("&to;", $name . " " . $lastname, $txt);
        $txt = eregi_replace("&username;", $user, $txt);
        $txt = eregi_replace("&password;", $password, $txt);
        $txt = eregi_replace("http://localhost/nagieos/app/nagieos/email/", "../email/", $txt);
        $txt = eregi_replace("http://sbobetsexy.com/app/nagieos/email/", "../email/", $txt);

        $temp = fopen($filecopy, "w") or die("Unable to open file!");
        fwrite($temp, $txt);
        fclose($temp);
    }

    public function DateSQL($date) {

        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        return $yyyy . "-" . $mm . "-" . $dd;
    }

    public function DateSelectSQL($date) {

        $dd = substr($date, 0, 2);
        $mm = substr($date, 4, 2);
        $yyyy = substr($date, 7, 4);
        return $yyyy . "-" . $mm . "-" . $dd;
    }

    public function DateSql2d_dmm_yyyy($date) {

        $yyyy = substr($date, 0, 4);
        $mm = substr($date, 5, 2);
        $dd = substr($date, 8, 2);
        return $dd . "-" . $mm . "-" . $yyyy;
    }

    public function DateSql2ddmmyyyy($date) {

        $yyyy = substr($date, 0, 4);
        $mm = substr($date, 5, 2);
        $dd = substr($date, 8, 2);
        return $dd . "/" . $mm . "/" . $yyyy;
    }

    public function TimeSql2hh($time) {
        $hh = substr($time, 0, 2);
        return $hh;
    }

    public function TimeSql2mi($time) {
        $mi = substr($time, 3, 2);
        return $mi;
    }

    function dateTimeAgo($dt) {
        date_default_timezone_set('Asia/Bangkok');
        $strStart = new DateTime($dt);
        $strEnd = new DateTime('now');
        $dteDiff = $strStart->diff($strEnd);
        $day = (Integer) $dteDiff->format("%d");
        $hour = (Integer) $dteDiff->format("%H");
        $min = (Integer) $dteDiff->format("%i");
        $sec = (Integer) $dteDiff->format("%s");
        if ($day > 0) {
            return $day . " " . $_SESSION[ago_day];
        }
        if ($hour > 0) {
            return $hour . " " . $_SESSION[ago_hour];
        }
        if ($min > 0) {
            return $min . " " . $_SESSION[ago_min];
        }
        if ($min <= 0) {
            return $_SESSION[ago_now];
        }
    }

    function arr2strQuery($arr, $type) {
        $i = 1;
        $tmp = "";
        $fl = "";
        if ($type == "S") {
            $fl = "'";
        }
        foreach ($arr as $value) {
            $tmp .= $fl . $value . $fl;
            if (count($arr) != $i) {
                $tmp .= ",";
            }

            $i++;
        }
        return $tmp;
    }

    public function validAccountKBANK($str) {
        $re = '/^[0-9]{3}-[0-9]{1}-[0-9]{5}-[0-9]{1}$/i';
//        $str = '025-5-55547-1';
        if (preg_match($re, $str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function range_date($i) {
        $date = date_create(date("d-m-Y", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' days')), 'd-m-Y');
    }

    public function return_code($code, $description) {
        $return_code = array(
            'code' => $code,
            'description' => $description
        );
        return json_encode($return_code);
    }

    function json_decode($jsonString) {
        return json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $jsonString), true);
    }

}
