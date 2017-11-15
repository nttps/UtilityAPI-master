<?php @session_start(); ?>

<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

    <li class="nav-item <?= $_SESSION["cs_nav_main_dashboard"] ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-game-controller"></i>
            <span class="title">DEMO <?= $_SESSION[app_nagieos_bet] ?></span>
            <span class="selected"></span>
            <span class="badge badge-danger" id="noti-nagieos-bet"></span>
        </a>
        <ul class="sub-menu">

            <li class="nav-item  <?= $_SESSION["cs_nav_sub_deposit"] ?>">
                <a href="demo_dp.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[deposit] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-info" id="noti-deposit"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_withdraw"] ?>">
                <a href="demo_wd.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[withdraw] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-warning" id="noti-withdraw"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_register"] ?>">
                <a href="demo_rg.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[register] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-success" id="noti-register"></span>
                </a>
            </li>
            


        </ul>
    </li>

</ul>
</li>
</ul>