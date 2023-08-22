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

    $newprofilepicturepath = $info['profile_picture'];
    // Wurde ein Bild hochgeladen?
    if(isset($_FILES['profilepicture']) && $_FILES['profilepicture']['size'] != 0){
        $result = storeProfilePicture();
        if($result[0]){
            $newprofilepicturepath = $result[1];
        }else{
            $profile_picture_msg = $result[1];
        }
    }

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

    // Nochmal checken, ob alles überprüft wurde und korrekt ist
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
<head>
    <title>Profil Bearbeiten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/editprofile/editprofile.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
    <div id="editprofileFormOuter">
        <h1 id="editprofileHeading">PROFIL BEARBEITEN</h1>
        <div id="editprofileFormInner">
            <form method="post" enctype="multipart/form-data" id="editprofile_form" onsubmit="return profile_submit_check('Bitte f&uuml;lle das Formular richtig aus')">
                <img src="<?php echo getProfilePicturePath(); ?>" alt="Bild nicht geladen" width="200" height="200" style="border-radius: 100px">
                <?php if (!empty($info['profile_picture'])) echo "<br><a href=\"#\" id=\"deletePictureButton\" class=\"button\" style=\"text-decoration: none; text-align: center\">Profilbild l&ouml;schen</a>" ?>
                <br>
                <input type="file" id="profilepicture" name="profilepicture">
                <br>
                <?php if (!empty($profile_picture_msg)) echo "<span class=\"errormessage\">$profile_picture_msg</span><br>"; //E-Mail-Fehler ?>
                E-Mail
                <br>
                <script src="/main.js"></script>
                <input type="email" id="email" name="email" placeholder="Meine E-Mail" value="<?php echo $info['email'] ?>" onkeydown="limitKeypress(event, this.value, 50);" onblur="email_check(event, '^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$', 'email', 'Bitte gib eine valide E-mail ein');" class="inputfield">
                <span id="error_email"></span>
                <br>
                <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\">$email_msg</span><br>"; //E-Mail-Fehler ?>
                Vorname
                <br>
                <input type="text" id="forename" name="forename" placeholder="Max" value="<?php echo $info['forename'] ?>" onkeydown="limitKeypress(event, this.value, 100)" class="inputfield">
                <br>
                <?php if (!empty($forename_msg)) echo "<span class=\"errormessage\">$forename_msg</span><br>"; //Vorname-Fehler ?>
                Nachname
                <br>
                <input type="text" id="name" name="name" placeholder="Mustermann" value="<?php echo $info['name'] ?>" onkeydown="limitKeypress(event, this.value, 100)" class="inputfield">
                <br>
                <?php if (!empty($name_msg)) echo "<span class=\"errormessage\">$name_msg</span><br>"; //Nachname-Fehler ?>
                Nutzername
                <br>
                <input type="text" id="username" name="username" placeholder="mein nutzername" value="<?php echo $info['username'] ?>" onkeydown="limitKeypress(event, this.value, 50)" onblur="email_check(event, '^([0-9]|[a-z]|\_|[A-Z]){1,50}$', 'username', 'Bitte gib einen validen Nutzernamen ein');" class="inputfield">
                <span id="error_username"></span>
                <br>
                <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\">$username_msg</span><br>"; //Nutzername-Fehler ?>
                Straße
                <br>
                <input type="text" id="street" name="street" placeholder="meine Street" value="<?php echo $info['street'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
                <br>
                <?php if (!empty($street_msg)) echo "<span class=\"errormessage\">$street_msg</span><br>"; //Straße-Fehler ?>
                Hausnummer
                <br>
                <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" value="<?php echo $info['street_number'] ?>" onkeydown="limitKeypress(event, this.value, 10)" onblur="street_number_check(event, '^[0-9]+[a-h]?\-?[b-i]?$', 'street_number', 'Bitte gib eine valide Hausnummer ein');" class="inputfield">
                <span id="error_street_number"></span>
                <br>
                <?php if (!empty($street_number_msg)) echo "<span class=\"errormessage\">$street_number_msg</span><br>"; //Hausnummer-Fehler ?>
                Postleitzahl
                <br>
                <input type="text" id="postcode" name="postcode" placeholder="44444" value="<?php echo $info['postcode'] ?>" onkeydown="limitKeypress(event, this.value, 5)" onblur="postcode_check(event, '^[0-9]{4,5}$', 'postcode', 'Bitte gib eine valide Postleitzahl ein');" class="inputfield">
                <span id="error_postcode"></span>
                <br>
                <?php if (isset($postcode_validated) && !$postcode_validated) echo "<span class=\"errormessage\">$postcode_msg</span><br>"; //Postleitzahl-Fehler ?>
                Stadt
                <br>
                <input type="text" id="city" name="city" placeholder="meine Stadt" value="<?php echo $info['city'] ?>" onkeydown="limitKeypress(event, this.value, 50)" class="inputfield">
                <br>
                <?php if (!empty($city_msg)) echo "<span class=\"errormessage\">$city_msg</span><br>"; //Stadt-Fehler ?>
                Account erstellt am:
                <br>
                <input type="text" id="create_datetime" name="create_datetime" placeholder="account erstellt am: 01.01.2000" value="<?php echo $info['create_datetime'] ?>" readonly class="inputfield">
                <br>
                <span id="editprofile_form_error"></span>
                <input type="submit" value="Speichern" formaction="/components/editprofile/editprofile.php" class="button">
            </form>
            <br>
            <form>
                <button type="submit" formaction="/components/profile/profile.php" class="button">Abbrechen</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var deletePictureButton = document.getElementById("deletePictureButton");
            deletePictureButton.addEventListener("click", function () {

                var data = {
                    delete: true
                };

                fetch("/ajax/deleteprofilepicture.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if(result['success']){
                        location.reload();
                    }else{
                        alert("Dein Profilbild konnte nicht gel&ouml;scht werden.");
                    }
                })
                .catch(error => {
                    console.log("Fehler bei der Anfrage:", error + error.stack);
                    console.log(response);
                    alert("Es ist ein Fehler beim Senden der Daten aufgetreten.");
                });
            });
        });
    </script>
</body>
</html>
