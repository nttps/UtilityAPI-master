<?php

function ACTIVEPAGES($page, $sub) {

    // main
    $_SESSION["nav_main_dashboard"] = "";
    $_SESSION["cs_nav_main_dashboard"] = "";
    $_SESSION["post_nav_main_dashboard"] = "";
    $_SESSION["ui_nav_main_dashboard"] = "";


    // sub admin
    $_SESSION["cs_nav_sub_register_adm"] = "";
    $_SESSION["cs_nav_sub_promotion_rg"] = "";
    $_SESSION["cs_nav_sub_promotion_dp"] = "";
    $_SESSION["cs_nav_sub_bank"] = "";
    $_SESSION["post_nav_sub_email"] = "";
    $_SESSION["cs_nav_sub_license"] = "";

    // sub staff
    $_SESSION["cs_nav_sub_register"] = "";
    $_SESSION["cs_nav_sub_deposit"] = "";
    $_SESSION["cs_nav_sub_withdraw"] = "";
    $_SESSION["cs_nav_sub_report_dpwd"] = "";
    $_SESSION["cs_nav_sub_report_log"] = "";





//    // sub nagieos bet
//    $_SESSION["cs_nav_sub_dashboard"] = "";
//    $_SESSION["cs_nav_sub_deposit"] = "";
//    $_SESSION["cs_nav_sub_withdraw"] = "";
//    $_SESSION["cs_nav_sub_register"] = "";
//    $_SESSION["cs_nav_sub_promotion"] = "";
//    $_SESSION["cs_nav_sub_bank"] = "";
//    $_SESSION["cs_nav_sub_report"] = "";
//    $_SESSION["cs_nav_sub_vip"] = "";
//
//    // sub nagieos post
//    $_SESSION["post_nav_sub_dashboard"] = "";
//    $_SESSION["post_nav_sub_picture"] = "";
//    $_SESSION["post_nav_sub_video"] = "";
//    $_SESSION["post_nav_sub_news"] = "";
//    $_SESSION["post_nav_sub_email"] = "";
//    $_SESSION["post_nav_sub_youtube"] = "";
//    $_SESSION["post_nav_sub_popup"] = "";
//
//    // sub nagieos ui
//    $_SESSION["ui_nav_sub_dashboard"] = "";
//    $_SESSION["ui_nav_sub_slide"] = "";
//    $_SESSION["ui_nav_sub_gallery"] = "";



    if ($page == 0) {
        $_SESSION["nav_main_dashboard"] = " active open";
    } else if ($page == 1) {
        $_SESSION["post_nav_main_dashboard"] = " active open";
        if ($sub == 1) {
            $_SESSION["cs_nav_sub_register_adm"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["cs_nav_sub_promotion_rg"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["cs_nav_sub_promotion_dp"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["cs_nav_sub_bank"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["post_nav_sub_email"] = " active open";
        } else if ($sub == 6) {
            $_SESSION["cs_nav_sub_license"] = " active open";
        }

        
    } else if ($page == 2) {

        $_SESSION["cs_nav_main_dashboard"] = " active open";
        if ($sub == 1) {
            $_SESSION["cs_nav_sub_register"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["cs_nav_sub_deposit"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["cs_nav_sub_withdraw"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["cs_nav_sub_report_dpwd"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["cs_nav_sub_report_log"] = " active open";
        }
    }
}

function ACTIVEPAGES_DEMO($page, $sub) {

    // main

    $_SESSION["cs_nav_main_dashboard"] = "";



    // sub nagieos bet
    $_SESSION["cs_nav_sub_deposit"] = "";
    $_SESSION["cs_nav_sub_withdraw"] = "";
    $_SESSION["cs_nav_sub_register"] = "";






    if ($page == 0) {
        $_SESSION["nav_main_dashboard"] = " active open";
    } else if ($page == 1) {
        $_SESSION["cs_nav_main_dashboard"] = " active open";
        if ($sub == 1) {
            $_SESSION["cs_nav_sub_dashboard"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["cs_nav_sub_deposit"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["cs_nav_sub_withdraw"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["cs_nav_sub_bank"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["cs_nav_sub_report"] = " active open";
        } else if ($sub == 6) {
            $_SESSION["cs_nav_sub_register"] = " active open";
        } else if ($sub == 7) {
            $_SESSION["cs_nav_sub_promotion"] = " active open";
        } else if ($sub == 8) {
            $_SESSION["cs_nav_sub_vip"] = " active open";
        }
    }
}

function ACTIVEPAGES_SUB($main, $sub) {
    if ($main == 2) {
        if ($sub == 1) {
            $_SESSION["active_slide"] = "current-page";
        }
    } else if ($main == 3) {
        if ($sub == 1) {
            $_SESSION["active_partner_group"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_partner_company"] = "current-page";
        }
    } else if ($main == 4) {
        if ($sub == 1) {
            $_SESSION["active_newsletter"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_news_post"] = "current-page";
        }
    } else if ($main == 5) {
        if ($sub == 1) {
            $_SESSION["active_price_football"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_price_snooker"] = "current-page";
        } else if ($sub == 3) {
            $_SESSION["active_promotion"] = "current-page";
        }
    } else if ($main == 7) {
        if ($sub == 1) {
            $_SESSION["active_game"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_team"] = "current-page";
        }
    } else if ($main == 9) {
        if ($sub == 1) {
            $_SESSION["active_league"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_fa"] = "current-page";
        } else if ($sub == 3) {
            $_SESSION["active_champion"] = "current-page";
        }
    }
}

?>