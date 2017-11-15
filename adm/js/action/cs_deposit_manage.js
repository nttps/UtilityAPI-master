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
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span>  (<span style="color:blue;font-weight:bold;">  ' + state.name + '  </span>:<span style="color:red;font-weight:bold;"> ' + state.no + ' </span>)</span>'
            );
    return $state;
}
function getDDLBank() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBankDeposit',
        beforeSend: function ()
        {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_bank").select2({
                data: res,
                templateResult: formatState,
                templateSelection: formatState

            });

            DDLChanel();
        },
        error: function (ddl) {

        }



    });
}

function formatStateChanel(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><img src="images/chanel/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}
function DDLChanel() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLChanel',
        beforeSend: function ()
        {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_chanel").select2({
                data: res,
                templateResult: formatStateChanel,
                templateSelection: formatStateChanel

            });

            DDLPromotion();
        },
        error: function (ddl) {

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
           DDLWebsite();
    //          DDLBonus();
        },
        error: function (data) {

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
            if (keyEdit != "") {
                edit();
            }
        },
        error: function (data) {

        }

    });
}




function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/depositController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                //     debugger;
                $("#s_username").val(item.s_username);
//                $("#s_firstname").val(item.s_firstname);
//                $("#s_phone").val(item.s_phone);
                $("#f_amount").val(item.f_amount);
                $("#f_bonus").val(item.f_bonus);
                $("#f_total").val(item.f_total);

                $("#i_bank").val(item.i_bank).trigger('change');
//                $("#i_chanel").val(item.i_chanel).trigger('change');
                $("#i_promotion").val(item.i_promotion).trigger('change');
                $("#tmp_i_promotion").val(item.i_promotion);

                $("#i_web").val(item.i_web);
                $("#i_game").val(item.i_game);
                $("#f_special_bonus").val(item.f_special_bonus);


//                $("#s_datetime").val(item.d_dp_date + " " + item.d_dp_time);
                $("#d_date").val(item.d_dp_date);
                $("#d_time").val(item.d_dp_time);

//                $("#s_security").val(item.s_security);
                $("#status").val(item.s_status);
                $('#tmp_s_img').val(item.s_img);
                $('#img1').attr('src', (item.s_img != "" ? "upload/premise/" + item.s_img : "images/no_photo.png"));
//                $('#s_img_a').attr('title', (item.s_img != "" ? item.s_img : "NO PHOTO"));
//                $('#s_img_a').attr('href', (item.s_img != "" ? "upload/premise/" + item.s_img : "images/no_photo.png"));
//                $('#div-img').attr('style', (item.s_img != "" ? "" : "pointer-events: none;cursor: default;"));



                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });
//            warring();
//            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}

function warring() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=ValidSecurity&id=' + keyEdit + "&table=tb_cs_dp&field=i_dp",
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            //  debugger;
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                // debugger;

                if (item.sh_username == "Y") {
                    $("#lb_val_username").text(item.username);
                    $('#class_val_username').attr('class', (item.succ_username == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_username').attr('class', (item.succ_username == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
//                if (item.sh_security == "Y") {
//                    $("#lb_val_secu").text(item.security);
//                    $('#class_val_secu').attr('class', (item.succ_security == "Y" ? "badge badge-success" : "badge badge-warning"));
//                    $('#icon_val_secu').attr('class', (item.succ_security == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
//                }
                if (item.sh_phone == "Y") {
                    $("#lb_val_phone").text(item.phone);
                    $('#class_val_phone').attr('class', (item.succ_phone == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_phone').attr('class', (item.succ_phone == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
            });
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}



function save() {
    $('#form-action').submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/depositController.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
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
                    //fix
                    $('#se-pre-con').delay(100).fadeOut();
                    return;
                }
                notification();
                $('#form-action').each(function () {
                    setTimeout(reloadTime, 1000);
                });
            }, error: function (data) {

            }
        });
    });
}


//function calBonus() {
//    var i_promo = $("#i_promotion").val();
//    for (i = 0; i < promotionIndex.length; i++) {
//        var obj = promotionIndex[i].split(",");
//        if (i_promo == obj[0]) {
//            if (obj[0] == 1) {
//                $("#f_percen").val(0);
//                $("#f_max").val(0);
//                $("#div-bonus").attr("style", "display:none;");
//            } else {
//                $("#f_percen").val(obj[1]);
//                $("#f_max").val(obj[2]);
//                $("#div-bonus").attr("style", "display:block;")
//            }
//        }
//    }
//}

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


