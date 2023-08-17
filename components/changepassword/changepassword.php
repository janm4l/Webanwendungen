<?php

include '../../utils/db.php';
include '../../utils/user.php';
include '../../utils/validation.php';

$old_password_msg = '';
$password_msg = '';
$confirm_password_msg = '';

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
    <link rel="stylesheet" href="/components/changepassword/changepassword.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>

<div id="changepasswordFormOuter">
<h1 id="changepasswordHeading">Passwort &auml;ndern</h1>
<div id="changepasswordFormInner">
<form method="post">
    <?php if (isset($result) && $result) echo "<h1 class=\"successmessage\">Dein Passwort wurde erfolgreich geändert.</h1><br>"; ?>
    Altes Passwort
    <br>
    <input type="password" id="old_password" name="old_password" placeholder="Altes Passwort" value="<?php if (!empty($oldpassword)) echo $oldpassword ?>" class="inputfield">
    <br>
    <?php if (isset($old_password_validated) && !$old_password_validated) echo "<span class=\"errormessage\">$old_password_msg</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    Neues Passwort
    <br>
    <input type="password" id="password" name="password" placeholder="Neues Passwort" class="inputfield">
    <br>
    <?php if (isset($password_validated) && !$password_validated) echo "<span class=\"errormessage\">$password_msg</span><br>"; //Passwort-Fehler ?>
    <br>
    <br>
    Neues Passwort best&auml;tigen
    <br>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Neues Passwort bestätigen" class="inputfield">
    <br>
    <?php if (isset($confirm_password_validated) && !$confirm_password_validated) echo "<span class=\"errormessage\">$confirm_password_msg</span><br>"; //Passwort-Fehler ?>
    <br>
    <br>
    <input type="submit" formaction="/components/changepassword/changepassword.php" value="Passwort &auml;ndern"> <a href="/components/profile/profile.php" class="button">Profil</a>
</form>
<br>

</div>
</div>
</body>
</html>