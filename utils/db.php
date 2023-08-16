<?php
    $conn = mysqli_connect("provadis.jmsenger.de:3306", "provadis", "AmirAmirAmir123", "provadis");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
       // echo "Connected successfully";
    }
?>