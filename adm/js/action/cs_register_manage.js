var tmp_username = "";
var tmp_password = "";
var tmp_security = "";
var promotionIndex = [];
var bonusIndex = [];
function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLStatus',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.s_status + "'>" + txt_status + "</option>";
            });
            $("#status").html(htmlOption);
            getDDLBank();
        },
        error: function (data) {

        }

    });
}


function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}
function getDDLBank() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBank',
        beforeSend: function ()
        {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_bank").select2({
                data: res,
                templateResult: formatState,
                templateSelection: formatState

            });
//            getDDLSEO();
//            getDDLTime();
            DDLWebsite();
        },
        error: function (ddl) {

        }



    });
}

function DDLWebsite() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLWebsite',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = item.s_website;
                htmlOption += "<option value='" + item.i_web + "'>" + txt + "</option>";
            });

            $("#i_web").html(htmlOption);
            DDLGame();
        },
        error: function (data) {

        }

    });
}


function DDLGame() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLGame',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = item.s_game;
                htmlOption += "<option value='" + item.i_game + "'>" + txt + "</option>";
            });

            $("#i_game").html(htmlOption);
            DDLBonus();
        },
        error: function (data) {

        }

    });

}







function DDLBonus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBonus',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = (language == "th" ? item.s_text_th : item.s_text_en);
                htmlOption += "<option value='" + item.f_bonus + "'>" + txt + "</option>";
//                bonusIndex.push({key: item.i_bonus, price: item.f_bonus});
            });

            $("#f_special_bonus").html(htmlOption);
            DDLPromotion();
        },
        error: function (data) {

        }

    });
}
function DDLPromotion() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLPromotion',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.i_promotion + "'>" + txt + "</option>";
//                var index = item.i_promotion + "," + item.f_percen + "," + item.f_max_bath;
                promotionIndex.push({key: item.i_promotion, percen: item.f_percen, max: item.f_max_bath});

            });

            $("#i_promotion").html(htmlOption);

            getDDLBankPay();
        },
        error: function (data) {

        }

    });
}
function formatState2(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span>  (<span style="color:blue;font-weight:bold;">  ' + state.name + '  </span>:<span style="color:red;font-weight:bold;"> ' + state.no + ' </span>)</span>'
            );
    return $state;
}
function getDDLBankPay() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBankDeposit',
        beforeSend: function ()
        {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_bank_pay").select2({
                data: res,
                templateResult: formatState2,
                templateSelection: formatState2

            });
            if (keyEdit != "") {
                edit();
            }

        },
        error: function (ddl) {

        }



    });
}








function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/registerController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_firstname").val(item.s_firstname);
                $("#s_lastname").val(item.s_lastname);
                $("#s_phone").val(item.s_phone);
                $("#s_email").val(item.s_email);
                $("#s_line").val(item.s_line);
                $("#i_bank").val(item.i_bank).trigger('change');
                $("#s_account_no").val(item.s_account_no);
                $("#s_account_name").val(item.s_account_name);
                $("#s_security").val(item.s_security);
//                $("#i_seo").val(item.i_seo_by);
//                $("#s_friend").val(item.s_friend);
//                ChangeDivRefFriend(item.i_seo_by);




                $("#i_time").val(item.i_contact_time);
                $("#status").val(item.s_status);
                $("#s_flg_email").val(item.s_flg_email);

                $("#s_username").val(item.s_username);
//                $("#s_password").val(item.s_password);
                tmp_username = item.s_username;
//                tmp_password = item.s_password;
                tmp_security = item.s_security;


                $("#i_web").val(item.i_web);
                $("#i_game").val(item.i_game);
                $("#f_amount").val(item.f_amount);
                $("#f_special_bonus").val(item.f_special_bonus);
                $("#f_bonus").val(item.f_bonus);
                $("#f_total").val(item.f_total);
                $("#d_date").val(item.d_dp_date);
                $("#d_time").val(item.d_dp_time);
                $("#i_promotion").val(item.i_promotion).trigger('change');
                $("#i_bank_pay").val(item.i_bank_dp).trigger('change');





                if (item.s_status != "APPR") {
                    $('#s_username').attr('disabled', "disabled");
//                    $('#s_password').attr('disabled', "disabled");
//                    $('#s_security').attr('disabled', "disabled");
                    $('#req_user').text("");
//                    $('#req_pass').text("");
//                    $('#req_secu').text("");

                } else {
                    $('#req_user').text("*");
//                    $('#req_pass').text("*");
//                    $('#req_secu').text("*");
                }





                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);

            });
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}

function save() {
    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/registerController.php',
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
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");
                $('#se-pre-con').delay(100).fadeOut();
                return;

            }

            notification();
            $('#form-action').each(function () {
                setTimeout(reloadTime, 1000);
            });
        },
        error: function (data) {

        }

    });
}

function sendMail() {
    var name = $("#s_firstname").val();
    var last = $("#s_lastname").val();
    var user = $("#s_username").val();
//    var pass = $("#s_password").val();
    var email = $("#s_email").val();
    var tmpstatus = $("#status").val();
    var param = "s_firstname=" + name + "&s_lastname=" + last + "&s_username=" + user + "&s_password=" + pass + "&s_email=" + email + "&status=" + tmpstatus;
    $.ajax({
        type: 'GET',
        url: 'controller/registerController.php?func=sendmail&' + param,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = data.split(",");
            if (res[0] == "0000") {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "success");
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");
                $('#se-pre-con').delay(100).fadeOut();
                return;

            }
        },
        error: function (data) {

        }

    });
}



