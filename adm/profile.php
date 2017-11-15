<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(0);
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
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <!--<link href="../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />-->
        <link href="../assets/pages/css/profile.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php include './templated/header.php'; ?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <?php include './templated/menu.php'; ?>   
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <?php include './templated/theme_panel.php'; ?>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span><?= $_SESSION[home_overview] ?></span>
                                    <i class="fa fa-circle" style="color: #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="profile.php"><?= $_SESSION[myprofile] ?></a>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="images/profile/<?= $_SESSION[img_profile] ?>" class="img-responsive" alt=""> </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <span id="s_fullname"></span> </div>
                                            <div class="profile-usertitle-job"> <span id="s_type"></span> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <!-- END SIDEBAR BUTTONS -->
                                        <!-- SIDEBAR MENU -->
                                        <!-- END MENU -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                    <!-- PORTLET MAIN -->

                                    <!-- END STAT -->

                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN PROFILE CONTENT -->
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase"><?= $_SESSION[tt_profile] ?></span>
                                                    </div>
                                                    <ul class="nav nav-tabs">
                                                        <li id="li-tab1">
                                                            <a href="#tab_1_1" data-toggle="tab" ><?= $_SESSION[lb_pf_Info] ?></a>
                                                        </li>
                                                        <li  id="li-tab2">
                                                            <a href="#tab_1_2" data-toggle="tab" ><?= $_SESSION[lb_pf_image] ?></a>
                                                        </li>
                                                        <li  id="li-tab3">
                                                            <a href="#tab_1_3" data-toggle="tab" ><?= $_SESSION[lb_pf_Password] ?></a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- PERSONAL INFO TAB -->

                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <form  id="form-action" method="post" >
                                                                <input type="hidden" id="func" name="func" value="edit">
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="text" class="form-control bold" id="s_firstname" name="s_firstname" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_pf_name] ?> <span class="required">*</span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="text" class="form-control bold" id="s_lastname" name="s_lastname" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_pf_lastname] ?> <span class="required">*</span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="text" class="form-control bold" id="s_email" name="s_email" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_email] ?> <span class="required">*</span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="text" class="form-control bold" id="s_phone" name="s_phone" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_phone] ?> <span class="required">*</span></label>          
                                                                </div>
                                                            </form>
                                                            <div class="margiv-top-10">
                                                                <a href="dashboard.php" class="btn default"><?= $_SESSION[btn_cancel] ?></a>
                                                                <button type="button" onclick="save()" class="btn green"><?= $_SESSION[btn_ok] ?></button>

                                                            </div>
                                                        </div>

                                                        <!-- END PERSONAL INFO TAB -->
                                                        <!-- CHANGE AVATAR TAB -->
                                                        <div class="tab-pane" id="tab_1_2">
                                                            <form  id="form-action-picture" name="form-action-picture" method="post" enctype="multipart/form-data" >
                                                                <div class="form-group">

                                                                    <input type="hidden" id="func" name="func" value="editPicture">
                                                                    <input type="hidden" id="old_picture" name="old_picture" value="">
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                            <img id="img_profile" name="img_profile" width="100%" height="100%"/> </div>
                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> <?= $_SESSION[btn_select_img] ?> </span>
                                                                                <span class="fileinput-exists"> <?= $_SESSION[btn_change] ?> </span>
                                                                                <input type="file" name="s_image" id="s_image"> </span>
                                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?= $_SESSION[btn_remove] ?> </a>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <br/>
                                                                <div class="margin-top-10">
                                                                    <a href="dashboard.php" class="btn default"><?= $_SESSION[btn_cancel] ?></a>
                                                                    <button  type="submit" class="btn green"><?= $_SESSION[btn_ok] ?></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END CHANGE AVATAR TAB -->
                                                        <!-- CHANGE PASSWORD TAB -->
                                                        <div class="tab-pane" id="tab_1_3">
                                                            <form  id="form-action-password" method="post" >
                                                                <input type="hidden" id="func" name="func" value="editPassowrd">

                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="password" class="form-control bold" id="s_pass_old" name="s_pass_old" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_pf_pass_old] ?> <span class="required">*</span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="password" class="form-control bold" id="s_pass" name="s_pass" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_pf_pass] ?> <span class="required">*</span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success ">
                                                                    <input type="password" class="form-control bold" id="s_pass_confirm" name="s_pass_confirm" >
                                                                    <label for="form_control_1"><?= $_SESSION[lb_pf_pass_confirm] ?> <span class="required">*</span></label>          
                                                                </div>


                                                            </form>
                                                            <div class="margin-top-10">
                                                                <a href="dashboard.php" class="btn default"><?= $_SESSION[btn_cancel] ?></a>
                                                                <button type="button" onclick="savePassword()" class="btn green"><?= $_SESSION[btn_ok] ?></button>
                                                            </div>
                                                        </div>
                                                        <!-- END CHANGE PASSWORD TAB -->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>



                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->












            <!-- BEGIN FOOTER -->
            <?php include './templated/footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <?php include './templated/quick_nav.php'; ?>
        <!-- END QUICK NAV -->



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
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <!--<script src="js/common/markPattern.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/profile.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->




        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <script src="js/action/profile.js" type="text/javascript"></script>


        <script>
                                                                    var keyEdit = "<?= $_GET[id] ?>";
        </script>
        <script>
            $(document).ready(function () {
                edit();
                savePicture();
                FormInputMask.init();
                unloading();
            });

            var FormInputMask = function () {
                var handleInputMasks = function () {
                    $("#s_phone").inputmask("mask", {
                        "mask": "(999) 999-9999"
                    });
                }
                return {
                    init: function () {
                        handleInputMasks();
                    }
                };
            }();


        </script>
    </body>

</html>