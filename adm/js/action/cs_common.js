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
            '<span><img src="images/bank/' + state.img + '" width="30px" height="25px" class="img-flag" Style="margin-bottom: 5px;"/> ' + state.text + '</span>'
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
        },
        error: function (ddl) {

        }



    });
}


function getDDLSEO() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLSEO',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.i_seo + "'>" + txt + "</option>";
            });
            $("#i_seo").html(htmlOption);
        },
        error: function (data) {

        }

    });
}

function getDDLTime() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLTime',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.i_time + "'>" + txt + "</option>";
            });
            $("#i_time").html(htmlOption);
        },
        error: function (data) {

        }

    });
}