<?php

include '../../utils/db.php';
include '../../utils/user.php';
include '../../utils/validation.php';

$email_msg = '';
$username_msg = '';
$password_msg = '';
$confirm_password_msg = '';

if(isLoggedIn()){
    header("location: /components/profile/profile.php");
    die();
}

// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    // E-Mail überprüfen
    $email_final = '';
    $email_validated = validateEmail(trim($_POST['email']));

    // Nutzernamen überprüfen
    $username_final = '';
    $username_validated = validateUsername(trim($_POST['username']));

    // Validate password
    $password_final = '';
    $password_validated = validatePassword(trim($_POST['password']));
    
    // Validate confirm password
    $confirm_password_validated = validateConfirmPassword(trim($_POST['confirm_password']));
    
    // Check input errors before inserting in database
    if($email_validated && $username_validated && $password_validated && $confirm_password_validated){
        $registered = registerAndLoginUser($email_final, $username_final, $password_final);
        if($registered){
            // Redirect to login page
            header("location: /components/profile/profile.php");
        }
    }
    
    // Close connection
    mysqli_close($conn);
}



?>

<!DOCTYPE html>
<html>
<title>Registrieren</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/register/register.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>

 <script src="/main.js"></script>
    <div id="registerFormOuter">
        <h1 id="registerHeading">REGISTRIEREN</h1>
        <div id="registerFormInner">
            <form method="post" onsubmit="return register_submit_check('Bitte f&uuml;lle das Formular richtig aus')">
                Email *
                <br>
                <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required="required" class="inputfield" onkeydown="limitKeypress(event, this.value, 50);" onblur="email_check(event, '^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$', 'email', 'Bitte gib eine valide E-mail ein')">
                <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\">$email_msg</span><br>"; //E-Mail-Fehler ?>
                <span id="error_email"></span>
                <br>
                Nutzername *
                <br>
                <input type="text" id="username" name="username" placeholder="Nutzername" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required="required" onkeydown="limitKeypress(event, this.value, 50)" onblur="username_check(event, '^([0-9]|[a-z]|\_|[A-Z]){1,50}$', 'username', 'Bitte gib einen validen Nutzernamen ein');" class="inputfield">
                <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\">$username_msg</span><br>"; //Username-Fehler ?>
                <span id="error_username"></span>
                <br>
                Passwort *
                <br>
                <input type="password" id="password" name="password" placeholder="Passwort" required="required" onblur="password_check(event, 'password', 'Das Passwort entspricht nicht den Anforderungen')" class="inputfield">
                <?php if (isset($password_validated) && !$password_validated) echo "<span class=\"errormessage\"\>$password_msg</span><br>"; //Password-Fehler ?>
                <span id="error_password"></span>
                <br>
                Passwort Best&auml;tigen *
                <br>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Passwort Best&auml;tigen" required="required" class="inputfield" onblur="comparepasswords(this.value, 'Die Passw&ouml;rter stimmen nicht &uuml;berein'); check_password_check(event, 'confirm_password', 'Das Passwort entspricht nicht den Anforderungen')">
                <?php if (isset($confirm_password_validated) && !$confirm_password_validated) echo "<span class=\"errormessage\">$confirm_password_msg</span><br>"; //Confirm-Password-Fehler ?>
                <span id="password_compare_error"></span>
                <br>
                <span id="error_confirm_password"></span>
                <br>
                <span id="register_form_error"></span>
                <br>
                <input type="submit" formaction="/components/register/register.php" value="Registrieren" class="button">
                <br>
            </form>

        </div>
    </div>
</body>
</html>