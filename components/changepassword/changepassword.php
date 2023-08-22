<?php

include '../../utils/db.php';
include '../../utils/user.php';
include '../../utils/validation.php';

if(!isLoggedIn()){
    header("location: /components/login/login.php");
    die();
}

$info = getUserinfo();

$result = false;

// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
if($_SERVER["REQUEST_METHOD"] === 'POST'){

    //Altes Passwort
    $old_password_final = '';
    $old_password_validated = (password_verify(trim($_POST['old_password']), $info['password_hashed']) ? true : false);
    $old_password_msg = ($old_password_validated ? '' : 'Dieses Passwort stimmt nicht mit deinem akutellen Password überein.');

    // Validate password
    $password_final = '';
    $password_validated = validatePassword(trim($_POST['password']));
    
    // Validate confirm password
    $confirm_password_validated = validateConfirmPassword(trim($_POST['confirm_password']));
    
    // Check input errors before inserting in database
    if($old_password_validated && $password_validated && $confirm_password_validated){
        $result = updateUserPassword($password_final);
    }
    
    // Close connection
    mysqli_close($conn);
}



?>

<!DOCTYPE html>
<html>
<title>Login</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/changepassword/changepassword.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
 <script src="/main.js"></script>

<div id="changepasswordFormOuter">
<h1 id="changepasswordHeading">PASSWORT ÄNDERN</h1>
<div id="changepasswordFormInner">
<form method="post">
<span id="change_passwords_form_error"></span>
    Altes Passwort
    <br>
    <input type="password" id="old_password" name="old_password" placeholder="Altes Passwort" value="<?php if (!empty($oldpassword)) echo $oldpassword ?>" class="inputfield">
    <span id="old_password_msg" class="errormessage"></span>
    <br>
    <br>
    Neues Passwort
    <br>
    <input type="password" id="password" name="password" placeholder="Neues Passwort" onblur="password_check(event, 'password', 'Das Passwort entspricht nicht den Anforderungen')" class="inputfield">
    <span id="password_msg" class="errormessage"></span>
    <span id="error_password"></span>
    <br>
    <br>
    Neues Passwort best&auml;tigen
    <br>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Neues Passwort bestätigen" onblur="comparepasswords(this.value, 'Die Passwörter stimmen nicht überein'); check_password_check(event, 'confirm_password', 'Das Passwort entspricht nicht den Anforderungen')" class="inputfield">
    <span id="confirm_password_msg" class="errormessage"></span>
    <span id="error_confirm_password"></span>
    <span id="password_compare_error"></span>
     <h4 id="success" class="successmessage" style="visibility: hidden"></h4>
    <br>
    <br>
    <input id="submitButton" type="button" formaction="/components/changepassword/changepassword.php" value="Passwort &auml;ndern" class="button">
    <a href="/components/profile/profile.php" class="button" style="text-decoration: none; text-align: center">Profil</a>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var submitBtn = document.getElementById("submitButton");
            const successElement = document.getElementById("success");
            submitBtn.addEventListener("click", function () {
                var field_old_password = document.getElementById("old_password");
                var field_password = document.getElementById("password");
                var field_confirm_password = document.getElementById("confirm_password");
                var old_password = field_old_password.value;
                var password = field_password.value;
                var confirm_password = field_confirm_password.value;

                if (!change_password_submit_check('Bitte fülle das Formular richtig aus')){
                    return;
                }

                if (old_password == '' || password == '' || confirm_password == '') {
                    alert("Bitte fülle alle Felder aus.");
                    return;
                }

                if(password != confirm_password){
                    alert("Die neuen Passwörter stimmen nicht überein.");
                    return;
                }

                var data = {
                    old_password: old_password,
                    password: password,
                    confirm_password: confirm_password
                };

                fetch("/ajax/changepassword.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    document.getElementById("old_password_msg").innerHTML = result['old_password_msg'];
                    document.getElementById("password_msg").innerHTML = result['password_msg'];
                    document.getElementById("confirm_password_msg").innerHTML = result['confirm_password_msg'];
                    if(result['success']){
                        successElement.innerHTML = "Dein Passwort wurde erfolgreich ge&auml;ndert.";
                        successElement.style.visibility = "visible";
                        field_old_password.value = "";
                        field_password.value = "";
                        field_confirm_password.value = "";
                    }
                })
                .catch(error => {
                    console.log("Fehler bei der Anfrage:", error + error.stack);
                    alert("Es ist ein Fehler beim Senden der Daten aufgetreten.");
                });
            });
        });
    </script>
</form>
<br>

</div>
</div>
</body>
</html>