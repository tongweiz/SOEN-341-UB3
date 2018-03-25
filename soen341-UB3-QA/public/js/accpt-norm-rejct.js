$(document).ready(function () {
    $(".accept").click(function () {
        let c = $(this).children();
        let idAttr = c.attr("id");
        let id = idAttr.substr(0, idAttr.length - 1);

        $.get("/question/accept/" + id, function (data, status) {
            if (status == "success") {
                if(data == '##') { /*alert("You can only accept a single reply at a time!");*/ }
                else {
                    applyStatus(id, data);
                }
            }
        });
    });

    $(".normalize").click(function () {
        let c = $(this).children();
        let idAttr = c.attr("id");
        let id = idAttr.substr(0, idAttr.length - 1);

        $.get("/question/normalize/" + id, function (data, status) {
            if (status == "success") {
                applyStatus(id, data);
            }
        });
    });

    $(".reject").click(function () {
        let c = $(this).children();
        let idAttr = c.attr("id");
        let id = idAttr.substr(0, idAttr.length - 1);

        $.get("/question/reject/" + id, function (data, status) {
            if (status == "success") {
                applyStatus(id, data);
            }
        });
    });
});

function applyStatus(id, data) {
    $("#" + id + "a").attr("class", "fa fa-check-circle");
    $("#" + id + "n").attr("class", "fa fa-bars");
    $("#" + id + "r").attr("class", "fa fa-ban");

    switch(data) {
        case "1":
            $("#" + id + "a").attr("class", "fa fa-check-circle fa-2x");
            break;
        case "0":
            $("#" + id + "n").attr("class", "fa fa-bars fa-2x");
            break;
        case "-1":
            $("#" + id + "r").attr("class", "fa fa-ban fa-2x");
            break;
        default:
            alert("Error in accpt-norm-rejct script");
    }
}
