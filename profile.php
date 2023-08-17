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
    <img src="src/img/profilbildtest.png" alt="Bild nicht geladen" width="200" height="200">
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" readonly="readonly" value="<?php echo $info['email'] ?>"/>
    <input type="text" id="vorname" name="vorname" placeholder="Max" readonly="readonly" value="<?php echo $info['forename'] ?>">
    <input type="text" id="nachname" name="nachname" placeholder="Mustermann" readonly="readonly" value="<?php echo $info['name'] ?>">
    <input type="text" id="nutzername" name="nutzername" placeholder="mein nutzername" readonly="readonly" value="<?php echo $info['username'] ?>">
    <input type="text" id="strasse" name="strasse" placeholder="meine Strasse" readonly="readonly" value="<?php echo $info['street'] ?>">
    <input type="text" id="street_number" name="street_number" placeholder="meine Strasse" readonly="readonly" value="<?php echo $info['street_number'] ?>">
    <input type="text" id="postleitzahl" name="postleitzahl" placeholder="44444" readonly="readonly" value="<?php echo $info['postcode'] ?>">
    <input type="text" id="stadt" name="stadt" placeholder="meine Stadt" readonly="readonly" value="<?php echo $info['city'] ?>">
    <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="account erstellt am: 01.01.2000" readonly="readonly" value="<?php echo $info['create_datetime'] ?>">

    <form>
        <button type="submit" formaction="editprofile.php">Bearbeiten</button>
    </form>

</body>
</html>