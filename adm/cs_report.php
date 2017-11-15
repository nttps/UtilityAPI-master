<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
date_default_timezone_set('Asia/Bangkok');
ACTIVEPAGES(2, 4);
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
        <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
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
                                    <a href="cs_report.php"><?= $_SESSION[report] ?></a>
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
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-search font-dark"></i>
                                            <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_report] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">

                                            <div class="row">
                                                <form id="form-action">
                                                    <input type="hidden" name="func" id="func" value="search" />
                                                    <div class="col-md-8">
                                                        <div class="col-md-12">
                                                            <div  class="col-md-4">
                                                                <span class="help-block"> <?= $_SESSION[lb_cs_range_date] ?> </span>
                                                            </div>
                                                            <div class="col-md-8" align="left">
                                                                <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                                                    <input type="text" class="form-control" name="d_start" id="d_start" value="<?= date("d/m/Y") ?>" readonly>
                                                                    <span class="input-group-addon"> to </span>
                                                                    <input type="text" class="form-control" name="d_end" id="d_end" value="<?= date("d/m/Y") ?>" readonly> </div>
                                                            </div>
                                                        </div>
<!--                                                        <div class="col-md-12">
                                                            <br/>
                                                            <div  class="col-md-4">
                                                                <span class="help-block">  <?= $_SESSION[lb_cs_website] ?></span>
                                                            </div>
                                                            <div class="col-md-4" align="left">
                                                                <select class="form-control edited bold"  id="i_web"  name="i_web"  >

                                                                </select>
                                                            </div>
                                                        </div>-->
                                                        <div class="col-md-12">
                                                            <br/>
                                                            <div  class="col-md-4">
                                                                <span class="help-block">  <?= $_SESSION[lb_cs_username] ?>  </span>
                                                            </div>
                                                            <div class="col-md-8" align="left">
                                                                <input type="text" id="s_username" name="s_username" class="form-control input-sm" placeholder="<?= $_SESSION[lb_cs_by_username] ?> ...">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <br/>
                                                            <div  class="col-md-4">
                                                                <span class="help-block">  <?= $_SESSION[lb_cs_by_fullname] ?>  </span>
                                                            </div>
                                                            <div class="col-md-8" align="left">
                                                                <input type="text"  id="fullname" name="fullname" class="form-control input-sm" placeholder="<?= $_SESSION[lb_cs_by_fullname] ?> ...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-md-1">

                                                </div>
                                                <div class="col-md-3" align="center">
                                                    <br/>
                                                    <div class="btn-group">
                                                        <button id="btn_search" onclick="search()" class="btn sbold green"> 
                                                            <i class="fa fa-search"></i>
                                                            <?= $_SESSION[btn_search] ?>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button id="btn_clear" class="btn sbold red" onclick="clearForm()"> <?= $_SESSION[btn_cancel] ?>
<!--                                                            <i class="fa fa-minus"></i>-->
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                        <!-- CONTENT -->


                        <!-- REPORT CONTENT -->
                        <div id="content-report" style="display: none">

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <span class="badge badge-success"><?= $_SESSION[lb_cs_hd_deposit] ?>
                                        <br/> <br/>
                                    </span>

                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th> <?= $_SESSION[tb_co_date] ?> </th>
                                                        <!--<th> <?= $_SESSION[lb_cs_website] ?> </th>-->
                                                        <th> <?= $_SESSION[tb_co_username] ?> </th>
                                                        <th> <?= $_SESSION[tb_co_fullname] ?> </th>       
                                                        <th> <?= $_SESSION[tb_co_amount] ?> </th>
                                                        <th> <?= $_SESSION[tb_co_status] ?> </th>                            
                                                    </tr>
                                                </thead>
                                                <tbody id="deposit-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <span class="badge badge-danger"><?= $_SESSION[lb_cs_hd_withdraw] ?>
                                    </span>
                                    <br/>
                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th> <?= $_SESSION[tb_co_date] ?> </th>
                                                        <!--<th> <?= $_SESSION[lb_cs_website] ?> </th>-->
                                                        <th> <?= $_SESSION[tb_co_username] ?> </th>
                                                        <th> <?= $_SESSION[tb_co_fullname] ?> </th>       
                                                        <th> <?= $_SESSION[tb_co_amount] ?> </th>
                                                        <th> <?= $_SESSION[tb_co_status] ?> </th>                                  
                                                    </tr>
                                                </thead>
                                                <tbody id="withdraw-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6"> </div>
                                <div class="col-md-6">
                                    <div class="well">
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_dp_appr] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_dp_appr" class=""></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_dp_appr_bonus] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_dp_appr_bonus" class=""></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_dp_appr_bonus_special] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_dp_appr_bonus_spcial" class=""></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_dp_pend] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_dp_pend"></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_dp_rej] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_dp_rej"></span> ฿</div>
                                        </div>
                                        <!--                                        <div class="row static-info align-reverse">
                                                                                    <div class="col-md-8 name"> <?= $_SESSION[lb_cs_rs_dp] ?>: </div>
                                                                                    <div class="col-md-3 value"> <u><span id="rs_dp"></span></u> ฿</div>
                                                                                </div>-->
                                        <hr>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_wd_appr] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_wd_appr"></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_wd_pend] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_wd_pend"></span> ฿</div>
                                        </div>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_wd_rej] ?>: </div>
                                            <div class="col-md-3 value"> <span id="rs_wd_rej"></span> ฿</div>
                                        </div>
                                        <!--                                        <div class="row static-info align-reverse">
                                                                                    <div class="col-md-8 name"><?= $_SESSION[lb_cs_rs_wd] ?>: </div>
                                                                                    <div class="col-md-3 value"> <u><span id="rs_wd"></span></u>  ฿</div>
                                                                                </div>-->
                                        <hr>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name" style="font-weight: bold;"> <?= $_SESSION[lb_cs_rs_result] ?>: </div>
                                            <div class="col-md-3 value" > <span id="rs_result" class="doubleUnderline"></span> ฿</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>



                        <!-- REPORT CONTENT -->


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
        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!--<script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>-->
        <script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
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

        <script>
                                                           var label_all = '<?= $_SESSION[all] ?>';
                                                           var current_date = '<?= date("d/m/Y") ?>';
        </script>

        <script src="js/action/cs_report.js" type="text/javascript"></script>




        <script>
                                                            $(document).ready(function () {
//                                                                DDLWebsite();
                                                                unloading();
                                                            });
        </script>
    </body>

</html>