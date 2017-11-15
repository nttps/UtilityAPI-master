<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(1, 1);

if ($_GET[func] != NULL) {
    $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
}
if ($_GET[id] == NULL && $_GET[func] != "add") {
    echo header("Location: cs_register_adm.php");
}
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
        <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
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
                                    <span><?= $_SESSION[app_nagieos_post] ?></span>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="cs_register_adm.php"><?= $_SESSION[register_adm] ?></a>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <?= $tt_header ?>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        <!------------ CONTENT ------------>
                        <div class="row">
                            <form enctype="multipart/form-data" name="form-action" id="form-action" method="post">
                                <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
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
                                                    <input type="text" class="form-control bold" id="s_lastname"  name="s_lastname">
                                                    <label  for="form_control_1"><?= $_SESSION[lb_cs_lastname] ?> <span class="required">*</span>
                                                        <span id="class_val_username" class="" >
                                                            <i id="icon_val_username" class=""></i>
                                                            <span id="lb_val_username"></span>
                                                        </span>
                                                    </label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_phone" name="s_phone">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_phone] ?> <span class="required">*</span>
                                                        <span id="class_val_phone" class="" >
                                                            <i id="icon_val_phone" class=""></i>
                                                            <span id="lb_val_phone"></span>
                                                        </span>
                                                    </label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success" >
                                                    <input type="text" class="form-control bold" id="s_email" name="s_email">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_email] ?> <span class="required">*</span>
                                                        <span id="class_val_secu" class="" >
                                                            <i id="icon_val_secu" class=""></i>
                                                            <span id="lb_val_secu"></span>
                                                        </span>
                                                    </label>          
                                                </div>

                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="text" class="form-control bold" id="s_line" name="s_line">
                                                    <label for="form_control_1"><?= $_SESSION[lb_cs_line] ?> <span class="required"></span>
                                                        <span id="class_val_phone" class="" >
                                                            <i id="icon_val_phone" class=""></i>
                                                            <span id="lb_val_phone"></span>
                                                        </span>
                                                    </label>          
                                                </div>


                                            </div>


                                        </div>
                                    </div>

                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                                <div class="col-md-4">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-gears font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[label_status] ?></span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">

                                                <div class="form-body">

                                                    <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                                                        <select class="form-control edited bold" id="status" name="status" style="color:black;font-weight:bold;">
                                                            <option value="-1"></option>
                                                        </select>
                                                        <label for="form_control_1"><?= $_SESSION[label_status] ?></label>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-expeditedssl font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[lb_login_system] ?></span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">

                                                <div class="form-body">
                                                    <div class="form-body">

                                                        <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                                                            <select class="form-control edited bold" id="s_type" name="s_type" style="color:black;font-weight:bold;">
                                                                <option value="A"><?= $_SESSION[type_admin] ?></option>
                                                                <option value="U"><?= $_SESSION[type_user] ?></option>
                                                            </select>
                                                            <label for="form_control_1"><?= $_SESSION[lb_cs_type] ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="text" class="form-control bold" id="s_user"  name="s_user" <?= ($_GET[func] == "edit" ? "readonly" : "") ?>>
                                                        <label  for="form_control_1"><?= $_SESSION[lb_cs_username] ?> <span class="required">*</span>
                                                        </label>          
                                                    </div>
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="text" class="form-control bold" id="s_pass"  name="s_pass">
                                                        <label  for="form_control_1"><?= $_SESSION[lb_cs_password] ?> <span class="required">*</span>
                                                        </label>          
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="portlet light bordered" id="div-img">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-image font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[lb_image_profile] ?></span>
                                                </div>
                                            </div>
                                            <!--<div class="portlet-body form">-->

                                            <?php if ($_GET[func] == "edit") { ?>
                                                <input type="hidden" name="tmp_s_img" id="tmp_s_img"/>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"   style="max-width: 190px; max-height: 190px;">
                                                        <img id="img1" src="" alt="" style="height: 100%; width: 100%; display: block;" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new"> <?= $_SESSION[btn_select_img] ?> </span>
                                                            <span class="fileinput-exists"> <?= $_SESSION[btn_change] ?> </span>
                                                            <input type="file" name="s_img" id="s_img"> </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?= $_SESSION[btn_remove] ?> </a>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"   style="max-width: 190px; max-height: 190px;">
                                                        <img id="img1" src="images/no-image.png" alt="" style="height: 100%; width: 100%; display: block;" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new"> <?= $_SESSION[btn_select_img] ?> </span>
                                                            <span class="fileinput-exists"> <?= $_SESSION[btn_change] ?> </span>
                                                            <input type="file" name="s_img" id="s_img"> </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?= $_SESSION[btn_remove] ?> </a>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                            <!--</div>-->
                                        </div>
                                    </div>


                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="cs_register_adm.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                                                <button type="submit"  class="btn blue" ><?= $_SESSION[btn_submit] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="font-size: 12px; color: red;">
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
                                </div>
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
        <?php include './templated/quick_nav.php'; ?>
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
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

        <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="js/common/markPattern.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <script src="js/action/cs_register_adm_manage.js" type="text/javascript"></script>

        <!-- BEGIS SELECT 2 SCRIPTS -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/common/select2.min.js"></script>
        <!-- END SELECT 2 SCRIPTS -->
        <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>

        <script>
            var keyEdit = "<?= $_GET[id] ?>";
        </script>
        <script>
            $(document).ready(function () {
                getDDLStatus();
                save();
                unloading();

            });
        </script>


    </body>

</html>