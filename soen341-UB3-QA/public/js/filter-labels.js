$(document).ready(function () {
    var labels = document.getElementsByClassName("filter_labels");

    Array.from(labels).forEach(function (element) {
        element.addEventListener('click', listLabeledQuestions, false);
    });

    function listLabeledQuestions() {

        //if color is 0 question wont be filtered. clicked on highlighted label already.
        if (this.style.background === "powderblue")
            var color = 0;
        else
            var color = 1;

        //get which label was clicked on
        var specificLabel = this.text;

        //send call to controller to get data of specific label and change view
        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                context: this,
                url: '/home/' + specificLabel,
                data: {'color': color},
                success:
                    function (data) {
                        if (data.success == true) {
                            $('#welcome_body').html(data.html);
                        }
                    }
            }
        );
    }
});