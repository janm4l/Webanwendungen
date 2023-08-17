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
    <link rel="stylesheet" href="/components/register/register.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
<div id="registerFormOuter">
<h1 id="registerHeading">Register</h1>
<div id="registerFormInner">
<form method="post">
    Email *
    <br>
    <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required="required" class="inputfield">
    <br>
    <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\">$email_msg</span><br>"; //E-Mail-Fehler ?>
    <br>
    Nutzername *
    <br>
    <input type="text" id="username" name="username" placeholder="Nutzername" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required="required" class="inputfield">
    <br>
    <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\">$username_msg</span><br>"; //Username-Fehler ?>
    <br>
    Passwort *
    <br>
    <div data-tip="This is the text of the tooltip2">
    <input type="password" id="password" name="password" placeholder="Passwort" required="required" class="inputfield">
    </div>
    <br>
    <?php if (isset($password_validated) && !$password_validated) echo "<span class=\"errormessage\"\>$password_msg</span><br>"; //Password-Fehler ?>
    Passwort Bestätigen *
    <br>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Passwort Bestätigen" required="required" class="inputfield">
    <br>
    <?php if (isset($confirm_password_validated) && !$confirm_password_validated) echo "<span class=\"errormessage\">$confirm_password_msg</span><br>"; //Confirm-Password-Fehler ?>
    <br>
    Vorname
    <br>
    <input type="text" id="vorname" name="vorname" placeholder="Vorname" class="inputfield">
    <br>
    <br>
    Nachname
    <br>
    <input type="text" id="nachname" name="nachname" placeholder="Nachname" class="inputfield">
    <br>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postleitzahl" name="postleitzahl" placeholder="Postleitzahl" class="inputfield">
    <br>
    <br>
    Ort
    <br>
    <input type="text" id="ort" name="ort" placeholder="Ort" class="inputfield">
    <br>
    <br>
    Straße
    <br>
    <input type="text" id="straße" name="straße" placeholder="Straße" class="inputfield">
    <br>
    <br>
    Hausnummer
    <br>
    <input type="text" id="hausnummer" name="hausnummer" placeholder="Hausnummer" class="inputfield">
    <br>
    <br>
    <input type="submit" formaction="/components/register/register.php" value="Registrieren" class="button">
</form>
</div>
</div>
</body>
</html>