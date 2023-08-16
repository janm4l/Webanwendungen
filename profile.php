<!DOCTYPE html>
<html>
<title>Profil</title>
<body>
<form>
    <button type="submit" formaction="login.php">Logout</button>
</form>
    <img src="profilbildtest.png" alt="Bild nicht geladen" width="200" height="200">
    <input type="email" id="email" name="email" placeholder="meine E-Mail" readonly="readonly"/>
    <input type="text" id="vorname" name="vorname" placeholder="Max" readonly="readonly">
    <input type="text" id="nachname" name="nachname" placeholder="Mustermann" readonly="readonly">
    <input type="text" id="nutzername" name="nutzername" placeholder="mein nutzername" readonly="readonly">
    <input type="text" id="strasse" name="strasse" placeholder="meine Strasse" readonly="readonly">
    <input type="text" id="hausnummer" name="hausnummer" placeholder="55a" readonly="readonly">
    <input type="text" id="postleitzahl" name="postleitzahl" placeholder="44444" readonly="readonly">
    <input type="text" id="stadt" name="stadt" placeholder="meine Stadt" readonly="readonly">
    <input type="text" id="accountErstelltAm" name="accountErstelltAm" placeholder="account erstellt am: 01.01.2000" readonly="readonly">

    <form>
        <button type="submit" formaction="editprofile.php">Bearbeiten</button>
    </form>

</body>
</html>