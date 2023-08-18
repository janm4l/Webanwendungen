
//limits the Character input for a given input field

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