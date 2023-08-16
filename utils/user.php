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
            // Unset all of the session variables.
            $_SESSION = array();

            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Finally, destroy the session.
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

    /* 
        Vor der Verwendung bitte utils/db.php importieren!!!
    */
    function getUserInfo(){
        if(isLoggedIn()){
            // Prepare a select statement
            $sql = "SELECT username, email, create_datetime, street, postcode, city, profile_picture, name, forename, street_nr FROM users WHERE id = ?";
            global $conn;

                
            if($stmt = mysqli_prepare($conn, $sql)){
                $param_id = getUserId();
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_id);

                    
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $username, $email, $create_datetime, $street, $postcode, $city, $profile_picture, $name, $forename, $street_nr);
                        
                    if(mysqli_stmt_num_rows($stmt) < 1){
                        echo "Keine Userinfo";
                        return null;
                    } else {
                        $info = array();
                        while (mysqli_stmt_fetch($stmt)){
                            $info['username'] = $username;
                            $info['email'] = $email;
                            $info['create_datetime'] = $create_datetime;
                            $info['street'] = $street;
                            $info['postcode'] = $postcode;
                            $info['city'] = $city;
                            $info['profile_picture'] = $profile_picture;
                            $info['name'] = $name;
                            $info['forename'] = $forename;
                            $info['street_nr'] = $street_nr;
                            break;
                        }
                        return $info;
                    }
                } else {
                    echo "Es ist ein fehler aufgetreten.";
                    return null;
                }
                // Close statement
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