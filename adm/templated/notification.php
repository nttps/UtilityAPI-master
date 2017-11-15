<!--<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-bell"></i>
        <span class="" id="css_count-noti-h"> <span id="count-noti-h"></span> </span>
    </a>
    <ul id="ul-ddl-noti" class="dropdown-menu">
        <li class="external">
            <h3>
                <span class="bold"><span id="count-noti-d"></span> <?= $_SESSION[pending] ?></span> <?= $_SESSION[notification] ?></h3>
        </li>
        <li>
            <ul id="ul-ddl-noti-d" class="dropdown-menu-list scroller" data-handle-color="#637283" >
            </ul>
        </li>
    </ul>
</li>-->

<audio id="NotiAudio">
    <source src="audio/noti-IphoneSms.mp3" type="audio/mpeg">
</audio>
<script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<link href="css/notification.css" rel="stylesheet" type="text/css" />
<script src="js/action/notification.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        function currentTime() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth();
            var yy = today.getFullYear();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                 "วันที่ "+   dd + "/" + (mm + 1) + "/" + yy + " " + h + ":" + m + ":" + s + " น.";
            var t = setTimeout(currentTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            ;  // add zero in front of numbers < 10
            return i;
        }
        currentTime();


//        var sec = 3;
//        notification();
//        setInterval(notification, 1000 * sec);
    });
    function reloadTime() {
        location.reload();
        $('#se-pre-con').delay(100).fadeOut();

    }
</script>

<script>
    var language = "<?= $_SESSION[lan] ?>";
    var title = "<?= $_SESSION[confirmDelete] ?>";
    var yes = "<?= $_SESSION[btn_yes] ?>";
    var cancel = "<?= $_SESSION[btn_cancel] ?>";
    var lb_search_noInfo = "<?= $_SESSION[lb_search_noInfo] ?>";
    var lb_fullname_header = "<?= $_SESSION["full_name"] ?>";
    var disable = "<?= $disable ?>";
    var hidden = "<?= $hidden ?>";
</script>
