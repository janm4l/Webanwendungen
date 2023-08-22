<?php
include '../utils/db.php';
include '../utils/user.php';
include '../filestorage.php';

$old_password_msg = '';
$password_msg = '';
$confirm_password_msg = '';

$info = getUserinfo();

// JSON-Daten werden empfangen
$data = json_decode(file_get_contents('php://input'), true);

$success = false;
if($data['delete']){
    $success = deleteProfilePicture();
}

$response = array('success' => $success);
echo json_encode($response);

// MySQL-Verbindung beenden
mysqli_close($conn);
?>
