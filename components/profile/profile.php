<?php

include '../../utils/db.php';
include '../../utils/user.php';

$email_msg = '';
$username_msg = '';

$info = getUserInfo();

if(!isLoggedIn()){
    header("location: /components/login/login.php");
    die();
}




?>

<!DOCTYPE html>
<html>
<title>Profil</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/profile/profile.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
    <div id="profileFormOuter">
        <h1 id="profileHeading">PROFIL</h1>
        <div id="profileFormInner">
            <form>
                <img src="<?php echo getProfilePicturePath(); ?>" alt="Bild nicht geladen" width="200" height="200" style="border-radius: 100px">
                <br>
                <br>
                <form>
                    <button type="submit" formaction="/components/editprofile/editprofile.php" class="button">Bearbeiten</button>
                    <br><br>
                    <button type="submit" formaction="/components/changepassword/changepassword.php" class="button">Passwort &auml;ndern</button>
                </form>
                <br>
                E-Mail
                <br>
                <input type="email" id="email" name="email" placeholder="Meine E-Mail" readonly="readonly" value="<?php echo $info['email'] ?>" class="inputfield">
                <br>
                Vorname
                <br>
                <input type="text" id="forename" name="forename" placeholder="Max" readonly="readonly" value="<?php echo $info['forename'] ?>" class="inputfield">
                <br>
                Nachname
                <br>
                <input type="text" id="name" name="name" placeholder="Mustermann" readonly="readonly" value="<?php echo $info['name'] ?>" class="inputfield">
                <br>
                Nutzername
                <br>
                <input type="text" id="username" name="username" placeholder="mein username" readonly="readonly" value="<?php echo $info['username'] ?>" class="inputfield">
                <br>
                Straße
                <br>
                <input type="text" id="street" name="street" placeholder="meine street" readonly="readonly" value="<?php echo $info['street'] ?>" class="inputfield">
                <br>
                Hausnummer
                <br>
                <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" readonly="readonly" value="<?php echo $info['street_number'] ?>" class="inputfield">
                <br>
                Postleitzahl
                <br>
                <input type="text" id="postcode" name="postcode" placeholder="44444" readonly="readonly" value="<?php echo $info['postcode'] ?>" class="inputfield">
                <br>
                Stadt
                <br>
                <input type="text" id="city" name="city" placeholder="meine city" readonly="readonly" value="<?php echo $info['city'] ?>" class="inputfield">
                <br>
                Account erstellt am:
                <br>
                <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="01.01.2000" readonly="readonly" value="<?php echo $info['create_datetime'] ?>" readonly class="inputfield">
            </form>
            <br>
            <form>
                <button type="submit" formaction="/components/logout/logout.php" class="button">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
