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

    function updateInfo($username, $email, $street, $street_number, $postcode, $city, $profile_picture, $name, $forename){
        if(isLoggedIn()){
            // Prepare a select statement
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
                $param_profile_picture = (empty($param_profile_picture) ? null : $param_profile_picture);
                $param_name = (empty($name) ? null : $name);
                $param_forename = (empty($forename) ? null : $forename);

                echo $sql = "UPDATE users SET username = $param_username, email = $param_email, street = $param_street, street_number = $param_street_number, postcode = $param_postcode, city = $param_city, profile_picture = $param_profile_picture, name = $param_name, forename = $param_forename WHERE id = $param_id";;

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_email, $param_street, $param_street_number, $param_postcode, $param_city, $param_profile_picture, $param_name, $param_forename, $param_id);

                    
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    return true;
                } else {
                    echo "Es ist ein fehler aufgetreten.";
                    return false;
                }
                // Close statement
                mysqli_stmt_close($stmt);
                
            }
        }else{
            return false;
        }
    }

    function changePassword(){

        /*
            TODO
        */
        
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
            // Prepare a select statement
            $sql = "SELECT username, email, create_datetime, street, street_number, postcode, city, profile_picture, name, forename FROM users WHERE id = ?";
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
                    mysqli_stmt_bind_result($stmt, $username, $email, $create_datetime, $street, $street_number, $postcode, $city, $profile_picture, $name, $forename);
                        
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