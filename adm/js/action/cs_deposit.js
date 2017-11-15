
var $datatable = $('#datatable');
function initialDataTable(first) {
    $.ajax({
        type: 'GET',
        url: 'controller/depositController.php?func=dataTable',
        beforeSend: function ()
        {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == '') {
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

                var col_checkbox = "";
                var col_website = item.s_website;
                var col_game = item.s_game;
                var col_username = (item.s_username != "" ? item.s_username : "-");
//                var col_name = item.s_firstname;
                var col_bank = '';
                var col_amount = number_format(item.f_total, 2);
                var col_datetime = item.d_dp_date + " " + item.d_dp_time;
                var col_premise = "-";



                var col_status = "";
                var col_edit = "";
                var col_delete = "";
//                    col_checkbox = '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" style="padding-right: 30px;">';
//                    col_checkbox += '<input type="checkbox" class="checkboxes" value="1" />';
//                    col_checkbox += '<span></span>';
//                    col_checkbox += ' </label>';
                col_checkbox = '<span class="md-checkbox has-success" style="padding-right: 0px;">';
                col_checkbox += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem" class="md-check"';
                col_checkbox += '  value="' + item.i_dp + '" onclick=remove_select_all("checkbox_' + i + '")>';
                col_checkbox += '  <label for="checkbox_' + i + '">';
                col_checkbox += '    <span class="inc"></span>';
                col_checkbox += '    <span class="check"></span>';
                col_checkbox += '    <span class="box"></span> </label>';
                col_checkbox += '</span>';


                var tooltip = (language == "th" ? item.s_bank_name_th : item.s_bank_name_en) + " : " + item.s_bank_no;

                col_bank = '<span data-toggle="tooltip" data-placement="top" title="' + tooltip + '" > ';
                col_bank += '<img  src="images/bank/' + item.s_img_bank + '" width="40px" height="25px" />';
                col_bank += '</span>';

                if (item.s_img != "") {
                    col_premise = '<a title="' + item.s_img + '" class="example-image-link" href="upload/premise/' + item.s_img + '" data-lightbox="example-' + item.i_dp + '">';
                    col_premise += '<img class="example-image" src="upload/premise/' + item.s_img + '" width="50px" height="50px"  />';
                    col_premise += '</a>';
//                    col_premise = '';
//                    col_premise += '      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-1.jpg" data-lightbox="example-1"><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-1.jpg" alt="image-1" />  </a>';
                }


                col_status = '';
                col_status += '<span class="badge badge-' + colorStatusCS(item.s_status) + '">' + sortHidden(item.s_status) + (language == "th" ? item.status_th : item.status_en) + '</span>';
                col_status += '';


                col_edit += '<a href="cs_deposit_manage.php?func=edit&id=' + item.i_dp + '" class="btn btn-circle btn-icon-only blue">';
                col_edit += ' <i class="fa fa-edit"></i>';
                col_edit += '</a>';




                col_delete += '<a href="' + (disable != "" ? '#' : 'javascript:Confirm(\'' + item.i_dp + '\',\'delete\');') + '" class="btn btn-circle btn-icon-only red" ' + disable + '>';
                col_delete += ' <i class="fa fa-trash-o"></i>';
                col_delete += '</a>';



                var addRow = [
                    col_checkbox,
                    col_website,
                    col_game,
                    col_username,
//                    col_name,
                    col_bank,
                    col_amount,
                    col_datetime,
                    col_premise,
                    col_status,
                    col_edit,
                    col_delete
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [[6, 'asc'], [4, 'desc']],
                    columnDefs: [
                        {"orderable": false, "targets": 0}
                    ]
                });
            } else {

                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            notification();
            $('[data-toggle="tooltip"]').tooltip();
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}

function colorStatusCS(status) {
    if (status == "APPR") {
        return "success";
    } else if (status == "PEND") {
        return "warning";
    } else if (status == "REJ") {
        return "danger";
    }
}

function sortHidden(status) {
    if (status == "APPR") {
        return "<span style='display:none;'>2</span>";
    } else if (status == "PEND") {
        return "<span style='display:none;'>1</span>";
    } else if (status == "REJ") {
        return "<span style='display:none;'>3</span>";
    }
}


$('#checkbox14').click(function () {
    var checkboxes = $('input[name$=checkboxItem]');
    var array = [];
    $('input[name$="checkboxItem"]').each(function () {
        array.push($(this).attr('id'));
    });
    if ($(this).is(':checked')) {
        checkboxes.prop('checked', true);
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function (key, value) {
            $('input:checkbox[id=' + value + ']').attr('checked', true);
        });
    } else {
        checkboxes.prop('checked', false);
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function (key, value) {
            $('input:checkbox[id=' + value + ']').attr('checked', false);
        });
    }
});

