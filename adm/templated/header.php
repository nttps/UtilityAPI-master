<?php @session_start(); ?>
<?php
include_once './common/Utility.php';
$util = new Utility();
$util->setCSSPageLoading();
$actual_link = "$_SERVER[REQUEST_URI]";
?>
<style>
    @charset "utf-8";body{font-family:thaisanslite_r1;font-size:16px;color:#333;line-height:18px;overflow-x:hidden;}
    @font-face{font-family:thaisanslite_r1;src:url("css/fonts_exp/thaisanslite_r1.eot?v=1.0")}
    @font-face{font-family:thaisanslite_r1;src:url("css/fonts_exp/thaisanslite_r1.ttf?v=1.0")}
    *{
    font-size:16px;
    font-family:thaisanslite_r1;
}
*>*{
    font-size:16px;
    font-family:thaisanslite_r1;
}
</style>
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
<div class="page-header navbar navbar-fixed-top" onload="currentTime()">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo" align="center">

            <!--                        <a href="dashboard.php">
                                        <img src="images/logo/logo_002.jpg" alt="logo" class="logo-default" /> -->
            <div style="margin-top: 14px;">
            	<span id="txt" style="color:white;" class="logo-default"></span>
                <div class="menu-toggler sidebar-toggler" Style="margin-top: -1px;">
                <span></span>
            </div>
            </div>
            
            <!--                        </a>-->
            
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a  href="javascript:;" class="menu-toggler responsive-toggler"  data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <img src="images/logo/logoIndex.png"/>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                <?php include 'templated/notification.php'; ?>
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-envelope-open"></i>
                        <span class="badge badge-default"> 4 </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>You have
                                <span class="bold">7 New</span> Messages</h3>
                            <a href="app_inbox.html">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                <li>
                                    <a href="#">
                                        <span class="photo">
                                            <img src="../assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                        <span class="subject">
                                            <span class="from"> Lisa Wong </span>
                                            <span class="time">Just Now </span>
                                        </span>
                                        <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="photo">
                                            <img src="../assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                        <span class="subject">
                                            <span class="from"> Richard Doe </span>
                                            <span class="time">16 mins </span>
                                        </span>
                                        <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="photo">
                                            <img src="../assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                        <span class="subject">
                                            <span class="from"> Bob Nilson </span>
                                            <span class="time">2 hrs </span>
                                        </span>
                                        <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="photo">
                                            <img src="../assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                        <span class="subject">
                                            <span class="from"> Lisa Wong </span>
                                            <span class="time">40 mins </span>
                                        </span>
                                        <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="photo">
                                            <img src="../assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                        <span class="subject">
                                            <span class="from"> Richard Doe </span>
                                            <span class="time">46 mins </span>
                                        </span>
                                        <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>-->
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
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style=" width: 130%;">
                        <img alt="" class="img-circle" src="./images/profile/<?= $_SESSION["img_profile"] ?>" />
<!--                        <span class="username username-hide-on-mobile"> <?= $_SESSION["full_name"] ?> </span>-->
                          <span class="username"> <?= $_SESSION["full_name"] ?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="profile.php">
                                <i class="icon-user"></i> <?= $_SESSION[myprofile] ?> </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a href="lock_screen.php">
                                <i class="icon-lock"></i> <?= $_SESSION[lockscreen] ?> </a>
                        </li>
                        <li>
                            <a href="controller/logoutController.php">
                                <i class="icon-key"></i> <?= $_SESSION[logout] ?> </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-quick-sidebar-toggler">
                                    <a href="controller/logoutController.php" class="dropdown-toggle">
                                        <i class="icon-logout"></i>
                                    </a>
                                </li>-->
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>