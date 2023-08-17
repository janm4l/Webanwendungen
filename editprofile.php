<!DOCTYPE html>
<html>
<title>Profil Bearbeiten</title>
<body>


<form>
    <input type="file" id="profilbild" name="profilbild">
    <input type="email" id="email" name="email" placeholder="meine E-Mail" />
    <input type="text" id="vorname" name="vorname" placeholder="Max">
    <input type="text" id="nachname" name="nachname" placeholder="Mustermann" >
    <input type="text" id="nutzername" name="nutzername" placeholder="meine nutzername">
    <input type="text" id="strasse" name="strasse" placeholder="meine Strasse" >
    <input type="text" id="hausnummer" name="hausnummer" placeholder="55a" >
    <input type="text" id="postleitzahl" name="postleitzahl" placeholder="44444" >
    <input type="text" id="stadt" name="stadt" placeholder="meine Stadt" >

    <input type="submit" value="Speichern" formaction="profile.php">
    </form>
<br>
<form>
<button type="submit" formaction="changepassword.php">Passwort &auml;ndern</button>
</form>

</body>
</html>