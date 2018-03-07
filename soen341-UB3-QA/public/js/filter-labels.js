$(document).ready(function () {
    var labels = document.getElementsByClassName("filter_labels");

    Array.from(labels).forEach(function(element) {
        element.addEventListener('click', listLabeledQuestions, false);
    });

    function listLabeledQuestions(){

       //get which label was clicked on
       var specificLabel = this.text;

        //send call to controller to get data and change view
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/home/' + specificLabel,
            success: function(data) {
                if(data.success == true) {
                    $('#welcome_body').html(data.html);
                }
            },
        });
    }

});