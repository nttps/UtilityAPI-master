<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
include './common/LogsViewFunction.php';
include './common/Logs.php';
include './common/ConnectDB.php';
date_default_timezone_set('Asia/Bangkok');
ACTIVEPAGES(2, 5);

if ($_GET[id] == NULL || !is_numeric($_GET[id])) {
    echo header("Location: cs_report_log.php");
}


$i_log = $_GET[id];
$db = new ConnectDB();
$strSql = "select * from tb_logs where i_log = $i_log ";
$_Hdata = $db->Search_Data_FormatJson($strSql);
$_datetime = $_Hdata[0][d_create];
$_ref = $_Hdata[0][s_ref];
$_useraction = $_Hdata[0][s_create_by];
$_menu = getLanguageMenu($_Hdata[0][s_type]);
$_s_menu = $_Hdata[0][s_type];
$_action = getLanguageAction($_Hdata[0][s_action]);



$log = new Logs();
if ($_Hdata[0][s_action] == "INSERT") {
    $_before = null;
    $_after = $log->ReadJSON($_Hdata[0][s_data]);
} else if ($_Hdata[0][s_action] == "UPDATE") {
    $tmp = getUpdateBeforeAfter($db, $_ref);
    $_before = $log->ReadJSON($tmp[0][s_data]);
    $_after = $log->ReadJSON($tmp[1][s_data]);
} else if ($_Hdata[0][s_action] == "DELETE") {
    $_before = $log->ReadJSON($_Hdata[0][s_data]);
    $_after = null;
}


