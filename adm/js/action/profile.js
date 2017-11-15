
function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/profileController.php?func=getInfo',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                //      debugger;
                $("#s_firstname").val(item.s_firstname);
                $("#s_lastname").val(item.s_lastname);
                $("#s_email").val(item.s_email);
                $("#s_phone").val(item.s_phone);

                $("#s_fullname").text(item.s_firstname + " " + item.s_lastname);

                $("#s_type").text(item.s_type);
                $('#img_profile').attr('src', 'images/profile/' + item.s_image);
                $('#old_picture').val(item.s_image);


//                $("#s_bank_name_th").val(item.s_bank_name_th);
//                $("#s_bank_name_en").val(item.s_bank_name_en);
//                $("#i_bank").val(item.i_ref).trigger('change');


                tab(1);
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
        url: 'controller/profileController.php',
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
            notification();
            $('#form-action').each(function () {
                setTimeout(reloadTime, 1000);
            });
        },
        error: function (data) {

        }

    });
}

function savePassword() {
    var Jsdata = $("#form-action-password").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/profileController.php',
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
                clearFormPassword();
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");
            }
            $('#se-pre-con').delay(100).fadeOut();
            notification();
        },
        error: function (data) {

        }

    });
}

function clearFormPassword() {
    $('#s_pass_old').val('');
    $('#s_pass').val('');
    $('#s_pass_confirm').val('');
}



function savePicture() {

    $('#form-action-picture').submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/profileController.php',
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
                $('#form-action-picture').each(function () {
//                    $('#se-pre-con').delay(100).fadeOut();
                    setTimeout(reloadTime, 1000);
                });
            }, error: function (data) {

            }
        });
    });
}










// class="active"
function tab(tab) {
    if (tab == 1) {
        $('#li-tab1').attr('class', 'active');
        $('#li-tab2').attr('class', '');
        $('#li-tab3').attr('class', '');

        $('#tab_1_1').attr('class', 'tab-pane active');
        $('#tab_1_2').attr('class', 'tab-pane');
        $('#tab_1_3').attr('class', 'tab-pane');
    } else if (tab == 2) {
        $('#li-tab1').attr('class', '');
        $('#li-tab2').attr('class', 'active');
        $('#li-tab3').attr('class', '');

        $('#tab_1_1').attr('class', 'tab-pane');
        $('#tab_1_2').attr('class', 'tab-pane active');
        $('#tab_1_3').attr('class', 'tab-pane');
    } else if (tab == 3) {
        $('#li-tab1').attr('class', '');
        $('#li-tab2').attr('class', '');
        $('#li-tab3').attr('class', 'active');

        $('#tab_1_1').attr('class', 'tab-pane');
        $('#tab_1_2').attr('class', 'tab-pane');
        $('#tab_1_3').attr('class', 'tab-pane active');
    }
}