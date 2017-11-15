$(document).ready(function () {
    captcha();
    $('#se-pre-con').delay(1000).fadeOut();
});





function captcha() {
    $.ajax({
        type: 'GET',
        url: 'controller/loginController.php?func=captcha',
        beforeSend: function ()
        {
//            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

            $("#captcha").attr("src", data);

        },
        error: function (data) {

        }

    });


}



function login() {
    var Jsdata = $("#form-login").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/loginController.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

            var res = data.split(",");
            if (res[0] == "0000") {
                window.location = "dashboard.php";
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");

            }
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {

        }

    });


}

function Forgot_password() {
    var Jsdata = $("#forget-form").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/loginController.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

            var res = data.split(",");
            if (res[0] == "0000") {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "success");
                $('#email').val("");
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");

            }
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {

        }

    });


}


function Confirm(title, txt) {
    title = "Do you want to delete Information ?";
    $('#se-pre-con').fadeIn(100);
    $.notify.addStyle('foo', {
        html:
                "<div>" +
                "<div class='clearfix'>" +
                "<div class='title' data-notify-html='title'/>" +
                "<div class='buttons'>" +
                "<input type='hidden' id='testNotify' value='" + txt + "' />" +
                "<button class='notify-no btn red'>Cancel</button>" +
                "<button class='notify-yes btn green'>Yes</button>" +
                "</div>" +
                "</div>" +
                "</div>"
    });

    $.notify({
        title: title,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });

}


$(document).on('click', '.notifyjs-foo-base .notify-no', function () {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-yes', function () {
    $(this).trigger('notify-hide');
    $('#se-pre-con').delay(100).fadeOut();
});