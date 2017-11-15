var dp_appr = 0;
var dp_pend = 0;
var dp_rej = 0;

var wd_appr = 0;
var wd_pend = 0;
var wd_rej = 0;

var total = 0;


function clearForm() {
    $('#se-pre-con').fadeIn();

    $("#d_start").val(current_date);
    $("#d_end").val(current_date);
//    $("#s_website").val("");
    $("#s_username").val("");
    $("#fullname").val("");
    $("#phone").val("");
    $('#content-report').css("display", "none");
    $('#se-pre-con').delay(100).fadeOut();
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
            htmlOption += "<option value='ALL'>" + label_all + "</option>";
            $.each(res, function (i, item) {
                var txt = item.s_website;
                htmlOption += "<option value='" + item.i_web + "'>" + txt + "</option>";
            });

            $("#i_web").html(htmlOption);

        },
        error: function (data) {

        }

    });
}

function search() {
    $('#se-pre-con').fadeIn();
    var Jsdata = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/reportController.php',
        data: Jsdata,
        beforeSend: function ()
        {

        },
        success: function (data) {
            debugger;
            dp_appr = 0;
            dp_appr_bonus = 0;
            dp_appr_bonus_special = 0;
            dp_pend = 0;
            dp_rej = 0;

            wd_appr = 0;
            wd_pend = 0;
            wd_rej = 0;

            total = 0;



            $('#deposit-body').empty();
            $('#withdraw-body').empty();
            if (data == "") {
                $.notify(lb_search_noInfo, "error");
                $('#se-pre-con').delay(100).fadeOut();
                $('#content-report').css("display", "none");
                return;
            }
            var res = JSON.parse(data);

            $.each(res, function (i, item) {
                var dp = "";
                var wd = "";
                if (item.s_type == "DEPOSIT") {
                    dp += '<tr>';
                    dp += '<td>';
                    dp += item.d_create;
                    dp += '</td>';
//                    dp += '<td>';
//                    dp += item.s_website;
//                    dp += '</td>';
                    dp += '<td>';
                    dp += item.s_username;
                    dp += '</td>';
                    dp += '<td>';
                    dp += item.s_fullname;
                    dp += '</td>';
                    dp += '<td>';
                    dp += number_format(item.f_amount, 2);
                    dp += '</td>';
                    dp += '<td>';
                    dp += '     <span class="badge badge-' + colorStatusCS(item.s_status) + '">' + sortHidden(item.s_status) + (language == "th" ? item.status_th : item.status_en) + '</span>';
                    dp += '</td>';
                    dp += '</tr>';
                }
                if (item.s_type == "WITHDRAW") {
                    wd += '<tr>';
                    wd += '<td>';
                    wd += item.d_create;
                    wd += '</td>';
//                    wd += '<td>';
//                    wd += item.s_website;
//                    wd += '</td>';
                    wd += '<td>';
                    wd += item.s_username;
                    wd += '</td>';
                    wd += '<td>';
                    wd += item.s_fullname;
                    wd += '</td>';
                    wd += '<td>';
                    wd += number_format(item.f_amount, 2);
                    wd += '</td>';
                    wd += '<td>';
                    wd += '     <span class="badge badge-' + colorStatusCS(item.s_status) + '">' + sortHidden(item.s_status) + (language == "th" ? item.status_th : item.status_en) + '</span>';
                    wd += '</td>';
                    wd += '</tr>';
                }

                countReport(item.s_type, item.f_amount, item.s_status);
                countReportBonus(item.s_type, item.f_bonus, item.s_status);
                countReportBonusSpecial(item.s_type, item.f_bonus_special, item.s_status);




                $('#deposit-body').append(dp);
                $('#withdraw-body').append(wd);
            });


            $('#rs_dp_appr').text(number_format(dp_appr, 2));
            $('#rs_dp_pend').text(number_format(dp_pend, 2));
            $('#rs_dp_rej').text(number_format(dp_rej, 2));
//            $('#rs_dp').text(number_format(dp_appr, 2));

            $('#rs_dp_appr_bonus').text(number_format(dp_appr_bonus, 2));
            $('#rs_dp_appr_bonus_spcial').text(number_format(dp_appr_bonus_special, 2));


            $('#rs_wd_appr').text(number_format(wd_appr, 2));
            $('#rs_wd_pend').text(number_format(wd_pend, 2));
            $('#rs_wd_rej').text(number_format(wd_rej, 2));
//            $('#rs_wd').text(number_format(wd_appr, 2));

            total = dp_appr - wd_appr;

            $('#rs_result').text(number_format(total, 2));
            if (total > 0) {
                $('#rs_result').css("color", "green");
            } else if (total < 0) {
                $('#rs_result').css("color", "red");
            } else {
                $('#rs_result').css("color", "black");
            }

            $('#content-report').css("display", "block");
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            $('#se-pre-con').delay(100).fadeOut();
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

function countReport(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr += amount;
        } else if (status == "PEND") {
            dp_pend += amount;
        } else if (status == "REJ") {
            dp_rej += amount;
        }
    } else if (type == "WITHDRAW") {
        if (status == "APPR") {
            wd_appr += amount;
        } else if (status == "PEND") {
            wd_pend += amount;
        } else if (status == "REJ") {
            wd_rej += amount;
        }
    }

}
function countReportBonus(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr_bonus += amount;
        }
    }
}
function countReportBonusSpecial(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr_bonus_special += amount;
        }
    }
}

