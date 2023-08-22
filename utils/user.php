<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function login($userid){
        $_SESSION['userid'] = $userid;
    }

    function logout(){
        if(isLoggedIn()){
            // Aus dem PHP User-Manual:
            // Alle Variablen der Session löschen
            $_SESSION = array();

            // Session-Cookie clientseitig löschen
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Session serverseitig zerstören
            session_destroy();
        } 
    }
    
    function getUserId(){
        if(isLoggedIn()){
            return $_SESSION['userid'];
        }else{
            return null;
        }
    }

    function registerAndLoginUser($email, $username, $password){
        
        // Statement schreiben
        $sql = "INSERT INTO users (email, username, password_hashed) VALUES (?, ?, ?)";
         
        global $conn;
        if($stmt = mysqli_prepare($conn, $sql)){
            // Variablen an Parameter des Statements binden
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            
            // Parameter festlegen
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Statement ausführen
            if(mysqli_stmt_execute($stmt)){
                $userid = mysqli_insert_id($conn);
                login($userid);
                return true;
            } else {
                echo "Es ist ein Fehler aufgetreten.";
                return false;
            }

            // Statement beenden
            mysqli_stmt_close($stmt);
        }
    }

    function updateUserPassword($new_password){
        if(isLoggedIn()){
            // Statement schreiben
            $sql = "UPDATE users SET password_hashed = ? WHERE id = ?";
            global $conn;
                    
            if($stmt = mysqli_prepare($conn, $sql)){
                // Variablen an Parameter des Statements binden
                $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
                $param_userid = getUserId();

                // Variablen an Parameter des Statements binden
                mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_userid);
                        
                // Statement ausführen
                if(mysqli_stmt_execute($stmt)){
                    return true;
                } else {
                    echo "Es ist ein Fehler aufgetreten.";
                    return false;
                }

                // Statement beenden
                mysqli_stmt_close($stmt);
            }
        }else{
            return false;
        }
        
    }

    /*
        Zur Verwendung dieser Methode bitte vorher filestorge.php importieren
    */
    function deleteProfilePicture(){
        if(isLoggedIn()){
            $info = getUserInfo();
            $filename = $info['profile_picture'];
            // Statement schreiben
            $sql = "UPDATE users SET profile_picture = '' WHERE id = ?";
            global $conn;

            if($stmt = mysqli_prepare($conn, $sql)){
                $param_id = getUserId();
                // Variablen an Parameter des Statements binden
                mysqli_stmt_bind_param($stmt, "s", $param_id);

                    
                // Statement ausführen
                if(mysqli_stmt_execute($stmt)){
                    deletePicture($filename);
                    return true;
                } else {
                    echo "Es ist ein Fehler aufgetreten.";
                    return false;
                }
                // Statement beenden
                mysqli_stmt_close($stmt);
                
            }
        }else{
            return false;
        }
    }

    function updateInfo($username, $email, $street, $street_number, $postcode, $city, $profile_picture, $name, $forename){
        if(isLoggedIn()){
            // Statement schreiben
            $sql = "UPDATE users SET username = ?, email = ?, street = ?, street_number = ?, postcode = ?, city = ?, profile_picture = ?, name = ?, forename = ? WHERE id = ?";
            global $conn;

            if($stmt = mysqli_prepare($conn, $sql)){
                $param_id = getUserId();
                $param_username = $username;
                $param_email = $email;
                $param_street = (empty($street) ? null : $street);
                $param_street_number = (empty($street_number) ? null : $street_number);
                $param_postcode = (empty($postcode) ? null : $postcode);
                $param_city = (empty($city) ? null : $city);
                $param_profile_picture = (empty($profile_picture) ? null : $profile_picture);
                $param_name = (empty($name) ? null : $name);
                $param_forename = (empty($forename) ? null : $forename);

                // Variablen an Parameter des Statements binden
                mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_email, $param_street, $param_street_number, $param_postcode, $param_city, $param_profile_picture, $param_name, $param_forename, $param_id);

                    
                // Statement ausführen
                if(mysqli_stmt_execute($stmt)){
                    return true;
                } else {
                    echo "Es ist ein Fehler aufgetreten.";
                    return false;
                }
                // Statement beenden
                mysqli_stmt_close($stmt);
                
            }
        }else{
            return false;
        }
    }

    function getProfilePicturePath(){
        $defaultfilepath = '/assets/images/profile_standard.png';
        $custom_path = '/content/profilepics/';
        if(isLoggedIn()){
            $info = getUserInfo();
            if(!empty($info) && !empty($info['profile_picture'])){
                return $custom_path . $info['profile_picture'];
            }else{
                return $defaultfilepath;
            }
        }else{
            return $defaultfilepath;
        }
    }

    /* 
        Vor der Verwendung bitte utils/db.php importieren!!!
    */
    function getUserInfo(){
        if(isLoggedIn()){
            // Statement schreiben
            $sql = "SELECT username, email, password_hashed, create_datetime, street, street_number, postcode, city, profile_picture, name, forename FROM users WHERE id = ?";
            global $conn;

                
            if($stmt = mysqli_prepare($conn, $sql)){
                $param_id = getUserId();
                // Variablen an Parameter des Statements binden
                mysqli_stmt_bind_param($stmt, "s", $param_id);

                    
                // Statement ausführen
                if(mysqli_stmt_execute($stmt)){
                    // Result abspeichern
                    mysqli_stmt_store_result($stmt);

                    //Result in Variablen speichern
                    mysqli_stmt_bind_result($stmt, $username, $email, $password_hashed, $create_datetime, $street, $street_number, $postcode, $city, $profile_picture, $name, $forename);
                        
                    if(mysqli_stmt_num_rows($stmt) < 1){
                        echo "Keine Userinfo";
                        logout(); //Nutzerinfo kann nicht geladen werden (z.B. Account gelöscht) -> Nutzer ausloggen
                        return null;
                    } else {
                        $info = array();
                        while (mysqli_stmt_fetch($stmt)){
                            $info['username'] = $username;
                            $info['email'] = $email;
                            $info['password_hashed'] = $password_hashed;
                            $info['create_datetime'] = $create_datetime;
                            $info['street'] = $street;
                            $info['street_number'] = $street_number;
                            $info['postcode'] = $postcode;
                            $info['city'] = $city;
                            $info['profile_picture'] = $profile_picture;
                            $info['name'] = $name;
                            $info['forename'] = $forename;
                            break;
                        }
                        return $info;
                    }
                } else {
                    echo "Es ist ein Fehler aufgetreten.";
                    return null;
                }
                // Statement beenden
                mysqli_stmt_close($stmt);
                
            }
        }else{
            return null;
        }
    }

    function isLoggedIn(){
        if (session_status() === PHP_SESSION_NONE) {
            return false;
        }else if(!isset($_SESSION['userid'])){
            return false;
        }else if($_SESSION['userid']){
            return true;
        }
    }


?>