<?php

include '../../utils/db.php';
include '../../utils/user.php';
include '../../utils/validation.php';
include '../../filestorage.php';

if(!isLoggedIn()){
    header("location: /components/login/login.php");
    die();
}

$info = getUserInfo();

$profile_picture_msg = '';
$email_msg = '';
$username_msg = '';
$street_msg = '';
$street_number_msg = '';
$postcode_msg = '';
$city_msg = '';
$name_msg = '';
$forename = '';



// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
// Wenn der Nutzer auf editprofile.php sein Profil aktualisiert, sollen die Änderungen hier verarbeitet werden.
if($_SERVER["REQUEST_METHOD"] === 'POST'){

    $newprofilepicturepath = '';
    // if picture uploaded
    if(isset($_FILES['profilepicture'])){
        $result = storeProfilePicture();
        if($result[0]){
            $newprofilepicturepath = $result[1];
        }else{
            $profile_picture_msg = $result[1];
        }
    }

    echo $newprofilepicturepath;

    // E-Mail überprüfen
    $email_final = '';
    $email_validated = false;
    if(trim($_POST['email']) != $info['email']){
        $email_validated = validateEmail(trim($_POST['email']));
    }else{
        $email_validated = true;
        $email_final = $info['email']; //Wenn die E-Mail nicht geändert wurde, kann/muss sie nicht neu validiert werden
    }
    
    // Nutzernamen überprüfen
    $username_final = '';
    $username_validated = false;
    if(trim($_POST['username']) != $info['username']){
        $username_validated = validateUsername(trim($_POST['username']));
    }else{
        $username_validated = true;
        $username_final = $info['username']; //Wenn der Nutzername nicht geändert wurde, kann/muss sie nicht neu validiert werden
    }
    
    // Straße überprüfen
    $street_final = '';
    $street_msg = validateInputLength(trim($_POST['street']), 50);
    if($street_msg == '') $street_final = trim($_POST['street']);
    
    // Hausnummer überprüfen
    $street_number_final = '';
    $street_number_msg = validateInputLength(trim($_POST['street_number']), 10);
    if($street_number_msg == '') $street_number_final = trim($_POST['street_number']);
    
    // Postleitzahl überprüfen
    $postcode_final = '';
    $postcode_validated = validatePostcode(trim($_POST['postcode']));
    
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

    if($profile_picture_msg == '' && $email_validated && $username_validated && $postcode_validated && $street_msg == '' && $street_number_msg == '' && $city_msg == '' && $name_msg == '' && $forename_msg == ''){
        $result = updateInfo($username_final, $email_final, $street_final, $street_number_final, $postcode_final, $city_final, $newprofilepicturepath, $name_final, $forename_final);
        if($result){
            header("location: /components/profile/profile.php");
            die();
        }
    }
}



?>
<!DOCTYPE html>
<html>
<title>Profil Bearbeiten</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/editprofile/editprofile.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>

<form method="post" enctype="multipart/form-data">
<div id="editprofileFormOuter">
<h1 id="editprofileHeading">PROFIL BEARBEITEN</h1>
<div id="editprofileFormInner">
    <img src="<?php echo getProfilePicturePath(); ?>" alt="Bild nicht geladen" width="200" height="200">
    <br>
    <input type="file" id="profilepicture" name="profilepicture">
    <br>
    <?php if (!empty($profile_picture_msg)) echo "<span class=\"errormessage\">$profile_picture_msg</span><br>"; //E-Mail-Fehler ?>
    <br>
    E-Mail
    <br>
    <script src="/main.js"></script>

    <input type="email" id="email" name="email" placeholder="Meine E-Mail" value="<?php echo $info['email'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
    <br>
    <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\">$email_msg</span><br>"; //E-Mail-Fehler ?>
    <br>
    Vorname
    <br>
    <input type="text" id="forename" name="forename" placeholder="Max" value="<?php echo $info['forename'] ?>" onkeydown="limitKeypress(event, this.value, 100)" class="inputfield">
    <br>
    <?php if (!empty($forename_msg)) echo "<span class=\"errormessage\">$forename_msg</span><br>"; //Vorname-Fehler ?>
    <br>
    Nachname
    <br>
    <input type="text" id="name" name="name" placeholder="Mustermann" value="<?php echo $info['name'] ?>" onkeydown="limitKeypress(event, this.value, 100)" class="inputfield">
    <br>
    <?php if (!empty($name_msg)) echo "<span class=\"errormessage\">$name_msg</span><br>"; //Nachname-Fehler ?>
    <br>
    Nutzername
    <br>
    <input type="text" id="username" name="username" placeholder="mein nutzername" value="<?php echo $info['username'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
    <br>
    <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\">$username_msg</span><br>"; //Nutzername-Fehler ?>
    <br>
    Straße
    <br>
    <input type="text" id="street" name="street" placeholder="meine Street" value="<?php echo $info['street'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
    <br>
    <?php if (!empty($street_msg)) echo "<span class=\"errormessage\">$street_msg</span><br>"; //Straße-Fehler ?>
    <br>
    Hausnummer
    <br>
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" value="<?php echo $info['street_number'] ?>" onkeydown="limitKeypress(event, this.value, 10)" class="inputfield">
    <br>
    <?php if (!empty($street_number_msg)) echo "<span class=\"errormessage\">$street_number_msg</span><br>"; //Hausnummer-Fehler ?>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postcode" name="postcode" placeholder="44444" value="<?php echo $info['postcode'] ?>" onkeydown="limitKeypress(event, this.value, 5)" class="inputfield">
    <br>
    <?php if (isset($postcode_validated) && !$postcode_validated) echo "<span class=\"errormessage\">$postcode_msg</span><br>"; //Postleitzahl-Fehler ?>
    <br>
    Stadt
    <br>
    <input type="text" id="city" name="city" placeholder="meine Stadt" value="<?php echo $info['city'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
    <br>
    <?php if (!empty($city_msg)) echo "<span class=\"errormessage\">$city_msg</span><br>"; //Stadt-Fehler ?>
    <br>
    Account erstellt am:
    <br>
    <input type="text" id="create_datetime" name="create_datetime" placeholder="account erstellt am: 01.01.2000" value="<?php echo $info['create_datetime'] ?>" readonly class="inputfield">
    <br>
    <br>
    <input type="submit" value="Speichern" formaction="/components/editprofile/editprofile.php" class="button">
    </form>
<br>
<form>
<button type="submit" formaction="/components/changepassword/changepassword.php" class="button">Passwort &auml;ndern</button>
</form>
</div>
</div>


</body>
</html>
