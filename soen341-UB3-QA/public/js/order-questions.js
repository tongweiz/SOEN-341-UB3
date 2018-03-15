$(document).ready(function () {
    $(".order").click(function () {
        let id = $(this).attr("id");
        let direction = $('#dir').attr("class");
        console.log(id + "..." + direction);
        $.get("/home/" + id + "/" + direction, function (data, status) {
            if (status == "success") {
                document.getElementById("questions").innerHTML = data;
                $('#ordo').text(id);
                $('#ord').attr("class", id);
            } else console.log("Error");
        });
    });

    $(".orderD").click(function () {
        let id = $(this).attr("id");
        let order = $('#ord').attr("class");

        $.get("/home/" + order + "/" + id, function (data, status) {
            if (status == "success") {
                document.getElementById("questions").innerHTML = data;
                $('#diro').text((id == 'asc')?'Ascending':'Descending');
                $('#dir').attr("class", id);
            } else console.log("Error");
        });
    });
});
