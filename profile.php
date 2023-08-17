<?php

include 'utils/db.php';
include 'utils/user.php';

$email_msg = '';
$username_msg = '';

if(!isLoggedIn()){
    header("location: login.php");
    die();
}

$info = getUserInfo();


?>

<!DOCTYPE html>
<html>
<title>Profil</title>
<body>
<form>
    <button type="submit" formaction="logout.php">Logout</button>
</form>
    <?php echo "<h1>Hallo " .  $info['username'] . ", du bist eingeloggt und hast die UserId " . getUserId() . "</h1>"; ?>
    <img src="<?php echo getProfilePicturePath(); ?>" alt="Bild nicht geladen" width="200" height="200">
    <input type="email" id="email" name="email" placeholder="Meine E-Mail" readonly="readonly" value="<?php echo $info['email'] ?>"/>
    <input type="text" id="forename" name="forename" placeholder="Max" readonly="readonly" value="<?php echo $info['forename'] ?>">
    <input type="text" id="name" name="name" placeholder="Mustermann" readonly="readonly" value="<?php echo $info['name'] ?>">
    <input type="text" id="username" name="username" placeholder="mein username" readonly="readonly" value="<?php echo $info['username'] ?>">
    <input type="text" id="street" name="street" placeholder="meine street" readonly="readonly" value="<?php echo $info['street'] ?>">
    <input type="text" id="street_number" name="street_number" placeholder="meine Hausnummer" readonly="readonly" value="<?php echo $info['street_number'] ?>">
    <input type="text" id="postcode" name="postcode" placeholder="44444" readonly="readonly" value="<?php echo $info['postcode'] ?>">
    <input type="text" id="city" name="city" placeholder="meine city" readonly="readonly" value="<?php echo $info['city'] ?>">
    <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="account erstellt am: 01.01.2000" readonly="readonly" value="<?php echo $info['create_datetime'] ?>">

    <form>
        <button type="submit" formaction="editprofile.php">Bearbeiten</button>
    </form>

</body>
</html>
