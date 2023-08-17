<?php

include 'utils/db.php';
include 'utils/user.php';

if(!isLoggedIn()){
    header("location: login.php");
    die();
}

$info = getUserInfo();

?>
<!DOCTYPE html>
<html>
<title>Profil Bearbeiten</title>
<body>


<form>
    <input type="file" id="profilbild" name="profilbild">
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
    <input type="submit" value="Speichern" formaction="editprofile.php">
    </form>
<br>
<form>
<button type="submit" formaction="changepassword.php">Passwort &auml;ndern</button>
</form>

</body>
</html>
