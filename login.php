<?php

include 'utils/db.php';
include 'utils/user.php';

if(isLoggedIn()){
    header("location: profile.php");
    die();
}

$success = false;
$username = '';
$password = '';

if($_SERVER["REQUEST_METHOD"] === 'POST'){

    //Checken, ob Passwort und Usrename gesetzt sind
    if(isset($_POST['username'])){
        $username = trim($_POST['username']);
    }
    if(isset($_POST['password'])){
        $password = trim($_POST['password']);
    }

    
    if(!empty($username) && !empty($password)){
        // Prepare a select statement
        $sql = "SELECT id, password_hashed FROM users WHERE username = ?";
        global $conn;

            
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $username);

                
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                /* bind result variables */
                mysqli_stmt_bind_result($stmt, $userid, $password_db);
                    
                if(mysqli_stmt_num_rows($stmt) < 1){
                    $success = false;
                } else {
                    while (mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $password_db)){
                            login($userid);
                            $success = true;
                        }else{
                            $success = false;
                        }
                        break;
                    }
                }
            } else {
                echo "Es ist ein fehler aufgetreten.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
            
        }

        if($success){
            header("location: profile.php");
            die();
        }
    }
}


?>

<!DOCTYPE html>
<html>
<title>Login</title>
<body>
<form>
<button type="submit" formaction="register.php">Registrieren</button>
</form>

<form method="post">
    <input type="text" id="username" name="username" placeholder="Nutzername" value="<?php if (!empty($username)) echo $username ?>"/>
    <br>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($username)) echo "<span class=\"errormessage\" style=\"color: red\">Bitte gib einen Nutzernamen ein.</span><br>"; //Username-Fehler ?>
    <br>
    <input type="password" id="password" name="password" placeholder="Passwort">
    <br>
    <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($password)) echo "<span class=\"errormessage\" style=\"color: red\">Bitte gib ein Passwort ein.</span><br>"; //Password-Fehler ?>
    <br>
    <input type="submit" formaction="login.php" value="Login">
</form>
<?php if(!$success && !(empty($username) || empty($password))) echo "<span class=\"errormessage\" style=\"color: red\">Es existiert kein Konto mit diesem Nutzernamengit commi und diesem Passwort.</span>"; ?>

</body>
</html>