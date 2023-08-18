function limitKeypress(event, value, maxLength) {
    if (value != undefined && value.toString().length >= maxLength) {
            if (event.keyCode != 8 && event.keyCode != 46) {
                    event.preventDefault();
            }
    }
}
//limits the Character input for a given input field