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
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" value="<?php echo $info['email'] ?>"/>
    <input type="text" id="forename" name="forename" placeholder="Max" value="<?php echo $info['forename'] ?>">
    <input type="text" id="name" name="name" placeholder="Mustermann" value="<?php echo $info['name'] ?>">
    <input type="text" id="username" name="username" placeholder="mein nutzername" value="<?php echo $info['username'] ?>">
    <input type="text" id="street" name="street" placeholder="meine Street" value="<?php echo $info['street'] ?>">
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" value="<?php echo $info['street_number'] ?>">
    <input type="text" id="postcode" name="postcode" placeholder="44444" value="<?php echo $info['postcode'] ?>">
    <input type="text" id="city" name="city" placeholder="meine Stadt" value="<?php echo $info['city'] ?>">
    <input type="text" id="create_datetime" name="create_datetime" placeholder="account erstellt am: 01.01.2000" value="<?php echo $info['create_datetime'] ?>">

    <input type="submit" value="Speichern" formaction="editprofile.php">
    </form>
<br>
<form>
<button type="submit" formaction="changepassword.php">Passwort &auml;ndern</button>
</form>

</body>
</html>
