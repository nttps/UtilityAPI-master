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
            $("#status_auto").html(htmlOption);
            getInfo();
        },
        error: function (data) {

        }

    });
}

function getInfo() {
    $.ajax({
        type: 'GET',
        url: 'controller/popupController.php?func=getInfo',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }

            var res = JSON.parse(data);
            $.each(res, function (i, item) {


                $('#img1').attr('src', (item.s_img_p1 != "" ? "upload/postpromotion/" + item.s_img_p1 : "images/no_photo.png"));

                $("#tmp_img_p1").val(item.s_img_p1);

                $("#d_start").val(item.d_start);
                $("#d_end").val(item.d_end);

                $("#s_url").val(item.s_url);



                $("#status").val(item.s_status);
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
            url: 'controller/popupController.php',
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