<?php
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('Asia/Bangkok');
error_reporting(0);
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>NAGIEOS API SERVICE</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="nagieos , NAGIEOS , NAGIEOS SYSTEM MANAGEMENTT"
              name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="row">
                    <a href="generateEncode.php" target="_bank"><h1>Click Generate Key Endcode</h1></a>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <image src="images/tw.png" width="100px" height="40px"/> True Wallet<br/><br/>
                        <form  id="form-tw" class="login-form" name="form-tw"  method="post">

                            <div class="row">

                                <input type="hidden" name="func" id="func" value="InquiryTransaction"> <br/>
                                Key : <input type="text" name="key" id="key" value="QKFbUvNqe0Co"><br/>
                                Username : <input type="text" name="username" id="username" value="BeWUriY0h8Ayf8qKhrBq9uRyxt5X3rWpPcHiisZtf38="><br/>
                                Password : <input type="text" name="password" id="password" value="mAus0dJED1QJI3gFfj/iRbZasJoO8BEsr66A88ml9z0="><br/>
                                <!--Account No : <input type="text" name="account" id="account" value=""><br/>-->
                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>"> 
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos"><br/>
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="tw()" type="button" >Load Transaction True Wallet</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <br/><br/>
                    <div class="login-content">
                        <image src="images/kbank.png" width="50px" height="40px"/> ธนาคารกสิกร<br/><br/>
                        <form  id="form-kbank" class="login-form" name="form-kbank"  method="post">

                            <div class="row">

                                <input type="hidden" name="func" id="func" value="InquiryTransaction"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>"> 
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos"><br/>
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="kbank()" type="button" >Load Transaction KBANK</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <br/><br/>
                    <div class="login-content">
                        <image src="images/scb.png" width="50px" height="40px"/> ธนาคารไทยพาณิชย์<br/><br/>
                        <form  id="form-scb" class="login-form" name="form-scb"  method="post">

                            <div class="row">

                                <input type="hidden" name="func" id="func" value="InquiryTransaction"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos"><br/>
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="scb()" type="button" >Load Transaction SCB</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <br/><br/>
                    <div class="login-content">
                        <image src="images/bbl.png" width="50px" height="40px"/> ธนาคารกรุงเทพ<br/><br/>
                        <form  id="form-bbl" class="login-form" name="form-bbl"  method="post">

                            <div class="row">

                                <input type="hidden" name="func" id="func" value="InquiryTransaction"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
<!--                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>"> -->
                                <input type="hidden" name="d_start" id="d_start" value="01/03/2017"> 
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos"><br/>
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="bbl()" type="button" >Load Transaction BBL</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <br/><br/>
                    <div class="login-content">
                        <image src="images/bay.png" width="50px" height="40px"/> ธนาคารกรุงศรี<br/><br/>
                        <form  id="form-bay" class="login-form" name="form-bay"  method="post">

                            <div class="row">

                                <input type="hidden" name="func" id="func" value="InquiryTransaction"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos"><br/>
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="bay()" type="button" >Load Transaction BAY</button>
                                </div>
                            </div>
                        </form>

                    </div>



                    <br/><br/>
                    <div class="login-content">
                        <image src="images/ktb.png" width="50px" height="40px"/> ธนาคารกรุงไทย<br/><br/>
                        <form  id="form-ktb-no-capcha" class="login-form" name="form-ktb-no-capcha"  method="post">

                            <div class="row">
                                <input type="hidden" name="func" id="func" value="InquiryTransactionCaptchaAuto"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
                                Captcha Username : <input type="text" name="captcha_username" id="captcha_username" value=""><br/>
                                Captcha Password : <input type="text" name="captcha_password" id="captcha_password" value=""><br/>
                                <!-- <p> Captcha : <img id="captcha" src="images/preloader.gif" width="150" height="50"/></p>
                                <p><input type="text" name="imageCode" value="" class="span4" autocomplete="off"/></p>-->
                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>"> <br/>
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>"> 
                                <input type="hidden" name="folder_domain" id="folder_domain" value="nagieos">
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos">
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">

                                    <button class="btn green" id="btn-login" onclick="ktb_login_no_captcha()" type="button" >Load Transaction KTB</button>
                                    <br/><br/>
                                    Encode Captcha By  <a href="http://www.deathbycaptcha.com/user/login" target="_bank"> http://www.deathbycaptcha.com/user/login </a>
                                </div>
                            </div>
                        </form>

                    </div>
                    <br/><br/>
                    <div class="login-content">
                        <image src="images/ktb.png" width="50px" height="40px"/> ธนาคารกรุงไทย Captcha<br/><br/>
                        <form  id="form-ktb-capcha" class="login-form" name="form-ktb-capcha"  method="post">

                            <div class="row">
                                <input type="hidden" name="func" id="func" value="InquiryTransactionCaptcha"> <br/>
                                Key : <input type="text" name="key" id="key" value=""><br/>
                                Username : <input type="text" name="username" id="username" value=""><br/>
                                Password : <input type="text" name="password" id="password" value=""><br/>
                                Account No : <input type="text" name="account" id="account" value=""><br/>
                                <p> Captcha : <img id="captcha" src="images/preloader.gif" width="150" height="50"/>
                                    <button class="btn green" id="btn-getCaptcha" onclick="GetCaptcha()" type="button" >GetCaptcha</button>
                                </p>

                                <p><input type="text" id="imageCode" name="imageCode" value="" class="span4" autocomplete="off"/></p>
                                <input type="hidden" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>">
                                <input type="hidden" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>"> 
                                <input type="hidden" name="folder_domain" id="folder_domain" value="nagieos">
                                <input type="hidden" name="domain" id="domain" value="<?= $_SERVER['HTTP_HOST'] ?>">
                                <input type="hidden" name="license" id="license" value="nagieos">
                            </div>
                            <div class="row">

                                <div class="col-sm-8 text-right">
                                    <button class="btn green" id="btn-login" onclick="ktb_login_captcha()" type="button" >Load Transaction KTB</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <br/><br/>










                    <div id="output"></div>




                    <div class="login-footer">
                        <div class="row bs-reset">
                            <br/><br/> <br/><br/>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>Copyright © NAGIEOS 2017</p>
                                </div>
                                <div>
                                    <p id="testapi"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include './common/Utility.php';
        $util = new Utility();
        $util->setCSSPageLoading();
        ?>
        <div class='se-pre-con' id="se-pre-con" > </div>
        <script src="testAPI.min.js?x=<?= time() ?>" type="text/javascript"></script>
        <script src="testAPI.js?x=<?= time() ?>" type="text/javascript"></script>

    </body>

</html>