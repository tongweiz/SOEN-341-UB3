$(document).ready(function () {
    $("#pageP").click(function () {
        let pageNb = parseInt($("#page").attr("class"), 10);
        if(pageNb == 0){
        } else {
            pageNb -= 1;
            let order = $('#ord').attr("class");
            let direction = $('#dir').attr("class");

            $.get("/home/" + order + "/" + direction + "/" + pageNb, function (data, status) {
                if (status == "success") {
                    document.getElementById("questions").innerHTML = data;
                } else console.log("Error");
            });
        }
    });

    $("#pageN").click(function () {
        if(parseInt($("#lastP").attr("class"), 10) == 0) {
            let pageNb = parseInt($("#page").attr("class"), 10);
            pageNb += 1;
            let order = $('#ord').attr("class");
            let direction = $('#dir').attr("class");

            $.get("/home/" + order + "/" + direction + "/" + pageNb, function (data, status) {
                if (status == "success") {
                    document.getElementById("questions").innerHTML = data;
                } else console.log("Error");
            });
        }
    });
});