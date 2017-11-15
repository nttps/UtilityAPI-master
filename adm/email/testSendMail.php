<?php
include '../common/phpmailer.php';
$mail = new PHPMailer();
$body = "aaaaaaa";

                    
  $mail->CharSet = "utf-8";                         
  $mail->Host = "VPSB17.socsets.com"; // SMTP server
  $mail->Port = 587;                 // set the SMTP port for the GMAIL server
  $mail->Username = "forgotpassword@expwebdesign.com";     // SMTP server username
  $mail->Password = "forgotpassword" ;            // SMTP server password 
  $mail->From = "noreply@expwebdesign.com";
  $mail->FromName = "EXPWEBDESIGN";
  $mail->Subject = "EXPWEBDESIGN : FORGOT PASSWORD";
  $mail->MsgHTML($body);
  $mail->AddAddress("numkangg12@gmail.com");
 
  echo $mail->Send();
?>