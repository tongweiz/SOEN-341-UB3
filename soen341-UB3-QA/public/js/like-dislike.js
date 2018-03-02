$(document).ready(function () {
    $(".like").click(function () {
        let idAttr = $(this).attr("id");
        let id = idAttr.substr(0, idAttr.length - 2);

        let sid = "#" + id + "l";
        let did = "/question/like/" + id;

        $.get("/question/like/" + id, function (data, status) {
            if (status == "success") {
                if (data == "#") {
                    alert("You are not logged in! Only logged in users can like replies. " +
                        "Please use the Login or Register links at the top of the page and try again.");
                }
                else if (data == "##") {
                    alert("You have already liked this reply before!");
                }
                else {
                    let str = /(\d+)\.(\d+)/.exec(data);
                    $("#" + id + "l").text(str[1]);
                    $("#" + id + "dl").text(str[2]);
                    $("#" + idAttr).prop("disabled", true);
                    $("#" + idAttr).prop("style", "color: rgb(176,224,230);");
                    $("#" + id + "bdl").prop("disabled", false);
                    $("#" + id + "bdl").prop("style", "color: rgb(30, 144, 255);");
                }
            }
        });
    });

    $(".dislike").click(function () {
        let idAttr = $(this).attr("id")
        let id = idAttr.substr(0, idAttr.length - 3);

        let sid = "#" + id + "dl";
        let did = "/question/dislike/" + id;

        $.get("/question/dislike/" + id, function (data, status) {
            if (status == "success") {
                if (data == "#") {
                    alert("You are not logged in! Only logged in users can dislike replies. " +
                        "Please use the Login or Register links at the top of the page and try again.");
                }
                else if(data == "##"){
                    alert("You have already disliked this reply before!");
                }
                else {
                    let str = /(\d+)\.(\d+)/.exec(data);
                    $("#" + id + "l").text(str[1]);
                    $("#" + id + "dl").text(str[2]);
                    $("#" + idAttr).prop("disabled", true);
                    $("#" + idAttr).prop("style", "color: rgb(176,224,230);");
                    $("#" + id + "bl").prop("disabled", false);
                    $("#" + id + "bl").prop("style", "color: rgb(30, 144, 255);");
                }
            }
        });
    });
});
