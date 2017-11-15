function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonPOController.php?func=DDLStatusALL',
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
            getDDLPointion();
        },
        error: function (data) {

        }

    });
}
function getDDLPointion() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonPOController.php?func=DDLPointionVIDEO',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.i_pointion + "'>" + txt_status + "</option>";
            });
            $("#i_pointion").html(htmlOption);
            getDDLServer();
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
            '<span><img src="images/serverMedia/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}
function getDDLServer() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonPOController.php?func=DDLServer',
        beforeSend: function ()
        {},
        success: function (ddl) {
//            debugger;
            var res = JSON.parse(ddl);
            $("#i_sv_media").select2({
                data: res,
                templateResult: formatState,
                templateSelection: formatState

            });
            if (keyEdit != "") {
                setTimeout (edit, 2000);
//                edit();
            } else {
                unloading();
            }

        },
        error: function (ddl) {

        }



    });
}

function edit() {
    var _th = true;
    var _en = true;
    $.ajax({
        type: 'GET',
        url: 'controller/poVideoController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            $("#tmp_img_p1").val("");
//            $("#tmp_img_p2").val("");
            $('#img1').attr('src', 'images/no-image.png');
//            $('#img2').attr('src', 'images/no-image.png');
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;



                $("#i_pointion").val(item.i_pointion);
                $("#i_sv_media").val(item.i_sv_media).trigger('change');
                ;
                $("#s_src_media").val(item.s_src_media);

                $("#s_link").val(item.s_link);
                $("#i_index").val(item.i_index);

                $("#i_view").val(item.i_view);
                $("#i_vote").val(item.i_vote);

                $("#s_subject_th").val(item.s_subject_th);
                $("#s_subject_en").val(item.s_subject_en);
                $("#s_detail_th").val(item.s_detail_th);
                $("#s_detail_en").val(item.s_detail_en);
                recursiveSetValue("th", item.s_condition_th);
                recursiveSetValue("en", item.s_condition_en);



                $("#status").val(item.s_status);
                if (item.s_img_p1 != "") {
                    $('#img1').attr('src', 'upload/postvideo/' + item.s_img_p1);
                    $("#tmp_img_p1").val(item.s_img_p1);
                }
//                if (item.s_img_p2 != "") {
//                    $('#img2').attr('src', 'upload/postpicture/' + item.s_img_p2);
//                    $("#tmp_img_p2").val(item.s_img_p2);
//                }





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
            CKEDITOR.instances.s_detail_th.setData(value, function () {

                if (this.checkDirty() && _th) {
                    _th = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        } else {
            CKEDITOR.instances.s_detail_en.setData(value, function () {

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
    $('#form-action').submit(function (e) {
        var s_detail_th = CKEDITOR.instances['s_detail_th'].getData();
        $('#s_detail_th').val(s_detail_th);
        var s_detail_en = CKEDITOR.instances['s_detail_en'].getData();
        $('#s_detail_en').val(s_detail_en);

        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/poVideoController.php',
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






