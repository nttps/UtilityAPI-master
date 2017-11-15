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
            getDDLFunction();


        },
        error: function (data) {

        }

    });
}

function getDDLFunction() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLFunction',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_th : item.s_en);
                htmlOption += "<option value='" + item.s_function + "'>" + txt_status + "</option>";
            });
            $("#s_function").html(htmlOption);
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
        url: 'controller/licenseController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                $("#s_domain").val(item.s_domain);
                $("#s_license_key").val(item.s_license_key);
                $("#s_function").val(item.s_function);

                $('input:checkbox[id="kbank"]').attr('checked', setCK(item.s_kbank));
                $('input:checkbox[id="scb"]').attr('checked', setCK(item.s_scb));
                $('input:checkbox[id="bbl"]').attr('checked', setCK(item.s_bbl));
                $('input:checkbox[id="ktb"]').attr('checked', setCK(item.s_ktb));
                $('input:checkbox[id="bay"]').attr('checked', setCK(item.s_bay));
                $('input:checkbox[id="truewallet"]').attr('checked', setCK(item.s_truewallet));

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

function save() {
    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/licenseController.php',
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


function setCK(val) {
    if (val == "Y") {
        return true;
    } else {
        return false;
    }
}