$styleDiff = 'style="border-color: red"';
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
            <?php
            include_once './common/Utility.php';
            $util = new Utility();
            $util->setCSSPageLoading();
            $actual_link = "$_SERVER[REQUEST_URI]";
            ?>
            <div class='se-pre-con' id="se-pre-con" > </div>
            <script  type="text/javascript">

                function loading() {
                    $('#se-pre-con').fadeIn();
                }
                function unloading() {
                    //        getContacts();
                    $('#se-pre-con').delay(1000).fadeOut();
                }

            </script>
            <style>
                .bolds{
                    font-weight: bold !important;
                }
            </style>
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">



                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->

                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">

                            <li class="dropdown dropdown-language">
                                <!--                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                    <img alt="" src="../assets/global/img/flags/<?= $_SESSION[selected_lan_pic] ?>">
                                                                    <span class="langname"> <?= $_SESSION[selected_lan_name] ?> </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>-->
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <!--                                    <li>
                                                                            <a href="controller/changelanguageController.php?lan=en&url=<?= $actual_link ?>">
                                                                                <img alt="" src="../assets/global/img/flags/us.png"> US </a>
                                                                        </li>-->
                                    <!--                                    <li>
                                                                            <a href="controller/changelanguageController.php?lan=th&url=<?= $actual_link ?>">
                                                                                <img alt="" src="../assets/global/img/flags/th.png"> TH </a>
                                                                        </li>-->

                                </ul>
                            </li>

                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="./images/profile/<?= $_SESSION["img_profile"] ?>" />
                                    <span class="username username-hide-on-mobile"> <?= $_SESSION["full_name"] ?> </span>
                                </a>

                                <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
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
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <li class="heading">

                            </li>

                            <li class="nav-item <?= $_SESSION["cs_nav_sub_report_log"] ?>">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-folder"></i>
                                    <span class="title"><?= $_SESSION[tt_view_log] ?></span>

                                </a>

                            </li>




                        </ul>
                        <!--</li>-->
                        <!--                        </ul>  -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">

                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <div class="caption font-green">
                                    <i class="fa fa-folder font-green"></i>
                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_view_log] ?></span>
                                </div>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->



                        <div class="row">


                            <!------------ CONTENT ------------>
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="col-md-12">

                                    <div class="portlet-body">
                                        <br/>
                                        <div class="form-body"> 
                                            <div class="row">
                                                <div class="col-md-6" class="bolds" >
                                                    <p class="note note-info" class="">
                                                        <span class=""><?= $_SESSION[tb_co_datetime] ?> :</span> <small class=""><?= $_datetime ?></small><br/>
                                                        <span class=""><?= $_SESSION[lb_cs_log_user_action] ?> :</span> <small class=""><?= $_useraction ?></small><br/>
                                                        <span class=""><?= $_SESSION[lb_cs_menu] ?> :</span> <small class=""><?= $_menu ?> </small><br/>
                                                        <span class=""><?= $_SESSION[lb_cs_action] ?> :</span> <small class=""><?= $_action ?></small><br/>
                                                    </p>

                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>







                                            <?php if ($_s_menu == "REGISTER") { ?>
                                                <!------------ REGISTER ------------>
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_before] ?></span>
                                                                </div>

                                                            </div>
                                                            <!------------ REGISTER BEFORE------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_firstname] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_firstname] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_lastname] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_lastname] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_phone] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_email] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_email] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_line] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_line] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBank($db, $_before[0][i_bank]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_name] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_account_name] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_no] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_account_no] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_username] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_password] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_before[0][s_password] ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_security] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_seo] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageWebFind($db, $_before[0][i_seo_by]) ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_ref_friend] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_before[0][s_friend] ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_status_mail] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageStatusMail($db, $_before[0][s_flg_email]) ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                        -->

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_before[0][s_status]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ REGISTER BEFORE------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_after] ?></span>
                                                                </div>

                                                            </div>

                                                            <!------------ REGISTER AFTER------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_firstname] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_firstname] ?>"
                                                                                       <?= ($_before[0][s_firstname] != $_after[0][s_firstname] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_lastname] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_lastname] ?>"
                                                                                       <?= ($_before[0][s_lastname] != $_after[0][s_lastname] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_phone] ?>"
                                                                                       <?= ($_before[0][s_phone] != $_after[0][s_phone] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_email] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_email] ?>"
                                                                                       <?= ($_before[0][s_email] != $_after[0][s_email] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_line] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_line] ?>"
                                                                                       <?= ($_before[0][s_line] != $_after[0][s_line] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBank($db, $_after[0][i_bank]) ?>"
                                                                                       <?= ($_before[0][i_bank] != $_after[0][i_bank] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_name] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_account_name] ?>"
                                                                                       <?= ($_before[0][s_account_name] != $_after[0][s_account_name] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_no] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_account_no] ?>"
                                                                                       <?= ($_before[0][s_account_no] != $_after[0][s_account_no] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_username] ?>"
                                                                                       <?= ($_before[0][s_username] != $_after[0][s_username] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_password] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_after[0][s_password] ?>"
                                                                        <?= ($_before[0][s_password] != $_after[0][s_password] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_security] ?>"
                                                                                       <?= ($_before[0][s_security] != $_after[0][s_security] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_seo] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageWebFind($db, $_after[0][i_seo_by]) ?>"
                                                                        <?= ($_before[0][i_seo_by] != $_after[0][i_seo_by] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_ref_friend] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_after[0][s_friend] ?>"
                                                                        <?= ($_before[0][s_friend] != $_after[0][s_friend] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_status_mail] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageStatusMail($db, $_after[0][s_flg_email]) ?>"
                                                                        <?= ($_before[0][s_flg_email] != $_after[0][s_flg_email] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_after[0][s_status]) ?>"
                                                                                       <?= ($_before[0][s_status] != $_after[0][s_status] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ REGISTER AFTER------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                </div>
                                                <!------------ REGISTER ------------>






                                            <?php } else if ($_s_menu == "WITHDRAW") { ?>
                                                <!------------ WITHDRAW ------------>
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_before] ?></span>
                                                                </div>

                                                            </div>
                                                            <!------------ WITHDRAW BEFORE------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_website] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageWebsite($db, $_before[0][i_web]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank_adm] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBankDeposit($db, $_before[0][i_bank_adm]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_username] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_security] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_before[0][s_phone] ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_wd_amount] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][f_amount] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBank($db, $_before[0][i_bank]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_name] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_account_name] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_no] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_account_no] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_before[0][s_status]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ WITHDRAW BEFORE------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_after] ?></span>
                                                                </div>

                                                            </div>

                                                            <!------------ WITHDRAW AFTER------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_website] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageWebsite($db, $_after[0][i_web]) ?>"
                                                                                       <?= ($_before[0][i_web] != $_after[0][i_web] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank_adm] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBankDeposit($db, $_after[0][i_bank_adm]) ?>"
                                                                                       <?= ($_before[0][i_bank_adm] != $_after[0][i_bank_adm] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_username] ?>"
                                                                                       <?= ($_before[0][s_username] != $_after[0][s_username] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_security] ?>"
                                                                                       <?= ($_before[0][s_security] != $_after[0][s_security] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_after[0][s_phone] ?>"
                                                                        <?= ($_before[0][s_phone] != $_after[0][s_phone] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_wd_amount] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][f_amount] ?>"
                                                                                       <?= ($_before[0][f_amount] != $_after[0][f_amount] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBank($db, $_after[0][i_bank]) ?>"
                                                                                       <?= ($_before[0][i_bank] != $_after[0][i_bank] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_name] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_account_name] ?>"
                                                                                       <?= ($_before[0][s_account_name] != $_after[0][s_account_name] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_account_no] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_account_no] ?>"
                                                                                       <?= ($_before[0][s_account_no] != $_after[0][s_account_no] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_after[0][s_status]) ?>"
                                                                                       <?= ($_before[0][s_status] != $_after[0][s_status] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ WITHDRAW AFTER------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                </div>
                                                <!------------ WITHDRAW ------------>
                                            <?php } else if ($_s_menu == "DEPOSIT") { ?>
                                                <!------------ DEPOSIT ------------>
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_before] ?></span>
                                                                </div>

                                                            </div>
                                                            <!------------ DEPOSIT BEFORE------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_website] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageWebsite($db, $_before[0][i_web]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_game] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageGame($db, $_before[0][i_game]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_username] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_security] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_before[0][s_phone] ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_amount] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][f_amount] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_special_bonus] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][f_special_bonus] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_promotion] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguagePromotion($db, $_before[0][i_promotion]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_bonus] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][f_bonus] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_total] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][f_total] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBankDeposit($db, $_before[0][i_bank]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_chanel] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageChanel($db, $_before[0][i_chanel]) ?>"
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_date] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][d_dp_date] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_time] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][d_dp_time] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_premise] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_before[0][s_img] ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_before[0][s_status]) ?>"
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ DEPOSIT BEFORE------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <!-- BEGIN SAMPLE FORM PORTLET-->
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-file"></i>
                                                                    <span class="caption-subject font-dark sbold uppercase"><?= $_SESSION[lb_data_after] ?></span>
                                                                </div>

                                                            </div>

                                                            <!------------ DEPOSIT AFTER------------>
                                                            <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">


                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_website] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageWebsite($db, $_after[0][i_web]) ?>"
                                                                                       <?= ($_before[0][i_web] != $_after[0][i_web] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_gane] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageGame($db, $_after[0][i_game]) ?>"
                                                                                       <?= ($_before[0][i_game] != $_after[0][i_game] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_username] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_username] ?>"
                                                                                       <?= ($_before[0][s_username] != $_after[0][s_username] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_security] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_security] ?>"
                                                                                       <?= ($_before[0][s_security] != $_after[0][s_security] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_phone] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= $_after[0][s_phone] ?>"
                                                                        <?= ($_before[0][s_phone] != $_after[0][s_phone] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_amount] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][f_amount] ?>"
                                                                                       <?= ($_before[0][f_amount] != $_after[0][f_amount] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_special_bonus] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][f_special_bonus] ?>"
                                                                                       <?= ($_before[0][f_special_bonus] != $_after[0][f_special_bonus] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_promotion] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguagePromotion($db, $_after[0][i_promotion]) ?>"
                                                                                       <?= ($_before[0][i_promotion] != $_after[0][i_promotion] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_bonus] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][f_bonus] ?>"
                                                                                       <?= ($_before[0][f_bonus] != $_after[0][f_bonus] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_dp_total] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][f_total] ?>"
                                                                                       <?= ($_before[0][f_total] != $_after[0][f_total] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_bank] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageBankDeposit($db, $_after[0][i_bank]) ?>"
                                                                                       <?= ($_before[0][i_bank] != $_after[0][i_bank] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!--                                                                        <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_chanel] ?></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <input type="text" class="form-control" placeholder="" 
                                                                                                                                                               value="<?= getLanguageChanel($db, $_after[0][i_chanel]) ?>"
                                                                        <?= ($_before[0][i_chanel] != $_after[0][i_chanel] ? $styleDiff : "") ?>
                                                                                                                                                               readonly>
                                                                                                                                                    </div>
                                                                                                                                                </div>-->

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_date] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][d_dp_date] ?>"
                                                                                       <?= ($_before[0][d_dp_date] != $_after[0][d_dp_date] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_time] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][d_dp_time] ?>"
                                                                                       <?= ($_before[0][d_dp_time] != $_after[0][d_dp_time] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[lb_cs_premise] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= $_after[0][s_img] ?>"
                                                                                       <?= ($_before[0][s_img] != $_after[0][s_img] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-3 control-label"><?= $_SESSION[label_status] ?></label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control" placeholder="" 
                                                                                       value="<?= getLanguageStatus($db, $_after[0][s_status]) ?>"
                                                                                       <?= ($_before[0][s_status] != $_after[0][s_status] ? $styleDiff : "") ?>
                                                                                       readonly>
                                                                            </div>
                                                                        </div>



                                                                    </div>

                                                                </form>
                                                            </div>
                                                            <!------------ DEPOSIT AFTER------------>
                                                        </div>
                                                        <!-- END SAMPLE FORM PORTLET-->

                                                    </div>
                                                </div>


                                                <!------------ DEPOSIT ------------>
                                            <?php } ?>
                                        </div>
                                    </div>






                                </div>



                                <!-- END EXAMPLE TABLE PORTLET-->


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
            <script src="js/action/cs_vip_manage.js" type="text/javascript"></script>

            <!-- BEGIS SELECT 2 SCRIPTS -->
            <link href="css/select2.min.css" rel="stylesheet" />
            <script src="js/common/select2.min.js"></script>
            <!-- END SELECT 2 SCRIPTS -->


            <script>
                $(document).ready(function () {
                    unloading();
                });
            </script>


    </body>

</html>