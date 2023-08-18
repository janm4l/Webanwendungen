<?php

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
    $sql = "SELECT id FROM users WHERE UPPER(email) LIKE UPPER(?)";
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
    $sql = "SELECT id FROM users WHERE UPPER(username) LIKE UPPER(?)";
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
        $password_msg = "Das Passwort muss mindestens 8 Zeichen lang sein und aus Großbuchstaben, Kleinbuchstaben, Zahlen und Sonderzeichen bestehen.";
        return false;  
    }

    global $password_final;
    $password_final = $password;
    return true;
}

function validateConfirmPassword($confirm_password){
    global $password_final;
    if($password_final != ''){
        global $confirm_password_msg;
        if(empty($confirm_password)){
            $confirm_password_msg = "Bitte gib dein Passwort erneut ein.";
            return false;     
        }
        
        if($password_final != $confirm_password){
            $confirm_password_msg = "Die eingegebenen Passwörter stimmen nicht überein.";
            return false;
        }
    }
   

    $confirm_password_final = $confirm_password;
    return true;
    
}

function validateInputLength($input, $maxlength){
    if(strlen($input) > $maxlength){
        return "Die Eingabe darf höchstens $maxlength Zeichen lang sein.";  
    }else{
        return '';
    }
}

function validatePostcode($postcode){
    global $postcode_msg;
    if(!empty($postcode)){
        if(!is_numeric($postcode)){
            $postcode_msg = "Die Postleitzahl muss eine Zahl sein.";
            return false;
        }
    
        if($postcode < 1000 || $postcode > 99999){
            $postcode_msg = "Die Postleitzahl muss vier- oder fünfstellig sein.";
        }
    }
    

    global $postcode_final;
    $postcode_final = $postcode;
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