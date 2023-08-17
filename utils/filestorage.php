<?php

function generateRandomString(int $n): string {
    $characters="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $string = "";
    for($i = 0; $i<$n; $i++){
        $index = rand(0, strlen($characters)-1);
        $string .= $characters[$index];
    }
    return $string;
}

function storgeProfilePicture(){
    $randomString = generateRandomString(10);
    $target_dir = "content/profilepics/";
    $target_file = $target_dir . basename($_FILES["profilepicture"][randomString]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profilepicture"]["tmp_name"]);
    if($check == false) {
        return [false, 'Die Datei ist kein Bild.'];
    }

    // Dateigröße überprüfen
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        return [false, 'Die Datei ist zu groß. Die maximale Größe beträgt 500 kB.'];
    }

    // Dateifromat überprüfen
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        return [false, 'Ungültiges Dateiformat. Erlaubte Endungen: JPG, JPEG, PNG, GIF'];
    }

    if (move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $target_file)) {
        return [true, $randomString . $imageFileType];
      } else {
        return [false, 'Es ist ein Problem beim Upload aufgetreten.'];
      }
}

?>