<?php
@session_start();
$_SESSION[mode_lock] = TRUE;

?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= $_SESSION[title] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?= $_SESSION[title_content] ?>"    name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../assets/pages/css/lock-2.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="">
        <div class="page-lock">
            <div class="page-logo">
<!--                <a class="brand" href="index.php">
                    <img src="images/logo/logo_002.jpg" alt="logo" /> </a>-->
            </div>
            <div class="page-body">
                <img class="page-lock-img" src="images/profile/<?= $_SESSION[img_profile]?>" alt="">
                <div class="page-lock-info">
                    <h1><?= $_SESSION[full_name] ?></h1>
                    <span class="email"> <?= $_SESSION[user_email] ?> </span>
                    <span class="locked"> <?= $_SESSION[lock_screen] ?> </span>
                    <form id="form-login" class="login-form" name="form-login"  method="post">
                        <div class="input-group input-medium">
                            <input type="hidden" id="func" name="func" value="login" />
                            <input type="hidden" id="username" name="username" value="<?= $_SESSION[username] ?>" />
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                            <span class="input-group-btn">
                                <button type="button" class="btn green icn-only" id="btn-login" onclick="login()">
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                        <div class="relogin">
                            <a href="index.php"> <?= $_SESSION[no_user] ?> <?= $_SESSION[full_name] ?> ? </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="page-footer-custom"> Copyright © EXPWEBDESIGN 2017   </div>
        </div>
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/lock-2.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="js/common/notify.js" type="text/javascript"></script>
        <?php
        include './common/Utility.php';
        $util = new Utility();
        $util->setCSSPageLoading();
        ?>
        <div class='se-pre-con' id="se-pre-con" > </div>

        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <script src="js/action/login.js" type="text/javascript"></script>
    </body>

</html>