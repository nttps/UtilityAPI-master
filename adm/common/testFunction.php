<?php

include './phpmailer.php';
$mail = new PHPMailer(TRUE);

$mail->Host = "expwebdesign.com";
$mail->Hostname = "expwebdesign.com";
$mail->Port = 25;
$mail->CharSet = 'utf-8';
$mail->From = "noreply@expwebdesign.com";
$mail->FromName = "EXPWEBDESIGN";
$mail->Subject = "EXPWEBDESIGN : FORGOT PASSWORD";
$mail->Username = "demo@expwebdesign.com";
$mail->Password = "p@ssw0rd";
$mail->MsgHTML("test send mail");
$mail->AddAddress("natdanaimon@gmail.com");
echo $mailcommit = $mail->Send();


echo "send seccess !";
?>