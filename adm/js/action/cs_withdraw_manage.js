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
            getDDLBankDP();
//            if (keyEdit != "") {
//                getDDLBank();
//            } else {
//                getDDLBankAdd();
//            }
            //    getDDLBankAdd();

        },
        error: function (data) {

        }

    });
}


function formatStateDP(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span>  (<span style="color:blue;font-weight:bold;">  ' + state.name + '  </span>:<span style="color:red;font-weight:bold;"> ' + state.no + ' </span>)</span>'
            );
    return $state;
}
function getDDLBankDP() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBankDeposit',
        beforeSend: function ()
        {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_bank_adm").select2({
                data: res,
                templateResult: formatStateDP,
                templateSelection: formatStateDP

            });

            DDLWebsite();
        },
        error: function (ddl) {

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
//            if (keyEdit != "") {
//                getDDLBank();
//            } else {
//                getDDLBankAdd();
//            }
            getDDLBankAdd();

        },
        error: function (data) {

        }

    });
}








//function getDDLBank() {
//    $.ajax({
//        type: 'GET',
//        url: 'controller/commonCSController.php?func=DDLBankWidhdraw&id=' + keyEdit,
//        beforeSend: function ()
//        {},
//        success: function (ddl) {
//            var res = JSON.parse(ddl);
//            $("#i_bank").select2({
//                data: res,
//                templateResult: formatState,
//                templateSelection: formatState
//
//            });
//            if (keyEdit != "") {
//                edit();
//            }
//        },
//        error: function (ddl) {
//
//        }
//
//
//
//    });
//}

function formatStateAdd(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span> </span>'
            );
    return $state;
}
function getDDLBankAdd() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBank',
        beforeSend: function ()
        {},
        success: function (ddl) {

            var res = JSON.parse(ddl);
            $("#i_bank").select2({
                data: res,
                templateResult: formatStateAdd,
                templateSelection: formatStateAdd

            });
            if (keyEdit != "") {
                edit();
            }
//            getDDLSEO();
        },
        error: function (ddl) {

        }



    });
}


function getDDLBankAddFind() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLBank',
        beforeSend: function ()
        {},
        success: function (ddl) {

            var res = JSON.parse(ddl);
            $("#i_bank").select2({
                data: res,
                templateResult: formatStateAdd,
                templateSelection: formatStateAdd

            });

//            getDDLSEO();
        },
        error: function (ddl) {

        }



    });
}


function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/withdrawController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                $("#i_web").val(item.i_web);
                $("#s_username").val(item.s_username);
//                $("#s_phone").val(item.s_phone);
                $("#f_amount").val(item.f_amount);
                $("#i_bank_adm").val(item.i_bank_adm).trigger('change');
                $("#i_bank").val(item.i_bank).trigger('change');
                $("#s_account_no").val(item.s_account_no);
                $("#s_account_name").val(item.s_account_name);
                $("#s_security").val(item.s_security);
                $("#status").val(item.s_status);

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
        url: 'controller/commonCSController.php?func=ValidSecurity&id=' + keyEdit + "&table=tb_cs_wd&field=i_wd",
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            debugger;
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;

                if (item.sh_username == "Y") {
                    $("#lb_val_username").text(item.username);
                    $('#class_val_username').attr('class', (item.succ_username == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_username').attr('class', (item.succ_username == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
                if (item.sh_security == "Y") {
                    $("#lb_val_secu").text(item.security);
                    $('#class_val_secu').attr('class', (item.succ_security == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_secu').attr('class', (item.succ_security == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
                if (item.sh_phone == "Y") {
                    $("#lb_val_phone").text(item.phone);
                    $('#class_val_phone').attr('class', (item.succ_phone == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_phone').attr('class', (item.succ_phone == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
                if (item.sh_bank == "Y") {
                    $("#lb_val_bank").text(item.bank);
                    $('#class_val_bank').attr('class', (item.succ_bank == "Y" ? "badge badge-success" : "badge badge-warning"));
                    $('#icon_val_bank').attr('class', (item.succ_bank == "Y" ? "fa fa-check-circle" : "fa fa-warning"));
                }
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
        url: 'controller/withdrawController.php',
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



function findBank() {
    $("#error_bank").text("");
    $("#s_account_no").val("");
    $("#s_account_name").val("");
//    getDDLBankAddFind();
    var username = $("#s_username").val();
    $.ajax({
        type: 'GET',
        url: 'controller/withdrawController.php?func=findBank&s_username=' + username,
        beforeSend: function ()
        {},
        success: function (data) {
            debugger;

            if (data == '') {
                $("#error_bank").text("ไม่พบข้อมูลบัญชีธนาคารของ Username นี้");
                return;
            }
            var res = JSON.parse(data);

            $.each(res, function (i, item) {
                $("#i_bank").val(item.i_bank).trigger('change');
                $("#s_account_no").val(item.s_account_no);
                $("#s_account_name").val(item.s_account_name);
            });

        },
        error: function (ddl) {

        }



    });
}