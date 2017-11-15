<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
if ($_SESSION["perm"] != "A") {
    header("location:index.php");
    exit(0);
}
?>
