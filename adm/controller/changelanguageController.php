<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include '../common/Utility.php';
$util = new Utility();
$type = ($util->isEmptyReg($_GET[lan]) ? "th" : $_GET[lan]);
$_SESSION["lan"] = $type;
if ($type == "th") {
    $_SESSION["selected_lan_pic"] = "th.png";
    $_SESSION["selected_lan_name"] = "TH";
} else {
    $_SESSION["selected_lan_pic"] = "us.png";
    $_SESSION["selected_lan_name"] = "US";
}
$util->setPathXML("../language/language_common.xml");
$util->LanguageConfig($type);
$util->setPathXML("../language/language_page.xml");
$util->LanguageConfig($type);

header("location:$_GET[url]");
