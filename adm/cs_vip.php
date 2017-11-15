<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(1, 8);
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
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
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
        <link href="css/custom.css" rel="stylesheet" type="text/css" />


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
                                    <span><?= $_SESSION[app_nagieos_bet] ?></span>
                                    <i class="fa fa-circle" style="color: #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="cs_vip.php"><?= $_SESSION[vip] ?></a>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>
                        <!-- CONTENT -->
                        <div class="row">
                            <div class="col-md-12">
<!--                                BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-star font-dark"></i>
                                            <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_vip] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">

                                            <div class="row">
                                                <form enctype="multipart/form-data" name="form-action-file" id="form-action-file" method="post">
                                                    <input type="hidden" name="func" id="func" value="import" />
                                                    <div class="col-md-8">
                                                        <div class="col-md-12">
                                                            <div  class="col-md-4">
                                                                <span class="help-block"> <?= $_SESSION[lb_cs_excel] ?> </span>
                                                            </div>
                                                            <div class="col-md-8" align="left">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="input-group input-large">
                                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                            <span class="fileinput-filename"> </span>
                                                                        </div>
                                                                        <span class="input-group-addon btn default btn-file">
                                                                            <span class="fileinput-new">  <?= $_SESSION[btn_select_file] ?> </span>

                                                                            <span class="fileinput-exists">  <?= $_SESSION[btn_change] ?> </span>
                                                                            <input type="file" name="file_excel" id="file_excel"> </span>
                                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">  <?= $_SESSION[btn_remove] ?> </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-md-1">

                                                    </div>
                                                    <div class="col-md-3" align="center">
                                                        <br/>
                                                        <div class="btn-group">
                                                            <button type="submit" class="btn sbold green"> 
                                                                <i class="fa fa-cloud-upload"></i>
                                                                <?= $_SESSION[btn_import] ?>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!--END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"><?= $_SESSION[tt_mg_map_user] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <div class="col-md-6">

                                                </div>
                                                <div class="col-md-6" align="right"  <?= $hidden ?>>
                                                    <div class="btn-group">
                                                        <div class="btn-group">
                                                            <a href="cs_vip_manage.php?func=add">
                                                                <button id="sample_editable_1_new" class="btn sbold green"> <?= $_SESSION[btn_add] ?>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group" <?= $hidden ?>>
                                                        <button id="sample_editable_1_new" class="btn sbold red" onclick="deleteAll()"> <?= $_SESSION[btn_delete_all] ?>
<!--                                                            <i class="fa fa-minus"></i>-->
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 0px;width: 20px" class="no-sort">
                                                        <!--                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                                                    <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" id="select_all" />
                                                                                                                    <span></span>
                                                                                                                </label>-->
                                                        <span class="md-checkbox has-success">
                                                            <input type="checkbox" id="checkbox14" name="checkbox14" class="md-check">
                                                            <label for="checkbox14">
                                                                <span class="inc"></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> </label>
                                                        </span>
                                                    </th>
                                                    <th> <?= $_SESSION[lb_cs_main_user] ?> </th>
                                                    <th style="width: 40px"> <?= $_SESSION[view] ?> </th>
                                                    <th style="width: 40px"> <?= $_SESSION[tb_co_edit] ?> </th>
                                                    <th style="width: 40px"> <?= $_SESSION[tb_co_delete] ?></th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                        <!-- CONTENT -->



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



        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!--        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->
        <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="js/common/notify.js" type="text/javascript"></script>
        <script src="js/common/utility.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <script src="js/action/cs_vip.js" type="text/javascript"></script>
        <!--<script src="js/action/cs_withdraw.js" type="text/javascript"></script>-->




        <script>
                                                            $(document).ready(function () {
                                                                initialDataTable("TRUE");
                                                                importFile();
                                                                unloading();
                                                            });
        </script>
    </body>

</html>