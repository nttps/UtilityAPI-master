<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
ACTIVEPAGES(1, 8);
$db = new ConnectDB();

function getTurnOver($u) {
    $db2 = new ConnectDB();
    $strSql2 = "select sum(f_turnover) f_turnover from tb_cs_excel where s_user = '$u' ";
    $turnOver = $db2->Search_Data_FormatJson($strSql2);
    if ($turnOver != "") {
        return $turnOver[0][f_turnover];
    } else {
        return "0";
    }
}

function getSumLevel1($u) {
    $db2 = new ConnectDB();
    $strSql = "";
    $strSql .= "select  ";
    $strSql .= "IFNULL(sum(ex.f_turnover),0) f_turnover  ";
    $strSql .= "from tb_cs_excel ex ";
    $strSql .= "where exists ( ";
    $strSql .= "select 1 from tb_cs_user_map m ";
    $strSql .= "where m.s_sub = ex.s_user ";
    $strSql .= "and m.s_main = '$u' ";
    $strSql .= ") ";
    $turnOver = $db2->Search_Data_FormatJson($strSql);
    if ($turnOver != "") {
        return $turnOver[0][f_turnover];
    } else {
        return 0;
    }
}

function getSumLevel2($u) {
    $db2 = new ConnectDB();
    $strSql = "";
    $strSql .= "SELECT IFNULL ";
    $strSql .= "  (SUM(ex.f_turnover), ";
    $strSql .= "  0) f_turnover ";
    $strSql .= "FROM ";
    $strSql .= "  tb_cs_excel ex ";
    $strSql .= "WHERE EXISTS ";
    $strSql .= "  ( ";
    $strSql .= "  SELECT ";
    $strSql .= "    1 ";
    $strSql .= "  FROM ";
    $strSql .= "    ( ";
    $strSql .= "    SELECT ";
    $strSql .= "      m.s_sub ";
    $strSql .= "    FROM ";
    $strSql .= "      `tb_cs_user_map` m ";
    $strSql .= "    WHERE EXISTS ";
    $strSql .= "      ( ";
    $strSql .= "      SELECT ";
    $strSql .= "        1 ";
    $strSql .= "      FROM ";
    $strSql .= "        tb_cs_user_map m2 ";
    $strSql .= "      WHERE ";
    $strSql .= "        m2.s_main = 'zim2200006' AND m2.s_sub = m.s_main ";
    $strSql .= "    ) ";
    $strSql .= "  ) s ";
    $strSql .= "WHERE ";
    $strSql .= "  s.s_sub = ex.s_user ";
    $strSql .= ") ";
    $turnOver = $db2->Search_Data_FormatJson($strSql);
    if ($turnOver != "") {
        return $turnOver[0][f_turnover];
    } else {
        return 0;
    }
}

function sumLevel1_2($u) {
    return getSumLevel1($u) + getSumLevel2($u);
}

function sumLevel1_2_Percen($u) {
    return (getSumLevel1($u) * 0.002) + (getSumLevel2($u) * 0.001);
}

