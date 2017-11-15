function clearForm() {
    $('#se-pre-con').fadeIn();

    $("#d_start").val(current_date);
    $("#d_end").val(current_date);
    $("#s_menu").val("ALL");
    $("#s_action").val("ALL");
    $("#username").val("");
    $("#other").val("");
    $('#content-report').css("display", "none");
    $('#se-pre-con').delay(100).fadeOut();
}





var $datatable = $('#datatable');
function search() {

    $('#se-pre-con').fadeIn();
    var Jsdata = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/reportLogController.php',
        data: Jsdata,
        beforeSend: function ()
        {

        },
        success: function (data) {
            debugger;

            if (data == '') {
                $('#content-report').css("display", "none");
                $.notify(lb_search_noInfo, "error");
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }


            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function (i, item) {
                var col_datetime = item.d_create;
                var col_menu = item.s_menu;
                var col_acion = item.s_action;
                var col_user = item.s_create_by;
                var col_view = "";

                col_view += '<a href="cs_view.php?id=' + item.i_log + '" target="_bank" class="btn btn-circle btn-icon-only blue">';
                col_view += ' <i class="fa fa-eye"></i>';
                col_view += '</a>';



                var addRow = [
                    col_datetime,
                    col_menu,
                    col_acion,
                    col_user,
                    col_view
                ]

                JsonData.push(addRow);

            });


            var datatable = $datatable.dataTable().api();
            $('.dataTables_empty').remove();
            datatable.clear();
            datatable.rows.add(JsonData);
            datatable.draw();

            $('#content-report').css("display", "block");
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}




function initialDatatable() {
    var JsonData = [];
    $datatable.dataTable({
        data: JsonData,
        order: [[0, 'desc']],
        columnDefs: [
            {"orderable": true, "targets": 0}
        ]
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
         
        },
        error: function (data) {

        }

    });
}
