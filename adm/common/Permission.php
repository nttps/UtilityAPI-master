<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
if ($_SESSION["username"] == null || $_SESSION["username"] == "") {
    header("location:index.php");
    exit(0);
}
if ($_SESSION["perm"] == null || $_SESSION["perm"] == "") {
    header("location:index.php");
    exit(0);
}

if ($_SESSION[mode_lock] != NULL) {
    $mode_lock = (boolean) $_SESSION[mode_lock];
    if ($mode_lock) {
        header("location:lock_screen.php");
        exit(0);
    }
}

//$disable = ($_SESSION["perm"] == "U" ? "disabled='disabled'" : "");
//$readonly = ($_SESSION["perm"] == "U" ? "readonly='readonly'" : "");
//$hidden = ($_SESSION["perm"] == "U" ? "style='display:none;'" : "");

$disable = "";
$readonly = "";
$hidden = "";
?>