if ($_GET[id] == NULL) {
    echo header("Location: cs_vip.php");
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
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">

                        <img src="images/logo/logo_002.jpg" alt="logo" class="logo-default" /> 

                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->

                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            <?php //include 'templated/notification.php';   ?>
                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                            <!-- END INBOX DROPDOWN -->

                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-language">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" src="../assets/global/img/flags/<?= $_SESSION[selected_lan_pic] ?>">
                                    <span class="langname"> <?= $_SESSION[selected_lan_name] ?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="controller/changelanguageController.php?lan=en&url=<?= $actual_link ?>">
                                            <img alt="" src="../assets/global/img/flags/us.png"> US </a>
                                    </li>
                                    <li>
                                        <a href="controller/changelanguageController.php?lan=th&url=<?= $actual_link ?>">
                                            <img alt="" src="../assets/global/img/flags/th.png"> TH </a>
                                    </li>

                                </ul>
                            </li>
                            <!-- END LANGUAGE BAR -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
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

                            <li class="nav-item <?= $_SESSION["cs_nav_main_dashboard"] ?>">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-eye"></i>
                                    <span class="title"><?= $_SESSION[view] ?></span>

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
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <?php //include './templated/theme_panel.php';   ?>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <div class="caption font-green">
                                    <i class="fa fa-eye font-green"></i>
                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[vip] ?></span>
                                </div>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        <!------------ CONTENT ------------>
                        <div class="row">


                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="col-md-12">

                                    <div class="portlet-body">
                                        <div class="form-body"> 
                                            <div class="col-md-12" style="height: 50px; font-weight: bold">
                                                <span class="badge badge-primary"><?= $_SESSION[lb_cs_view_main] ?></span>
                                                <br/>
                                                <span class="badge badge-primary">
                                                    <?php
                                                    $txtMain = $_SESSION[lb_cs_view_12];
                                                    $txtMain = eregi_replace("f1", number_format(sumLevel1_2($_GET[id]), 2), $txtMain);
                                                    $txtMain = eregi_replace("f2", number_format(sumLevel1_2_Percen($_GET[id]), 2), $txtMain);
                                                    ?>

                                                    <?= $txtMain ?>
                                                </span>

                                            </div>

                                            <div class="col-md-12" >

                                                <div class="col-md-1" align="center">
                                                    <!--1-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--2-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--3-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--4-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--5-->
                                                </div>

                                                <div class="col-md-2" align="center">
                                                    <span class="badge badge-primary">
                                                        <span class="fa fa-user"> :</span>
                                                        <?= $_GET[id] ?>
                                                    </span>
                                                    <br/>
                                                    <span class="badge badge-danger">
                                                        <span class="fa fa-money"> : </span>
                                                        <?= number_format(getTurnOver($_GET[id]), 2) ?>
                                                    </span>
                                                </div>



                                                <div class="col-md-1" align="center">
                                                    <!--8-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--9-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--10-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--11-->
                                                </div>
                                                <div class="col-md-1" align="center">
                                                    <!--12-->
                                                </div>


                                            </div>

                                            <div class="col-md-12" style="height: 50px;">
                                                &nbsp;
                                            </div>
                                            <?php
                                            $divLV1 = FALSE;
                                            $divLV2 = FALSE;

                                            $main_lv2_1 = "";
                                            $main_lv2_2 = "";
                                            $main_lv2_3 = "";
                                            $main_lv2_4 = "";
                                            $main_lv2_5 = "";
                                            $main_lv2_6 = "";




                                            $strSql = "select * from tb_cs_user_map where s_main = '$_GET[id]' order by i_index";
                                            $lv1 = $db->Search_Data_FormatJson($strSql);
                                            if ($lv1 != NULL) {
                                                foreach ($lv1 as $key => $value) {
                                                    if ($lv1[$key]['s_sub'] != "") {
                                                        $divLV1 = TRUE;
                                                    }
                                                    if ($lv1[$key]['i_index'] == "1") {
                                                        $main_lv2_1 = $lv1[$key]['s_sub'];
                                                    } else if ($lv1[$key]['i_index'] == "2") {
                                                        $main_lv2_2 = $lv1[$key]['s_sub'];
                                                    } else if ($lv1[$key]['i_index'] == "3") {
                                                        $main_lv2_3 = $lv1[$key]['s_sub'];
                                                    } else if ($lv1[$key]['i_index'] == "4") {
                                                        $main_lv2_4 = $lv1[$key]['s_sub'];
                                                    } else if ($lv1[$key]['i_index'] == "5") {
                                                        $main_lv2_5 = $lv1[$key]['s_sub'];
                                                    } else if ($lv1[$key]['i_index'] == "6") {
                                                        $main_lv2_6 = $lv1[$key]['s_sub'];
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php if ($divLV1) { ?>
                                                <div class="col-md-12" style="height: 50px;">
                                                    <span class="badge badge-success">
                                                        <?= $_SESSION[lb_cs_view_level] ?> 1
                                                    </span>
                                                    <br/>
                                                    <span class="badge badge-success">
                                                        <?php
                                                        $txtLV1 = $_SESSION[lb_cs_view_1];
                                                        $txtLV1 = eregi_replace("f1", number_format(getSumLevel1($_GET[id]), 2), $txtLV1);
                                                        $txtLV1 = eregi_replace("f2", number_format(getSumLevel1($_GET[id]) * 0.002, 2), $txtLV1);
                                                        ?>
                                                        <?= $txtLV1 ?>
                                                    </span>
                                                </div>
                                                <div class="col-md-12" >

                                                    <?php
                                                    $cntMainLevel1 = 0;
                                                    if ($lv1 != NULL) {
                                                        foreach ($lv1 as $key => $value) {
                                                            $userSUB = ($lv1[$key]['s_sub'] != "" ? $lv1[$key]['s_sub'] : "");
                                                            $html_lv1 = '<div class="col-md-2" align="center">';
                                                            $html_lv1 .= '<span class="badge badge-success">';
                                                            $html_lv1 .= '<span class="fa fa-user"> : </span>';
                                                            $html_lv1 .= $userSUB;
                                                            $html_lv1 .= ' </span> <br/>';
                                                            $html_lv1 .= '<span class="badge badge-danger">';
                                                            $html_lv1 .= '<span class="fa fa-money"> : </span> ';
                                                            $html_lv1 .= number_format(getTurnOver($userSUB), 2);
                                                            $html_lv1 .= '</span><br/><br/>';
                                                            $html_lv1 .= '</div>';

                                                            echo $html_lv1;
                                                            $divLV2 = TRUE;
                                                            $cntMainLevel1++;
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            <?php } ?>

                                            <div class="col-md-12" style="height: 50px;">
                                                &nbsp;
                                            </div>

                                            <?php if ($divLV2) { ?>


                                                <div class="col-md-12" style="height: 50px;">
                                                    <span class="badge badge-warning">
                                                        <?= $_SESSION[lb_cs_view_level] ?> 2
                                                    </span>
                                                    <br/>
                                                    <span class="badge badge-warning">
                                                        <?php
                                                        $txtLV2 = $_SESSION[lb_cs_view_2];
                                                        $txtLV2 = eregi_replace("f1", number_format(getSumLevel2($_GET[id]), 2), $txtLV2);
                                                        $txtLV2 = eregi_replace("f2", number_format(getSumLevel2($_GET[id]) * 0.001, 2), $txtLV2);
                                                        ?>
                                                        <?= $txtLV2 ?>
                                                    </span>
                                                </div>
                                                <div class="col-md-12" >
                                                    <?php
                                                    for ($i = 1; $i <= $cntMainLevel1; $i++) {
                                                        $main = ${'main_lv2_' . $i};
                                                        $strSql = "select * from tb_cs_user_map where s_main = '" . $main . "' order by i_index";
                                                        $lv2 = $db->Search_Data_FormatJson($strSql);

                                                        if ($lv2 != NULL) {
                                                            $html_lv2 = '<div class="col-md-2" align="center">';
                                                            foreach ($lv2 as $key => $value) {

                                                                $userSUB2 = ($lv2[$key]['s_sub'] != "" ? $lv2[$key]['s_sub'] : "");
                                                                if ($userSUB2 != "") {
                                                                    $html_lv2 .= '<span class="badge badge-warning">';
                                                                    $html_lv2 .= '<span class="fa fa-user"> : </span> ';
                                                                    $html_lv2 .= $userSUB2;
                                                                    $html_lv2 .= '</span></br> ';
                                                                    $html_lv2 .= '<span class="badge badge-danger">';
                                                                    $html_lv2 .= '<span class="fa fa-money"> : </span> ';
                                                                    $html_lv2 .= number_format(getTurnOver($userSUB2), 2);
                                                                    $html_lv2 .= '</span>';
                                                                    $html_lv2 .= '<br/><br/><br/>';
                                                                }
//                                                                else {
//                                                                    $html_lv2 .= '<span class="badge badge-warning">';
//                                                                    $html_lv2 .= '<span class="fa fa-user"> : </span>';
//                                                                    $html_lv2 .= ' - ';
//                                                                    $html_lv2 .= '</span>';
//                                                                    $html_lv2 .= '<br/><br/><br/>';
//                                                                }
                                                            }
                                                            $html_lv2 .= '</div>';
                                                            echo $html_lv2;
                                                        }
//                                                        else {
//                                                            $html_lv2 = '<div class="col-md-2" align="center">';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '<span class="badge badge-warning"><span class="fa fa-user"> : </span> - </span><br/><br/><br/><br/>';
//                                                            $html_lv2 .= '</div>';
//                                                            echo $html_lv2;
//                                                        }
                                                        ?>

                                                    <?php } ?>
                                                </div>

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