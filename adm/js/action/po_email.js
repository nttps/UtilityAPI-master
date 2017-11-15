
function save(func) {

    var detail = CKEDITOR.instances['detail'].getData();
    $('#detail').val(detail);
    $('#func').val(func);

    var formData = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/poEmailController.php',
        data: formData,
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
            var fn = $('#func').val();
            if (fn == "send") {
                setTimeout(reloadTime, 1000);
            } else {
                $('#se-pre-con').delay(100).fadeOut();
            }
        }, error: function (data) {

        }
    });

}






