function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonUIController.php?func=DDLStatusALL',
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
        url: 'controller/commonUIController.php?func=DDLPointionGL',
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
            getDDLType();
        },
        error: function (data) {

        }

    });
}
function getDDLType() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonUIController.php?func=DDLTypeGL',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_type_th : item.s_type_en);
                htmlOption += "<option value='" + item.i_type + "'>" + txt_status + "</option>";
            });
            $("#i_type").html(htmlOption);
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
        url: 'controller/commonUIController.php?func=DDLServerGL',
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
                edit();
            } else {
                changeConditon();
            }

        },
        error: function (ddl) {

        }



    });
}
function changeConditon() {
    var type = $('#i_type').val();

    if (type == "1") {
        $('#div-sv').attr('style', 'display:block;');
        $('#div-sv-src').attr('style', 'display:block;');

        $('#div-img2').attr('style', 'display:none;');
        $("#div-img2 .fileinput").fileinput('clear');

        if ($('#i_sv_media').val() == null) {
            $("#i_sv_media").val(1).trigger('change');
        }


    } else if (type == "2") {
        $('#div-img2').attr('style', 'display:block;');

        $('#div-sv').attr('style', 'display:none;');
        $('#div-sv-src').attr('style', 'display:none;');
    }
}

function editConditon(type) {
    if (type == "1") {
        $('#div-sv').attr('style', 'display:block;');
        $('#div-sv-src').attr('style', 'display:block;');

        $('#div-img2').attr('style', 'display:none;');
    } else if (type == "2") {
        $('#div-img2').attr('style', 'display:block;');

        $('#div-sv').attr('style', 'display:none;');
        $('#div-sv-src').attr('style', 'display:none;');
    }
}



function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/uiGalleryController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            $("#tmp_img_p1").val("");
            $("#tmp_img_p2").val("");
            $('#img1').attr('src', 'images/no-image.png');
            $('#img2').attr('src', 'images/no-image.png');
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#i_pointion").val(item.i_pointion);
                $("#i_type").val(item.i_type);
                $("#old_i_type").val(item.i_type);
                $("#i_index").val(item.i_index);
                $("#s_desc_th").val(item.s_desc_th);
                $("#s_desc_en").val(item.s_desc_en);

                editConditon(item.i_type);
                if (item.i_sv_media != "") {
                    $("#i_sv_media").val(item.i_sv_media).trigger('change');
                    $("#s_src_media").val(item.s_src_media);
                }
                $("#status").val(item.s_status);

                if (item.s_img_p1 != "") {
                    $('#img1').attr('src', 'upload/gallery/' + item.s_img_p1);
                    $("#tmp_img_p1").val(item.s_img_p1);
                }
                if (item.s_img_p2 != "") {
                    $('#img2').attr('src', 'upload/gallery/' + item.s_img_p2);
                    $("#tmp_img_p2").val(item.s_img_p2);
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
    $('#form-action').submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/uiGalleryController.php',
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
                $('#se-pre-con').delay(100).fadeOut();
                notification();
                $('#form-action').each(function () {
                    setTimeout(reloadTime, 1000);
                });
            }, error: function (data) {

            }
        });
    });
}