function remove_select_all(id) {
    var selected = [];
    if ($("#" + id).is(':checked')) {
        $('input:checkbox[id=' + id + ']').attr('checked', true);

        //set element select all selected
        var array = [];
        $('input[name$="checkboxItem"]').each(function () {
            array.push($(this).attr('id'));
        });
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function (key, value) {
            if ($("#" + value).is(':checked')) {
                selected.push($("#" + value).val());
            }
        });
        if (selected.length == array.length) {
            var ck_select_all = $('#checkbox14');
            ck_select_all.prop('checked', true);
        }


    } else {
        $('input:checkbox[id=' + id + ']').attr('checked', false);
        var ck_select_all = $('#checkbox14');
        ck_select_all.prop('checked', false);
    }
}

function deleteAll() {
    $('#se-pre-con').fadeIn(100);
    $.notify.addStyle('foo', {
        html:
                "<div>" +
                "<div class='clearfix'>" +
                "<div class='title' data-notify-html='title'/>" +
                "<div class='buttons'>" +
                "<button class='notify-all-no btn red'>" + cancel + "</button>" +
                "<button class='notify-all-yes btn green'>" + yes + "</button>" +
                "</div>" +
                "</div>" +
                "</div>"
    });

    $.notify({
        title: title,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });

}
$(document).on('click', '.notifyjs-foo-base .notify-all-no', function () {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-all-yes', function () {
    $(this).trigger('notify-hide');
    var selected = [];
    var array = [];
    $('input[name$="checkboxItem"]').each(function () {
        array.push($(this).attr('id'));
    });
    var names = [];
    names = jQuery.unique(array);
    $.each(names, function (key, value) {
        if ($("#" + value).is(':checked')) {
            //alert($("#" + value).val());
            selected.push($("#" + value).val());

        }
    });
    var jsonData = selected;

    $.ajax({
        type: 'GET',
        url: 'controller/depositController.php',
        data: {data: jsonData, func: "deleteAll"},
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

            }
            $('#se-pre-con').delay(100).fadeOut();
            initialDataTable("FALSE");
        },
        error: function (data) {

        }

    });

});













function Confirm(txt, func) {
    $('#se-pre-con').fadeIn(100);
    $.notify.addStyle('foo', {
        html:
                "<div>" +
                "<div class='clearfix'>" +
                "<div class='title' data-notify-html='title'/>" +
                "<div class='buttons'>" +
                "<input type='hidden' id='id' value='" + txt + "' />" +
                "<input type='hidden' id='func' value='" + func + "' />" +
                "<button class='notify-no btn red'>" + cancel + "</button>" +
                "<button class='notify-yes btn green'>" + yes + "</button>" +
                "</div>" +
                "</div>" +
                "</div>"
    });

    $.notify({
        title: title,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });

}
$(document).on('click', '.notifyjs-foo-base .notify-no', function () {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-yes', function () {
    $(this).trigger('notify-hide');
    var id = $("#id").val();
    var func = $("#func").val();

    $.ajax({
        type: 'GET',
        url: 'controller/depositController.php?func=' + func + '&id=' + id,
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

            }
            $('#se-pre-con').delay(100).fadeOut();
            initialDataTable("FALSE");
        },
        error: function (data) {

        }

    });

});





