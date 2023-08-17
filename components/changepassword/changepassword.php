<!DOCTYPE html>
<html>
<title>Login</title>
<head>
    <link rel="stylesheet" href="/components/changepassword/changepassword.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>

<div id="changepasswordFormOuter">
<h1 id="changepasswordHeading">Passwort &auml;ndern</h1>
<div id="changepasswordFormInner">
<form method="post">
    Altes Passwort
    <br>
    <input type="password" id="oldpassword" name="oldpassword" placeholder="Altes Passwort" value="<?php if (!empty($oldpassword)) echo $oldpassword ?>" class="inputfield">
    <br>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($oldpassword)) echo "<span class=\"errormessage\">Bitte gib dein altes Passwort ein.</span><br>"; //Username-Fehler ?>
    <br>
    <br>
    Neues Passwort
    <br>
    <input type="password" id="newpassword" name="newpassword" placeholder="Neues Passwort" class="inputfield">
    <br>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($newpassword)) echo "<span class=\"errormessage\">Bitte gib ein neues Passwort ein.</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    Neues Passwort Best&auml;tigen
    <br>
    <input type="password" id="checknewpassword" name="checknewpassword" placeholder="Neues Passwort bestätigen" class="inputfield">
    <br>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($checknewpassword)) echo "<span class=\"errormessage\">Bitte bestätige dein neues Passwort.</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    <input type="submit" formaction="/components/changepassword/changepassword.php" value="Passwort &auml;ndern"> <a href="/components/profile/profile.php" class="button">Profil</a>
</form>
<br>

</div>
</div>
</body>
</html>