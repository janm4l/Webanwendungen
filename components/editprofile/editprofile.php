<?php

include '../../utils/db.php';
include '../../utils/user.php';
include '../../utils/validation.php';
include '../../utils/filestorage.php';

if(!isLoggedIn()){
    header("location: /components/login/login.php");
    die();
}

$info = getUserInfo();

$email_msg = '';
$username_msg = '';
$password_msg = '';
$confirm_password_msg = '';


// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
// Wenn der Nutzer auf editprofile.php sein Profil aktualisiert, sollen die Änderungen hier verarbeitet werden.
if($_SERVER["REQUEST_METHOD"] === 'POST'){

    $newprofilepicturepath = '';
    // if picture uploaded
    if(isset($_FILES["profilepicture"])){
        $result = storgeProfilePicture();
        if($result[0]){
            $newprofilepicturepath = $result[1];
        }
    }

    // E-Mail überprüfen
    $email_final = '';
    $email_validated = false;
    if($email_final != $info['email']){
        $email_validated = validateEmail(trim($_POST['email']));
    }else{
        $email_validated = true;
    }
    
    // Nutzernamen überprüfen
    $username_final = '';
    $username_validated = false;
    if($username_final != $info['username']){
        $username_validated = validateUsername(trim($_POST['username']));
    }else{
        $username_validated = true;
    }
    
    // Straße überprüfen
    $street_final = '';
    $street_msg = validateInputLength(trim($_POST['street_number']), 50);
    if($street_msg == '') $street_final = trim($_POST['street_number']);
    
    // Hausnummer überprüfen
    $street_number_final = '';
    $street_number_msg = validateInputLength(trim($_POST['street_number']), 10);
    if($street_number_msg == '') $street_number_final = trim($_POST['street_number']);
    
    // Postleitzahl überprüfen
    $postcode_final = '';
    $postcode_valideted = validatePostcode(trim($_POST['postcode']));
    
    // Stadt überprüfen
    $city_final = '';
    $city_msg = validateInputLength(trim($_POST['city']), 50);
    if($city_msg == '') $city_final = trim($_POST['city']);
        
    // Name überprüfen
    $name_final = '';
    $name_msg = validateInputLength(trim($_POST['name']), 100);
    if($name_msg == '') $name_final = trim($_POST['name']);
    
    // Vorname überprüfen
    $forename_final = '';
    $forename_msg = validateInputLength(trim($_POST['forename']), 100);
    if($forename_msg == '') $forename_final = trim($_POST['forename']);
    

}



?>
<!DOCTYPE html>
<html>
<title>Profil Bearbeiten</title>
<head>
    <link rel="stylesheet" href="/components/editprofile/editprofile.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>


<form>
    <input type="file" id="profilepicture" name="profilepicture">
    <br>
    <br>
    E-Mail
    <br>
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" value="<?php echo $info['email'] ?>"/>
    <br>
    <br>
    Vorname
    <br>
    <input type="text" id="forename" name="forename" placeholder="Max" value="<?php echo $info['forename'] ?>">
    <br>
    <br>
    Nachname
    <br>
    <input type="text" id="name" name="name" placeholder="Mustermann" value="<?php echo $info['name'] ?>">
    <br>
    <br>
    Nutzername
    <br>
    <input type="text" id="username" name="username" placeholder="mein nutzername" value="<?php echo $info['username'] ?>">
    <br>
    <br>
    Straße
    <br>
    <input type="text" id="street" name="street" placeholder="meine Street" value="<?php echo $info['street'] ?>">
    <br>
    <br>
    Hausnummer
    <br>
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" value="<?php echo $info['street_number'] ?>">
    <br>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postcode" name="postcode" placeholder="44444" value="<?php echo $info['postcode'] ?>">
    <br>
    <br>
    Stadt
    <br>
    <input type="text" id="city" name="city" placeholder="meine Stadt" value="<?php echo $info['city'] ?>">
    <br>
    <br>
    Account erstelle am:
    <br>
    <input type="text" id="create_datetime" name="create_datetime" placeholder="account erstellt am: 01.01.2000" value="<?php echo $info['create_datetime'] ?>" readonly>
    <br>
    <br>
    <input type="submit" value="Speichern" formaction="/components/editprofile/editprofile.php" class="button">
    </form>
<br>
<form>
<button type="submit" formaction="/components/changepassword/changepassword.php" class="button">Passwort &auml;ndern</button>
</form>

</body>
</html>
