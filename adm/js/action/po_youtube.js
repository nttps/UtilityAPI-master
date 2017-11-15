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
        url: 'controller/youtubeController.php?func=getInfo',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {


                $("#status").val(item.s_status);
                $("#status_auto").val(item.s_status_auto);
                $("#url_id").val(item.url_id);

                var url = item.url_prefix + item.url_id + (item.s_status_auto == "A" ? item.url_prefix_auto : "");

                $('#url_live').attr('src', url);
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
    $.ajax({
        type: 'POST',
        url: 'controller/youtubeController.php',
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
                //fix
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            $('#se-pre-con').delay(100).fadeOut();
            notification();
            $('#form-action').each(function () {
                setTimeout(reloadTime, 1000);
            });
        },
        error: function (data) {

        }

    });




}