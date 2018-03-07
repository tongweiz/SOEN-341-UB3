$(document).ready(function () {
    $(".order").click(function () {
        let id = $(this).attr("id");
        let direction = $('#dir').attr("class");
        console.log(id + "..." + direction);
        $.get("/home/" + id + "/" + direction, function (data, status) {
            if (status == "success") {
                if (data == "#") {
                    alert(".");
                }
                else {
                    let questions = JSON.parse(data);
                    innerHTML = "";

                    for(let i = 0; i < questions.length; i++){
                        innerHTML += '<div class="card mb-4">' +
                        '<div class="card-body">' +

                            '<h4 class="card-title">' + questions[i].title + '</h4> </br>' +

                            '<p class="card-text" style="margin-top: -20px; margin-bottom: 20px">' +
                                questions[i].content.split(".", 1) + '...</p>' +

                            '<span id="labels-styled">LABEL 1</span> <span id="labels-styled">LABEL 2</span>' +

                            '<a href="/question/' + questions[i].id + '" class="btn btn-primary" name="Read" style="float: right;">Read More &rarr;</a>' +
                        '</div>' +

                        '<div class="card-footer text-muted">' +
                            'Posted on the <span style="text-decoration: underline;">' +
                            questions[i].created_at + '</span> by <span style="text-decoration: underline;">' + questions[i].name + '</span>' +

                            '<span style="float: right"> ' + questions[i].nb_replies + ' replies</span>' +
                        '</div>' +

                    '</div>';
                    }

                    document.getElementById("questions").innerHTML = innerHTML;
                    $('#ordo').text(id);
                    $('#ord').attr("class", id);
                }
            } else console.log("Error");
        });
    });

    $(".orderD").click(function () {
        let id = $(this).attr("id");
        let order = $('#ord').attr("class");

        $.get("/home/" + order + "/" + id, function (data, status) {
            if (status == "success") {
                if (data == "#") {
                    alert(".");
                }
                else {
                    let questions = JSON.parse(data);
                    innerHTML = "";

                    for(let i = 0; i < questions.length; i++){
                        innerHTML += '<div class="card mb-4">' +
                        '<div class="card-body">' +

                            '<h4 class="card-title">' + questions[i].title + '</h4> </br>' +

                            '<p class="card-text" style="margin-top: -20px; margin-bottom: 20px">' +
                                questions[i].content.split(".", 1) + '...</p>' +

                            '<span id="labels-styled">LABEL 1</span> <span id="labels-styled">LABEL 2</span>' +

                            '<a href="/question/' + questions[i].id + '" class="btn btn-primary" name="Read" style="float: right;">Read More &rarr;</a>' +
                        '</div>' +

                        '<div class="card-footer text-muted">' +
                            'Posted on the <span style="text-decoration: underline;">' +
                            questions[i].created_at + '</span> by <span style="text-decoration: underline;">' + questions[i].name + '</span>' +

                            '<span style="float: right"> #' + questions[i].nb_replies + ' replie(s)</span>' +
                        '</div>' +

                    '</div>';
                    }

                    document.getElementById("questions").innerHTML = innerHTML;
                    $('#diro').text((id == 'asc')?'Ascending':'Descending');
                    $('#dir').attr("class", id);
                }
            } else console.log("Error");
        });
    });
});
