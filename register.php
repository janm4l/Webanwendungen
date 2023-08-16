<?php

include 'utils/db.php';
include 'utils/user.php';

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

function validateEmail($email){
    global $email_msg;
    if(empty($email)){
        $email_msg = "Bitte gib eine E-Mail ein.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_msg = "Die eingegebene E-Mail ist ungültig.";
        return false;
    }

    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE email = ?";
    global $conn;
        
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $email);

            
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
                
            if(mysqli_stmt_num_rows($stmt) >= 1){
                $email_msg = "Diese E-Mail wird bereits verwendet.";
                return false;
            } else {
                global $email_final;
                $email_final = $email;
                return true;
            }
        } else {
            echo "Es ist ein fehler aufgetreten.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
        
    }

     // Close connection
     mysqli_close($conn); 

    global $email_final;
    $email_final = $email;
    return true;
}

function validateUsername($username){
    global $username_msg;
    if(empty($username)){
        $username_msg = "Bitte gib einen gültigen Benutzernamen ein.";
        return false;
    } 
    
    if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Nutzernamen dürfen nur Buchstaben, Zahlen und Unterstriche enthalten.";
        return false;
    } 

    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = ?";
    global $conn;
        
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

            
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
                
            if(mysqli_stmt_num_rows($stmt) >= 1){
                $username_msg = "Dieser Nutzername wird bereits verwendet.";
                return false;
            } else {
                global $username_final;
                $username_final = $username;
                return true;
            }
        } else {
            echo "Es ist ein fehler aufgetreten.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
        
    }

     // Close connection
     mysqli_close($conn);    
}

function validatePassword($password){
    global $password_msg;
    if(empty($password)){
        $password_msg = "Bitte gib ein Passwort ein.";
        return false;     
    }
    if(!checkPasswordRequirements($password)){
        $password_msg = "Das Passwort muss mindestens 8 Zeichen lang sein und aus Großuchstaben, Kleinbuchstaben, Zahlen und Sonderzeichen bestehen.";
        return false;  
    }

    global $password_final;
    $password_final = $password;
    return true;
}

function validateConfirmPassword($confirm_password){
    global $confirm_password_msg;
    if(empty($confirm_password)){
        $confirm_password_msg = "Bitte gib dein Password erneut ein.";
        return false;     
    }
    
    global $password_final;
    if($password_final != $confirm_password){
        $confirm_password_msg = "Die eingegebenen Passwörter stimmen nicht überein.";
        return false;
    }

    $confirm_password_final = $confirm_password;
    return true;
    
}

function checkPasswordRequirements($password){
    if (strlen($password) < 8) return false; //Prüfen, ob Passwort mindestens 8 Zeichen lang ist
    if (!preg_match('/\W/', $password)) return false; //Prüfen, ob mindestens ein Sonderzeichen vorhanden ist
    if (!preg_match('/\d/', $password)) return false; //Prüfen, ob mindestens eine Zahl vorhanden ist
    if (!preg_match('/[A-Z]/', $password)) return false; //Prüfen, ob mindestens ein Großbuchstabe vorhanden ist
    if (!preg_match('/[a-z]/', $password)) return false; //Prüfen, ob mindestens ein Kleinbuchstabe vorhanden ist
    return true;
}

?>

<!DOCTYPE html>
<html>
<title>Registrieren</title>
<body>

<form method="post">
    <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
    <br>
    <?php if (isset($email_validated) && !$email_validated) echo "<span class=\"errormessage\" style=\"color: red\">$email_msg</span><br>"; //E-Mail-Fehler ?>
    <br>
    <input type="text" id="username" name="username" placeholder="Nutzername" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
    <br>
    <?php if (isset($username_validated) && !$username_validated) echo "<span class=\"errormessage\" style=\"color: red\">$username_msg</span><br>"; //Username-Fehler ?>
    <br>
    <input type="password" id="password" name="password" placeholder="Passwort">
    <br>
    <?php if (isset($password_validated) && !$password_validated) echo "<span class=\"errormessage\" style=\"color: red\">$password_msg</span><br>"; //Password-Fehler ?>
    <br>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Passwort Bestätigen">
    <br>
    <?php if (isset($confirm_password_validated) && !$confirm_password_validated) echo "<span class=\"errormessage\" style=\"color: red\">$confirm_password_msg</span><br>"; //Confirm-Password-Fehler ?>
    <br>
    <input type="submit" formaction="register.php" value="Registrieren">
</form>

</body>
</html>