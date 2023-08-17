<?php

include 'utils/db.php';
include 'utils/user.php';
include 'utils/validation.php';

$email_msg = '';
$username_msg = '';

if(!isLoggedIn()){
    header("location: login.php");
    die();
}

$info = getUserInfo();


// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
// Wenn der Nutzer auf editprofile.php sein Profil aktualisiert, sollen die Änderungen hier verarbeitet werden.
if($_SERVER["REQUEST_METHOD"] === 'POST'){


}

?>

<!DOCTYPE html>
<html>
<title>Profil</title>
<body>
<form>
    <button type="submit" formaction="logout.php">Logout</button>
</form>
    <?php if(isLoggedIn()) echo "<h1>Hallo " .  $info['username'] . ", du bist eingeloggt und hast die UserId " . getUserId() . "</h1>"; ?>
    <img src="src/img/profile_picturetest.png" alt="Bild nicht geladen" width="200" height="200">
    <br>
    <br>
    E-Mail
    <br>
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" readonly="readonly" value="<?php echo $info['email'] ?>"/>
    <br>
    <br>
    Vorname
    <br>
    <input type="text" id="forename" name="forename" placeholder="Max" readonly="readonly" value="<?php echo $info['forename'] ?>">
    <br>
    <br>
    Nachname
    <br>
    <input type="text" id="name" name="name" placeholder="Mustermann" readonly="readonly" value="<?php echo $info['name'] ?>">
    <br>
    <br>
    Nutzername
    <br>
    <input type="text" id="username" name="username" placeholder="mein username" readonly="readonly" value="<?php echo $info['username'] ?>">
    <br>
    <br>
    Straße
    <br>
    <input type="text" id="street" name="street" placeholder="meine street" readonly="readonly" value="<?php echo $info['street'] ?>">
    <br>
    <br>
    Hausnummer
    <br>
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" readonly="readonly" value="<?php echo $info['street_number'] ?>">
    <br>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postcode" name="postcode" placeholder="44444" readonly="readonly" value="<?php echo $info['postcode'] ?>">
    <br>
    <br>
    Stadt
    <br>
    <input type="text" id="city" name="city" placeholder="meine city" readonly="readonly" value="<?php echo $info['city'] ?>">
    <br>
    <br>
    Account erstellt am:
    <br>
    <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="01.01.2000" readonly="readonly" value="<?php echo $info['create_datetime'] ?>" readonly>
    <br>
    <br>
    <form>
        <button type="submit" formaction="editprofile.php">Bearbeiten</button>
    </form>

</body>
</html>
