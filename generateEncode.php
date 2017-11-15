<?php
error_reporting(0);
include './function.php';
include './simple_html_dom.php.php';
$random_key = random_string(12);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <meta content="nagieos , NAGIEOS , NAGIEOS SYSTEM MANAGEMENTT"
          name="description" />

    <link rel="apple-touch-icon" href="apple-touch-icon.png"/>
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png"/>

    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all"/>
    <title>NAGIEOS API SERVICE</title>
    <script type="text/javascript" src="testAPI.min.js"></script>
    <script type="text/javascript" src="js/site.js"></script>
    <link rel="shortcut icon" href="favicon.ico" /> 

</head>
<body>

    <div class="container-fluid bank-container">
        <div class="row-fluid">
            <div class="span12">
                <div class="box-wrap">
                    <div class="box">
                        <div class="bank-detail">
                            <div class="encode-wrap">
                                <div class="title">Generate Key Endcode</div> <br/>

                                <form action="" method="post">
                                    <input type="hidden" name="action" value="encode" />
                                    <div>
                                        <label><strong>คีย์สำหรับการเข้ารหัส</strong></label>
                                        <input type="text" name="key" value="<?php echo $random_key; ?>" class="span4">

                                    </div>

                                    <div>
                                        <label><strong>ชื่อผู้ใช้งาน อินเตอร์เน็ตแบงค์กิ้ง</strong></label>
                                        <input type="text" name="username" class="span4">
                                    </div>

                                    <div>
                                        <label><strong>รหัสผ่าน อินเตอร์เน็ตแบงค์กิ้ง</strong></label>
                                        <input type="password" name="password" class="span4">
                                    </div>

                                    <div>
                                        <label><strong>เลขที่บัญชีธนาคาร (123-4-56789-0)</strong></label>
                                        <input type="text" name="account_no" placeholder="123-4-56789-0" class="span4">
                                    </div>

                                    <div>
                                        <label><strong>ชื่อผู้ใช้งาน Captcha</strong></label>
                                        <input type="text" name="captcha_username" class="span4">
                                    </div>

                                    <div>
                                        <label><strong>รหัสผ่าน Captcha</strong></label>
                                        <input type="password" name="captcha_password" class="span4">
                                    </div>




                                    <button type="submit"  class="btn btn-primary">ตกลง</button>
                                    <br />
                                    <br />

                                </form>


                                <?php
                                $text = '';
                                if (!empty($_POST['key'])) {
                                    $key = $_POST['key'];

                                    if (!(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['account_no']))) {
                                        $string = $_POST['username'];
                                        $encryptedUser = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));

                                        $string = $_POST['password'];
                                        $encryptedPass = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));

                                        $accountNo .= $_POST['account_no'];

                                        $string = $_POST['captcha_username'];
                                        $encryptedUserCaptcha = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));

                                        $string = $_POST['captcha_password'];
                                        $encryptedPassCaptcha = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));




                                        echo "<h3><strong>Encode For Test API</strong></h3>";
//                                        echo "<hr>";
                                        echo "<strong>Key</strong> : <font color='blue'>" . $key . "</font><br/>";
                                        echo "<strong>Encode Username</strong> : <font color='blue'>" . $encryptedUser . "</font><br/>";
                                        echo "<strong>Encode Password</strong> : <font color='blue'>" . $encryptedPass . "</font><br/>";
                                        echo "<strong>Account No</strong> : <font color='blue'>" . $accountNo . "</font><br/>";
                                        echo "<strong>Encode Username Captcha</strong> : <font color='blue'>" . $encryptedUserCaptcha . "</font><br/>";
                                        echo "<strong>Encode Password Captcha</strong> : <font color='blue'>" . $encryptedPassCaptcha . "</font><br/>";

                                        echo "<br/><br/>";
                                        echo "<h3><strong>Encode For PHP TEST API</strong></h3>";
//                                        echo "<hr>";
                                        echo "<strong>\$KEY</strong> = <font color='blue'>'" . $key . "';</font><br/>";
                                        echo "<strong>\$USERNAME</strong> = <font color='blue'>'" . $encryptedUser . "';</font><br/>";
                                        echo "<strong>\$PASSWORD</strong> = <font color='blue'>'" . $encryptedPass . "';</font><br/>";
                                        echo "<strong>\$ACCOUNT_NAME</strong> = <font color='blue'>'" . $accountNo . "';</font><br/>";
                                        echo "<strong>\$captcha_username</strong> = <font color='blue'>'" . $encryptedUserCaptcha . "';</font><br/>";
                                        echo "<strong>\$captcha_password</strong> = <font color='blue'>'" . $encryptedPassCaptcha . "';</font><br/>";
                                    } else {
                                        echo "<strong><font color='blue'> กรุณากรอกข้อมูลให้ครบถ้วน </font></strong> <br/>";
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>