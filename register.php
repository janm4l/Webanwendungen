<?php

include 'utils/db.php';
include 'utils/user.php';
include 'utils/validation.php';

$email_msg = '';
$username_msg = '';
$password_msg = '';
$confirm_password_msg = '';

if(isLoggedIn()){
    header("location: profile.php");
    die();
}

// Die folgenden Schritte werden nur ausgeführt, wenn ein Formular abgesendet wurde (also nicht bei erstmaligem Aufruf der Seite)
if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    // E-Mail überprüfen
    $email_final = '';
    $email_validated = validateEmail(trim($_POST['email']));

    // Nutzernamen überprüfen
    $username_final = '';
    $username_validated = validateUsername(trim($_POST['username']));
    
    // Validate password
    $password_final = '';
    $password_validated = validatePassword(trim($_POST['password']));
    
    // Validate confirm password
    $confirm_password_validated = validateConfirmPassword(trim($_POST['confirm_password']));
    
    // Check input errors before inserting in database
    if($email_validated && $username_validated && $password_validated && $confirm_password_validated){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, username, password_hashed) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            
            // Set parameters
            $param_email = $email_final;
            $param_username = $username_final;
            $param_password = password_hash($password_final, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $userid = mysqli_insert_id($conn);
                login($userid);

                // Redirect to login page
                header("location: profile.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}



?>

<!DOCTYPE html>
<html>
<title>Registrieren</title>
<body>

<form method="post">
    Email *
    <br>
    <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required="required"/>
    <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\" style=\"color: red\">$email_msg</span><br>"; //E-Mail-Fehler ?>
    <br>
    <br>
    Nutzername *
    <br>
    <input type="text" id="username" name="username" placeholder="Nutzername" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required="required">
    <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\" style=\"color: red\">$username_msg</span><br>"; //Username-Fehler ?>
    <br>
    <br>
    Passwort *
    <br>
    <input type="password" id="password" name="password" placeholder="Passwort" required="required">
    <?php if (isset($password_validated) && !$password_validated) echo "<span class=\"errormessage\" style=\"color: red\">$password_msg</span><br>"; //Password-Fehler ?>
    <br>
    <br>
    Passwort Bestätigen *
    <br>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Passwort Bestätigen" required="required">
    <?php if (isset($confirm_password_validated) && !$confirm_password_validated) echo "<span class=\"errormessage\" style=\"color: red\">$confirm_password_msg</span><br>"; //Confirm-Password-Fehler ?>
    <br>
    <br>
    Vorname
    <br>
    <input type="text" id="vorname" name="vorname" placeholder="Vorname">
    <br>
    <br>
    Nachname
    <br>
    <input type="text" id="nachname" name="nachname" placeholder="Nachname">
    <br>
    <br>
    Postleitzahl
    <br>
    <input type="text" id="postleitzahl" name="postleitzahl" placeholder="Postleitzahl">
    <br>
    <br>
    Ort
    <br>
    <input type="text" id="ort" name="ort" placeholder="Ort">
    <br>
    <br>
    Straße
    <br>
    <input type="text" id="straße" name="straße" placeholder="Straße">
    <br>
    <br>
    Hausnummer
    <br>
    <input type="text" id="hausnummer" name="hausnummer" placeholder="Hausnummer">
    <br>
    <br>
    <input type="submit" formaction="register.php" value="Registrieren">
</form>

</body>
</html>