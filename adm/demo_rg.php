<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES_DEMO(1, 6);

$tt_header = 'add';
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
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
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
            <?php include './templated/header_demo.php'; ?>
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
                        <?php include './templated/menu_demo.php'; ?>   
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
                        <?php // include './templated/theme_panel.php'; ?>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                หน้าจอสำหรับทดสอบสมัคสมาชิก
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        <!------------ CONTENT ------------>
                        <div class="row">
                            <form id="form-action">
                                <input type="hidden" id="func" name="func" value="add"/>
                                <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                                <div class="col-md-8">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption font-green">
                                                <i class="icon-user font-green"></i>
                                                <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail] ?></span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">

                                            <div class="form-body">
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_firstname" name="s_firstname">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_firstname] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_lastname" name="s_lastname">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_lastname] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_phone" name="s_phone">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_phone] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_email" name="s_email">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_email] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_line" name="s_line">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_line] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <select class="form-control edited bold" id="i_bank" name="i_bank" style="color:black;font-weight:bold;">
                                                        <!--<option value="-1"></option>-->
                                                    </select>
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_bank] ?></label>
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_account_no" name="s_account_no">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_account_no] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_account_name" name="s_account_name">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_account_name] ?> <span class="required">*</span></label>          
                                                </div>



                                                <div class="form-group form-md-line-input has-success">
                                                    <select class="form-control edited bold" id="i_seo" name="i_seo" style="color:black;font-weight:bold;" onchange="ChangeDivRefFriend();">
                                                        <option value=""></option>
                                                    </select>
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_seo] ?></label>
                                                </div>
                                                <div class="form-group form-md-line-input has-success" id="div_ref_friend" style="display: none">
                                                    <input type="text" class="form-control bold" id="s_friend" name="s_friend">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_ref_friend] ?> <span class="required"></span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success" style="margin-bottom: 0px !important;">
                                                    <select class="form-control edited bold" id="i_time"  name="i_time" style="color:black;font-weight:bold;">
                                                        <option value=""></option>
                                                    </select>
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_time] ?></label>
                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                                <div class="col-md-4">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <input type="hidden" name="status" id="status" value="PEND" />
                                    <input type="hidden" name="s_flg_email" id="s_flg_email" value="Y" />
                                 
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-expeditedssl font-green"></i>
                                                    <span class="caption-subject bold uppercase"> รหัสความปลอดภัย</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">

                                                <div class="form-body">
                                                    <!--<div class="form-group form-md-line-input has-success">-->
                                                    <input type="hidden" class="form-control bold" id="s_username"  name="s_username">
                                                        <!--<label for="form_control_1"><?= $_SESSION[lb_cs_username] ?> <span class="required" id="req_user"></span></label>-->          
                                                    <!--</div>-->
                                                    <div class="form-group form-md-line-input has-success" style="margin-bottom: 0px !important;">
                                                        <input type="text" class="form-control bold" id="s_security" name="s_security">
                                                        <label for="form_control_1"><?= $_SESSION[lb_cs_security] ?> <span class="required" id="req_secu">*</span></label>          
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>



                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="demo_rg.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                                                <button type="button" class="btn blue" onclick="save()"><?= $_SESSION[btn_submit] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--                                <div class="row" style="font-size: 12px; color: red;">
                                                                    <div class="col-md-12">
                                                                        <div class="portlet-body form">
                                                                            <div class="col-md-6" align="left">
                                                                                <span><?= $_SESSION[lb_create] ?> : <span id="lb_create"></span></span>
                                                                            </div>
                                                                            <div class="col-md-6" align="right">
                                                                                <span><?= $_SESSION[lb_edit] ?> : <span id="lb_edit"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                            </form>
                        </div>
                        <!------------ CONTENT ------------>



                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->


            <span class="badge bg-primary"></span>





            <!-- BEGIN FOOTER -->
            <?php include './templated/footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <?php // include './templated/quick_nav.php'; ?>
        <!-- END QUICK NAV -->



        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
<!--        <script src="../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <script src="js/action/cs_register_manage.js" type="text/javascript"></script>

        <!-- BEGIS SELECT 2 SCRIPTS -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/common/select2.min.js"></script>
        <!-- END SELECT 2 SCRIPTS -->

        <script>
                                                    var keyEdit = "<?= $_GET[id] ?>";
        </script>
        <script>
            $(document).ready(function () {
                getDDLStatus();
                unloading();
            });
        </script>


    </body>

</html>