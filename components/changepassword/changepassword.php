<!DOCTYPE html>
<html>
<title>Login</title>
<body>


<form method="post">
    Altes Passwort
    <br>
    <input type="password" id="oldpassword" name="oldpassword" placeholder="Altes Passwort" value="<?php if (!empty($oldpassword)) echo $oldpassword ?>"/>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($oldpassword)) echo "<span class=\"errormessage\" style=\"color: red\">Bitte gib dein altes Passwort ein.</span><br>"; //Username-Fehler ?>
    <br>
    <br>
    Neues Passwort
    <br>
    <input type="password" id="newpassword" name="newpassword" placeholder="Neues Passwort">
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($newpassword)) echo "<span class=\"errormessage\" style=\"color: red\">Bitte gib ein neues Passwort ein.</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    Neues Passwort Best&auml;tigen
    <br>
    <input type="password" id="checknewpassword" name="checknewpassword" placeholder="Neues Passwort bestätigen">
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($checknewpassword)) echo "<span class=\"errormessage\" style=\"color: red\">Bitte bestätige dein neues Passwort.</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    <input type="submit" formaction="changepassword.php" value="Passwort &auml;ndern">
</form>
<br>
<form>
<button type="submit" formaction="profile.php">Profil</button>
</form>
</body>
</html>