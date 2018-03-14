$(document).ready(function () {

    //global values of user info when page is loaded!
    let original_name = document.getElementById("username-input").value;
    let original_email = document.getElementById("email-input").value;

    /**
     * Method to enable and disable buttons when the action is canceled or successfully done.
     */
    function enabledisable() {
        //put back original or updated values
        document.getElementById("username-input").value = original_name;
        document.getElementById("email-input").value = original_email;
        document.getElementById("password-input").value = "**ENCRYPYED**";

        //re-enable edit button and disable save and cancel button
        document.getElementById("edit-info").disabled = false;
        document.getElementById("save-info").disabled = true;
        document.getElementById("cancel-info").disabled = true;

        //disable inputs
        document.getElementById("username-input").disabled = true;
        document.getElementById("email-input").disabled = true;
        document.getElementById("password-input").disabled = true;

        //populate password field
        document.getElementById('password-input').value = "**ENCRYPTED**";
    }

    /**
     * This method will be called when the edit button is clicked
     */
    $(".edit-info-js").click(function () {
        //disable edit button and enable save and cancel buttons
        document.getElementById("edit-info").disabled = true;
        document.getElementById("save-info").disabled = false;
        document.getElementById("cancel-info").disabled = false;

        //enable inputs
        document.getElementById("username-input").disabled = false;
        document.getElementById("email-input").disabled = false;
        document.getElementById("password-input").disabled = false;

        //clear password field
        document.getElementById('password-input').value = "";

        //clear error message if any
        document.getElementById("error_msg").innerHTML = "";
        document.getElementById("error_msg").style.visibility = "hidden";
    });

    $(".save-info-js").click(function () {
        //If saved is clicked multiple times with different errors
        document.getElementById("error_msg").innerHTML = "";

        //validate if fields are empty
        let name = document.getElementById("username-input").value;
        let email = document.getElementById("email-input").value;
        let password = document.getElementById("password-input").value;
        let errors = "ERRORS:";

        if (name.trim().length === 0 || email.trim().length === 0)
            errors = errors + " Name and email fields are required. ";

        //validate if email has the right format
        if (!(/[a-zA-Z0-9]+@[a-zA-Z0-9]+.com|ca/.test(email.trim())))
            errors = errors + " Email addresses must have the following format: AAA@AAA.com ";

        //validate password has right format
        if (password.trim().length !== 0)
            if (password.trim().length < 6 || !(/\d/.test(password.trim())))
                errors = errors + " Passwords must be atleast 6 characters and contain a number.";

        //print error message
        if (errors.length > 7) {
            document.getElementById("error_msg").style.visibility = "visible";
            document.getElementById("error_msg").innerHTML = errors;
        }
        else {
            //save new user info
            let id = $(this).attr("name");

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/profile',
                data: { 'id' : id, 'name' : name, 'email' : email, 'password' : password}
            });

            //change global variables
            original_name = document.getElementById("username-input").value;
            original_email = document.getElementById("email-input").value;

            //disable and enable buttons
            enabledisable();

            //success message
            document.getElementById("error_msg").style.visibility = "visible";
            document.getElementById("error_msg").innerHTML = "Your new information have been successfully saved!"

            document.getElementById("auth_user_name").innerHTML = name;
        }
    });

    /**
     * This method will be called when cancel button is clickec
     */
    $(".cancel-info-js").click(function () {
        //enable and disable buttons
        enabledisable();

        //hide any message
        document.getElementById("error_msg").innerHTML = "";
        document.getElementById("error_msg").style.visibility = "hidden";
    });
});