<?php

include '../../utils/db.php';
include '../../utils/user.php';

$email_msg = '';
$username_msg = '';

if(!isLoggedIn()){
    header("location: /components/login/login.php");
    die();
}

$info = getUserInfo();


?>

<!DOCTYPE html>
<html>
<title>Profil</title>
<head>
    <link rel="stylesheet" href="/components/profile/profile.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
<form>
    <button type="submit" formaction="/components/logout/logout.php" class="button">Logout</button>
</form>
    <?php echo "<h1>Hallo " .  $info['username'] . ", du bist eingeloggt und hast die UserId " . getUserId() . "</h1>"; ?>
    <img src="<?php echo getProfilePicturePath(); ?>" alt="Bild nicht geladen" width="200" height="200">
    <br>
    <br>
    E-Mail
    <br>
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" readonly="readonly" value="<?php echo $info['email'] ?>" class="inputfield">
    <br>
    <br>
    Vorname
    <br>
    <input type="text" id="forename" name="forename" placeholder="Max" readonly="readonly" value="<?php echo $info['forename'] ?>" class="inputfield">
    <br>
    <br>
    Nachname
    <br>
    <input type="text" id="name" name="name" placeholder="Mustermann" readonly="readonly" value="<?php echo $info['name'] ?>" class="inputfield">
    <br>
    <br>
    Nutzername
    <br>
    <input type="text" id="username" name="username" placeholder="mein username" readonly="readonly" value="<?php echo $info['username'] ?>" class="inputfield">
    <br>
    <br>
    Straße
    <br>
    <input type="text" id="street" name="street" placeholder="meine street" readonly="readonly" value="<?php echo $info['street'] ?>" class="inputfield">
    <br>
    <br>
    Hausnummer
    <br>
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" readonly="readonly" value="<?php echo $info['street_number'] ?>" class="inputfield">
    <br>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postcode" name="postcode" placeholder="44444" readonly="readonly" value="<?php echo $info['postcode'] ?>" class="inputfield">
    <br>
    <br>
    Stadt
    <br>
    <input type="text" id="city" name="city" placeholder="meine city" readonly="readonly" value="<?php echo $info['city'] ?>" class="inputfield">
    <br>
    <br>
    Account erstellt am:
    <br>
    <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="01.01.2000" readonly="readonly" value="<?php echo $info['create_datetime'] ?>" readonly class="inputfield">
    <br>
    <br>
    <form>
        <button type="submit" formaction="/components/editprofile/editprofile.php" class="button">Bearbeiten</button>
    </form>

</body>
</html>
