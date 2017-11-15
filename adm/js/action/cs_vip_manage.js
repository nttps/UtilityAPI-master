var cnt_element = 1;
if (keyEdit != "") {
    function edit() {
        $.ajax({
            type: 'GET',
            url: 'controller/vipController.php?func=getInfo&id=' + keyEdit,
            beforeSend: function ()
            {
                //$('#se-pre-con').fadeIn(100);
            },
            success: function (data) {
                var res = JSON.parse(data);
                $.each(res, function (i, item) {
                    debugger;
                    $("#s_main").val(item.s_main);
                    $("#s_main").attr("readonly", "readonly");
                    setValueSub(item.s_sub);

                    $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                    var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                    $("#lb_edit").text(lb_edit);

//                    cnt_element = item.i_index;

                });
                $('#se-pre-con').delay(100).fadeOut();

            },
            error: function (data) {

            }

        });
    }
}

var buttonArray = [];


function addElement() {
    var txt = label_multi;
    var key = cnt_element;
    var div = document.createElement("div");
    div.className = "form-group form-md-line-input has-success";
    div.id = "div_" + key;


    var label = document.createElement("label");
    label.className = "control-label";
    label.innerHTML = txt;


    var divAppend1 = document.createElement("div");
    divAppend1.className = "col-md-10";

    var input = document.createElement("input");
    input.className = "form-control bold";
    input.type = "text";
    input.id = "s_sub_" + key;
    input.name = "s_sub_" + key;

    var divAppend2 = document.createElement("div");
    divAppend2.className = "col-md-2";


    var i2 = document.createElement("i");
    i2.className = "fa fa-minus";
    var button = document.createElement("button");
    button.type = "button";
    button.className = "btn red";
//                                            button.innerHTML = "-";
    button.onclick = function () {
        removeEle(key);
    };

    var br = document.createElement("br");


    divAppend1.appendChild(label);
    divAppend1.appendChild(input);
    div.appendChild(divAppend1);

    button.appendChild(i2);
    divAppend2.appendChild(button);
    div.appendChild(divAppend2);
    div.appendChild(br);

    var multibutton = document.getElementById("multibutton");
    multibutton.appendChild(div);

    cnt_element++;
}


function addElementForEdit(value) {
    var txt = label_multi;
    var key = cnt_element;
    var div = document.createElement("div");
    div.className = "form-group form-md-line-input has-success";
    div.id = "div_" + key;


    var label = document.createElement("label");
    label.className = "control-label";
    label.innerHTML = txt;


    var divAppend1 = document.createElement("div");
    divAppend1.className = "col-md-10";

    var input = document.createElement("input");
    input.className = "form-control bold";
    input.type = "text";
    input.id = "s_sub_" + key;
    input.name = "s_sub_" + key;
    input.value = value;

    var divAppend2 = document.createElement("div");
    divAppend2.className = "col-md-2";


    var i2 = document.createElement("i");
    i2.className = "fa fa-minus";
    var button = document.createElement("button");
    button.type = "button";
    button.className = "btn red";
//                                            button.innerHTML = "-";
    button.onclick = function () {
        removeEle(key);
    };

    var br = document.createElement("br");


    divAppend1.appendChild(label);
    divAppend1.appendChild(input);
    div.appendChild(divAppend1);

    button.appendChild(i2);
    divAppend2.appendChild(button);
    div.appendChild(divAppend2);
    div.appendChild(br);

    var multibutton = document.getElementById("multibutton");
    multibutton.appendChild(div);

    cnt_element++;
}





function removeEle(id) {
    buttonArray = buttonArray.filter(function (item) {
        return item !== id;
    });
    var elem = document.getElementById("div_" + id);
    elem.parentNode.removeChild(elem);
}

function removeEleAll() {
    $("#multibutton").empty();
}










function setValueSub(value) {
//    if (index == "1") {
//        $("#s_sub_1").val(value);
//    } else if (index == "2") {
//        $("#s_sub_2").val(value);
//    } else if (index == "3") {
//        $("#s_sub_3").val(value);
//    } else if (index == "4") {
//        $("#s_sub_4").val(value);
//    } else if (index == "5") {
//        $("#s_sub_5").val(value);
//    } else if (index == "6") {
//        $("#s_sub_6").val(value);
//    }
    addElementForEdit(value);

}



function save() {
    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/vipController.php',
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
