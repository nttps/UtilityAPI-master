function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLStatusALL',
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
        url: 'controller/bankCSController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_bank_no").val(item.s_bank_no);
                $("#s_bank_name_th").val(item.s_bank_name_th);
//                $("#s_bank_name_en").val(item.s_bank_name_en);
                $("#i_bank").val(item.i_ref).trigger('change');
                $("#status").val(item.s_status);
                $("#f_amount_base").val(item.f_amount_base);





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
        url: 'controller/bankCSController.php',
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
            $('#se-pre-con').delay(100).fadeOut();
            notification();
            $('#form-action').each(function () {
                getDDLStatus();
                this.reset();
            });
//            location.reload();
        },
        error: function (data) {

        }

    });
}