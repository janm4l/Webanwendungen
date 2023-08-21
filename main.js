
//limits the Character input for a given input field
let email_valid = true;
let street_number_valid = true
let postcode_valid = true;
let username_valid = true;
function set_email_valid(bool){
    email_valid = bool;
}

function set_street_number_valid(bool){
    street_number_valid = bool;
}

function set_postcode_valid(bool){
   postcode_valid = bool;
}

function set_username_valid(bool){
    username_valid = bool;
}
function limitKeypress(event, value, maxLength) {
    if (value != undefined && value.toString().length >= maxLength) {
            if (event.keyCode != 8 && event.keyCode != 46) {
                    event.preventDefault();
            }
    }
}


function check_syntax(event, value, regEx) {
    if (value != undefined && value.toString().match(regEx) != null) {
       console.log("true");
        return true;
    }
    else {
        console.log("false");
        return false;
    }
}

function errorRegEx(event, value, regEx, id, message) {
    let error_id = "error_" + id;
    let error = document.getElementById(error_id);
    if (!check_syntax(event, document.getElementById(id).value, regEx))
    {

        // Changing content and color of content
        error.textContent = message;
        error.style.color = "red";
        return false;
    }
    else {
        error.textContent = "";
        return true;
    }
}


function submit_check(message){
    let error = document.getElementById("editprofile_form_error");
    if(email_valid === true && street_number_valid === true && postcode_valid === true && username_valid === true){
        error.textContent = "";
        return true;
    }
    else {
        error.textContent = message;
        error.style.color = "red";
        return false;
    }
}

function email_check(event, value, regEx, id, message){
    if(errorRegEx(event, value, regEx, id, message)){
        errorRegEx(event, value, regEx, id, message);
        set_email_valid(true);
    }
    else {
        errorRegEx(event, value, regEx, id, message);
        set_email_valid(false);
    }
}

function street_number_check(event, value, regEx, id, message){
    if(errorRegEx(event, value, regEx, id, message)){
        errorRegEx(event, value, regEx, id, message);
        set_street_number_valid(true);
    }
    else {
        errorRegEx(event, value, regEx, id, message);
        set_street_number_valid(false);
    }
}


function postcode_check(event, value, regEx, id, message){
    if(errorRegEx(event, value, regEx, id, message)){
        errorRegEx(event, value, regEx, id, message);
        set_postcode_valid(true);
    }
    else {
        errorRegEx(event, value, regEx, id, message);
        set_postcode_valid(false);
    }
}

function username_check(event, value, regEx, id, message){
    if(errorRegEx(event, value, regEx, id, message)){
        errorRegEx(event, value, regEx, id, message);
        set_username_valid(true);
    }
    else {
        errorRegEx(event, value, regEx, id, message);
        set_username_valid(false);
    }
}