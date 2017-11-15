<?php
@session_start();
include './common/Permission.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(2, 3);

if ($_GET[func] != NULL) {
    $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
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
                                    <a href="po_picture.php"><?= $_SESSION[video] ?></a>
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
                                                    <select class="form-control edited bold" id="i_pointion" name="i_pointion">
                                                        <option value=""></option>
                                                    </select>
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_pointion] ?> <span class="required">*</span></label>
                                                </div>
                                                <div class="form-group form-md-line-input has-success" >
                                                    <select class="form-control edited bold" id="i_sv_media" name="i_sv_media" style="width: 100%">
                                                    </select>
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_sv] ?> <span class="required">*</span></label>
                                                </div>
                                                <div class="form-group form-md-line-input has-success" >
                                                    <input type="text" class="form-control bold" id="s_src_media" name="s_src_media">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_sv_src] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="number" class="form-control bold" id="i_index" name="i_index" value="1" min="1">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_index] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="number" class="form-control bold" id="i_view" name="i_view" value="0" min="0">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_view] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success">
                                                    <input type="number" class="form-control bold" id="i_vote" name="i_vote" value="0" min="0">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_vote] ?> <span class="required">*</span></label>          
                                                </div>

                                                <div class="form-group form-md-line-input has-success" id="div-sv-src">
                                                    <input type="text" class="form-control bold" id="s_subject_th" name="s_subject_th">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_subject_th] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success" id="div-sv-src">
                                                    <input type="text" class="form-control bold" id="s_subject_en" name="s_subject_en">
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_subject_en] ?> <span class="required">*</span></label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success" >
                                                    <textarea class="form-control bold" name="s_detail_th" id="s_detail_th" ></textarea>
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_desc_th] ?> <span class="required">*</span>
                                                    </label>          
                                                </div>
                                                <div class="form-group form-md-line-input has-success" >
                                                    <textarea class="form-control bold" name="s_detail_en" id="s_detail_en" ></textarea>
                                                    <label for="form_control_1"><?= $_SESSION[lb_po_desc_en] ?> <span class="required">*</span>
                                                    </label>          
                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                    <!-- END EXAMPLE TABLE PORETLT-->
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


                                    <input type="hidden" name="tmp_img_p1" id="tmp_img_p1">
                                    <div class="col-md-12" id="div-img1" >
                                        <div class="portlet light bordered" >
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-image font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[lb_po_img_1] ?></span>
                                                </div>
                                            </div>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"  style="max-width: 200px; max-height: 150px;">
                                                    <img id="img1" src="images/no-image.png" alt="" style="max-width: 200px; max-height: 150px;"/> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> <?= $_SESSION[btn_select_img] ?> </span>
                                                        <span class="fileinput-exists"> <?= $_SESSION[btn_change] ?> </span>
                                                        <input type="file" name="s_img_p1" id="s_img_p1"> </span>

                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?= $_SESSION[btn_remove] ?> </a>
                                                </div>
                                                <br/><br/>

                                            </div>

                                            <div class="form-group form-md-line-input has-success" id="div-sv-src">
                                                <input type="text" class="form-control bold" id="s_link" name="s_link">
                                                <label for="form_control_1"><?= $_SESSION[lb_po_img_url] ?> </label>          
                                            </div>
                                        </div>

                                    </div>


                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="po_video.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
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

         <script src="ckeditor/ckeditor.js"></script>
        <?php $_SESSION["folder_upload"] = "ckpostvideo" ?>
        <script>
            CKEDITOR.replace('s_detail_th', {"filebrowserImageUploadUrl": "iaupload_all.php"});
            CKEDITOR.replace('s_detail_en', {"filebrowserImageUploadUrl": "iaupload_all.php"});
        </script>


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
        <script src="js/action/po_video_manage.js" type="text/javascript"></script>

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
//                unloading();
            });
        </script>


    </body>

</html>