<?php
function clean ($text) {
	$text = trim($text);
	$text = str_replace("&nbsp;", "", $text);
	return $text;
}

function random_string($length = 5) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function getcurrentpath()
{   $curPageURL = "";
    if ($_SERVER["HTTPS"] != "on")
            $curPageURL .= "http://";
     else
        $curPageURL .= "https://" ;
    if ($_SERVER["SERVER_PORT"] == "80")
        $curPageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     else
        $curPageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        $count = strlen(basename($curPageURL));
        $path = substr($curPageURL,0, -$count);
    return $path ;
}
?>