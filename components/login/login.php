<?php

include '../../utils/db.php';
include '../../utils/user.php';

if(isLoggedIn()){
    header("location: /components/profile/profile.php");
    die();
}

$success = false;
$username = '';
$password = '';

if($_SERVER["REQUEST_METHOD"] === 'POST'){

    //Checken, ob Passwort und Username gesetzt sind
    if(isset($_POST['username'])){
        $username = trim($_POST['username']);
    }
    if(isset($_POST['password'])){
        $password = trim($_POST['password']);
    }

    
    if(!empty($username) && !empty($password)){
        // Statement schreiben
        $sql = "SELECT id, password_hashed FROM users WHERE UPPER(username) = UPPER(?)";
        global $conn;

            
        if($stmt = mysqli_prepare($conn, $sql)){
            // Variablen an Parameter des Statements binden
            mysqli_stmt_bind_param($stmt, "s", $username);

                
            // Statement ausführen
            if(mysqli_stmt_execute($stmt)){
                // Result abspeichern
                mysqli_stmt_store_result($stmt);

                //Result in Variablen speichern
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
            //Statement beenden
            mysqli_stmt_close($stmt);
            
        }

        if($success){
            header("location: /components/profile/profile.php");
            die();
        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/components/login/login.css">
    <link rel="stylesheet" href="/main.css">
</head>
<body>
    <div id="loginFormOuter">
        <h1 id="loginHeading">LOGIN</h1>
        <div id="loginFormInner">
            <form method="post">
                Nutzername
                <br>
                <input type="text" id="username" name="username" required="required" placeholder="Nutzername" value="<?php if (!empty($username)) echo $username; ?>" class="inputfield">
                <br>
                <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($username)) echo "<span class=\"errormessage\">Bitte gib einen Nutzernamen ein.</span><br>"; //Username-Fehler ?>
                <br>
                Passwort
                <br>
                <input type="password" id="password" name="password" required="required" placeholder="Passwort" class="inputfield">
                <br>
                <?php if ($_SERVER["REQUEST_METHOD"] === 'POST' && empty($password)) echo "<span class=\"errormessage\">Bitte gib ein Passwort ein.</span><br>"; //Password-Fehler ?>
                <?php if(!$success && !(empty($username) || empty($password))) echo "<span class=\"errormessage\">Es existiert kein Konto mit dieser E-Mail und diesem Passwort.</span>"; ?>
                <input type="submit" formaction="/components/login/login.php" value="Login" class="button">
                <a href="/components/register/register.php" class="button" style="text-decoration: none; text-align: center">Registrieren</a>
            </form>
            <br>
            <br>

        </div>
    </div>

</body>
</html>