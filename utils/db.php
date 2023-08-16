<?
$conn = mysqli_connect("provadis.jmsenger.de", "provadis", "AmirAmirAmir123");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>