function ChangeStatus() {
    var status = $("#status").val();
    if (status == "APPR") {
        $('#s_username').removeAttr('disabled');
//        $('#s_password').removeAttr('disabled');
//        $('#s_security').removeAttr('disabled');
        $("#s_username").val(tmp_username);
//        $("#s_password").val(tmp_password);
//        $("#s_security").val(tmp_security);
        $('#req_user').text("*");
//        $('#req_pass').text("*");
//        $('#req_secu').text("*");

    } else {
        $('#s_username').attr('disabled', "disabled");
//        $('#s_password').attr('disabled', "disabled");
//        $('#s_security').attr('disabled', "disabled");
        $("#s_username").val("");
//        $("#s_password").val("");
//        $("#s_security").val("");
        $('#req_user').text("");
//        $('#req_pass').text("");
//        $('#req_secu').text("");
    }
}

function ChangeDivRefFriend(key) {
    if (key == "" || key == null) {
        key = $("#i_seo").val();
    }
    if (key == "2") {
        $('#div_ref_friend').attr('style', "display:block;");
    } else {
        $('#div_ref_friend').attr('style', "display:none;");
    }
}




function generateJson() {
    for (i = 0; i < promotionIndex.length; i++) {
        var obj = promotionIndex[i].split(",");

    }
}

var app = angular.module('myApp', []);
app.controller('myCtrl', function ($scope) {
    $scope.tmp = 1;
    $scope.percen = 0;
    $scope.max = 0;
    $scope.amount = null;
    $scope.bonus = 0;
    $scope.specialbonus = 0;
    $scope.total = 0;




    $scope.changeSelected = function () {
        if ($("#i_promotion").val() != $scope.tmp || $("#f_special_bonus").val() != $scope.specialbonus) {
            $scope.tmp = $("#i_promotion").val();
            $scope.specialbonus = $("#f_special_bonus").val();
            for (i = 0; i < promotionIndex.length; i++) {
                if (promotionIndex[i]['key'] == $scope.tmp) {
                    $scope.percen = promotionIndex[i]['percen'];
                    $scope.max = promotionIndex[i]['max']
                }
            }

            if (keyEdit != "") {
                $scope.amount = $("#f_amount").val();
            }

            $scope.bonus = parseFloat($scope.amount) * (parseFloat($scope.percen) / 100);
            if (parseFloat($scope.max) > 0) {
                if (parseFloat($scope.bonus) > parseFloat($scope.max)) {
                    $scope.bonus = $scope.max;
                }
            }
            $scope.total = parseFloat($scope.amount) + parseFloat($scope.bonus);

            if (isNaN($scope.bonus)) {
                $scope.bonus = 0;
            }
            if (isNaN($scope.total)) {
                $scope.total = 0;
            }


            $scope.total = parseFloat($scope.total) + parseFloat($scope.specialbonus);

        }

    }



    $scope.changeValue = function () {
        $scope.tmp = $("#i_promotion").val();
        $scope.specialbonus = $("#f_special_bonus").val();
        for (i = 0; i < promotionIndex.length; i++) {
            if (promotionIndex[i]['key'] == $scope.tmp) {
                $scope.percen = promotionIndex[i]['percen'];
                $scope.max = promotionIndex[i]['max']
            }
        }
        $scope.bonus = parseFloat($scope.amount) * (parseFloat($scope.percen) / 100);
        if (parseFloat($scope.max) > 0) {
            if (parseFloat($scope.bonus) > parseFloat($scope.max)) {
                $scope.bonus = $scope.max;
            }
        }
        $scope.total = parseFloat($scope.amount) + parseFloat($scope.bonus);

        if (isNaN($scope.bonus)) {
            $scope.bonus = 0;
        }
        if (isNaN($scope.total)) {
            $scope.total = 0;
        }

        $scope.total = parseFloat($scope.total) + parseFloat($scope.specialbonus);


    }



});



//function getDDLSEO() {
//    $.ajax({
//        type: 'GET',
//        url: 'controller/commonCSController.php?func=DDLSEO',
//        beforeSend: function ()
//        {
//            //$('#se-pre-con').fadeIn(100);
//        },
//        success: function (data) {
//            var htmlOption = "";
//            var res = JSON.parse(data);
//            $.each(res, function (i, item) {
//                var txt = (language == "th" ? item.s_detail_th : item.s_detail_en);
//                htmlOption += "<option value='" + item.i_seo + "'>" + txt + "</option>";
//            });
//            $("#i_seo").html(htmlOption);
////            DDLPromotion();
//            getDDLTime();
//        },
//        error: function (data) {
//
//        }
//
//    });
//}




//function getDDLTime() {
//    $.ajax({
//        type: 'GET',
//        url: 'controller/commonCSController.php?func=DDLTime',
//        beforeSend: function ()
//        {
//            //$('#se-pre-con').fadeIn(100);
//        },
//        success: function (data) {
//            var htmlOption = "";
//            var res = JSON.parse(data);
//            $.each(res, function (i, item) {
//                var txt = (language == "th" ? item.s_detail_th : item.s_detail_en);
//                htmlOption += "<option value='" + item.i_time + "'>" + txt + "</option>";
//            });
//            $("#i_time").html(htmlOption);
//            if (keyEdit != "") {
//                DDLPromotion();
//            } else {
//                ChangeStatus();
//            }
//        },
//        error: function (data) {
//
//        }
//
//    });
//}
