
var $datatable = $('#datatable');
function initialDataTable(first) {
    $.ajax({
        type: 'GET',
        url: 'controller/poPictureController.php?func=dataTable',
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
                var col_picture = "";
                var col_subject = (language == "th" ? item.s_subject_th : item.s_subject_en);
                var col_pointion = (language == "th" ? item.point_th : item.point_en);
                var col_index = item.i_index;




                var col_status = "";
                var col_edit = "";
                var col_delete = "";

                col_checkbox = '<span class="md-checkbox has-success" style="padding-right: 0px;">';
                col_checkbox += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem" class="md-check"';
                col_checkbox += '  value="' + item.i_img + '" onclick=remove_select_all("checkbox_' + i + '")>';
                col_checkbox += '  <label for="checkbox_' + i + '">';
                col_checkbox += '    <span class="inc"></span>';
                col_checkbox += '    <span class="check"></span>';
                col_checkbox += '    <span class="box"></span> </label>';
                col_checkbox += '</span>';



                if (item.s_img_p1 != "") {
                    col_picture = '<a title="' + item.s_img_p1 + '" class="example-image-link" href="upload/postpicture/' + item.s_img_p1 + '" data-lightbox="example-' + item.i_img + '">';
                    col_picture += '<img class="example-image" src="upload/postpicture/' + item.s_img_p1 + '" width="50px" height="50px"  />';
                    col_picture += '</a>';
                }


                col_status = '';
                col_status += '<span class="badge badge-' + colorStatus(item.s_status) + '">' + sortHidden(item.s_status) + (language == "th" ? item.status_th : item.status_en) + '</span>';
                col_status += '';


                col_edit += '<a href="po_picture_manage.php?func=edit&id=' + item.i_img + '" class="btn btn-circle btn-icon-only blue">';
                col_edit += ' <i class="fa fa-edit"></i>';
                col_edit += '</a>';


                col_delete += '<a href="' + (disable != "" ? '#' : 'javascript:Confirm(\'' + item.i_img + '\',\'delete\');') + '" class="btn btn-circle btn-icon-only red" ' + disable + '>';
                col_delete += ' <i class="fa fa-trash-o"></i>';
                col_delete += '</a>';

                var addRow = [
                    col_checkbox,
                    col_picture,
                    col_subject,
                    col_pointion,
                    col_index,
                    col_status,
                    col_edit,
                    col_delete
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [[5, 'asc'], [4, 'asc']],
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

function colorStatus(status) {
    if (status == "A") {
        return "success";
    } else if (status == "C") {
        return "danger";
    }
}

function sortHidden(status) {
    if (status == "A") {
        return "<span style='display:none;'>1</span>";
    } else if (status == "C") {
        return "<span style='display:none;'>2</span>";
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
        url: 'controller/poPictureController.php',
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
        url: 'controller/poPictureController.php?func=' + func + '&id=' + id,
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





