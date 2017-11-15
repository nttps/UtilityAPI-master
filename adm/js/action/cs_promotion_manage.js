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
            if (keyEdit != "") {
                edit();
            }

        },
        error: function (data) {

        }

    });
}





function edit() {
    var _th = true;
    var _en = true;
    $.ajax({
        type: 'GET',
        url: 'controller/promotionCSController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_detail_th").val(item.s_detail_th);
//                $("#s_detail_en").val(item.s_detail_en);
                $("#f_percen").val(item.f_percen);
                $("#f_max_bath").val(item.f_max_bath);
                $("#i_use").val(item.i_use);
//                recursiveSetValue("th", item.s_condition_th);
//                recursiveSetValue("en", item.s_condition_en);



//                $("#i_bank").val(item.i_ref).trigger('change');

                $("#status").val(item.s_status);




                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });

            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });


    function recursiveSetValue(lang, value) {
        if (lang == "th") {
            CKEDITOR.instances.s_condition_th.setData(value, function () {

                if (this.checkDirty() && _th) {
                    _th = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        } else {
            CKEDITOR.instances.s_condition_en.setData(value, function () {

                if (this.checkDirty() && _en) {
                    _en = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        }
    }


}





function save() {
//    var s_condition_th = CKEDITOR.instances['s_condition_th'].getData();
//    $('#s_condition_th').val(s_condition_th);
//    var s_condition_en = CKEDITOR.instances['s_condition_en'].getData();
//    $('#s_condition_en').val(s_condition_en);

    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/promotionCSController.php',
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
                setTimeout(reloadTime, 1000);
            });
//            location.reload();
        },
        error: function (data) {

        }

    });
}


function CKupdate() {
    for (s_condition_th in CKEDITOR.instances) {
        CKEDITOR.instances[s_condition_th].updateElement();
    }
    CKEDITOR.instances[s_condition_th].setData('');


    for (s_condition_en in CKEDITOR.instances) {
        CKEDITOR.instances[s_condition_en].updateElement();
    }
    CKEDITOR.instances[s_condition_en].setData('');
}   