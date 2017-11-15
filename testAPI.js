$(document).ready(function () {
    //  GetCaptcha();
    $('#se-pre-con').delay(100).fadeOut();
});







function tw() {

    var Jsdata = $("#form-tw").serialize();

    $.ajax({
        type: 'POST',
        url: 'TrueWallet.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                          console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });


            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                          console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}







function kbank() {

    var Jsdata = $("#form-kbank").serialize();

    $.ajax({
        type: 'POST',
        url: 'KBANK.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.channel + " | " + item.type + " | " + item.out + " | " + item.in + " | " + item.bankno + " | " + item.info);
                    msg += (item.datetime + " | " + item.channel + " | " + item.type + " | " + item.out + " | " + item.in + " | " + item.bankno + " | " + item.info + "<br/>");
                });


            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.channel + " | " + item.type + " | " + item.out + " | " + item.in + " | " + item.bankno + " | " + item.info);
                    msg += (item.datetime + " | " + item.channel + " | " + item.type + " | " + item.out + " | " + item.in + " | " + item.bankno + " | " + item.info + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}



function scb() {

    var Jsdata = $("#form-scb").serialize();
    $.ajax({
        type: 'POST',
        url: 'SCB.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {

                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.transactionCode + " | " + item.channel + " | " + item.out + " | " + item.in + " | " + item.info);
                    msg += (item.datetime + " | " + item.transactionCode + " | " + item.channel + " | " + item.out + " | " + item.in + " | " + item.info + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.transactionCode + " | " + item.channel + " | " + item.out + " | " + item.in + " | " + item.info);
                    msg += (item.datetime + " | " + item.transactionCode + " | " + item.channel + " | " + item.out + " | " + item.in + " | " + item.info + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=600,height=600");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}


function bay() {

    var Jsdata = $("#form-bay").serialize();
    $.ajax({
        type: 'POST',
        url: 'BAY.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });

}





function bbl() {

    var Jsdata = $("#form-bbl").serialize();
    $.ajax({
        type: 'POST',
        url: 'BBL.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel);
                    msg += (item.datetime + " | " + item.info + " | " + item.out + " | " + item.in + " | " + item.total + " | " + item.channel + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}


function ktb_login_no_captcha() {
//    debugger;
    var Jsdata = $("#form-ktb-no-capcha").serialize();
    $.ajax({
        type: 'POST',
        url: 'KTB.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {

                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch);
                    msg += (item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch);
                    msg += (item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}



function ktb_login_captcha() {
//    debugger;
    var Jsdata = $("#form-ktb-capcha").serialize();
    $.ajax({
        type: 'POST',
        url: 'KTB.php',
        data: Jsdata,
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch);
                    msg += (item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch + "<br/>");
                });

            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var msg = "<title>Result Transaction</title>";
            var res = tryCatch(data.responseText);
            if (res.code != "0000") {
                var errCode = "Code (" + res.code + ") : " + res.description;
                console.log(errCode);
                msg += (errCode);
            } else {
                $.each(res.total, function (j, item) {
                    console.log(item.detail + " : " + item.value);
                    msg += (item.detail + " : " + item.value + "<br/>");
                });

                $.each(res.transaction, function (j, item) {
                    console.log(item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch);
                    msg += (item.datetime + " | " + item.info + " | " + item.check + " | " + item.in + " | " + item.out + " | " + item.branch + "<br/>");
                });
            }
            var myWindow = window.open("", "", "width=320,height=560");
            myWindow.document.write(msg);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}

function GetCaptcha() {
//    debugger;
    $.ajax({
        type: 'GET',
        url: 'KTB.php?func=GetCaptcha&folder_domain=nagieos',
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var res = tryCatch(data);
            //captcha
            $('#captcha').attr('src', 'https://www.nagieos.com/captcha/' + res.image + "?x=" + Math.random());
            console.log(data);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            if (data.responseText == "") {
                console.log("Process is Null.");
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            debugger;
            var res = tryCatch(data.responseText);
            //captcha
            $('#captcha').attr('src', 'https://www.nagieos.com/captcha/' + res.image + "?x=" + Math.random());
            console.log(data);
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}



function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}


function tryCatch(data) {
    try {
        return JSON.parse(data);
    } catch (err) {
        $('#se-pre-con').delay(100).fadeOut();
    }
}