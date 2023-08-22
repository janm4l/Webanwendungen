<?php
include '../utils/db.php';
include '../utils/user.php';
include '../utils/validation.php';

$old_password_msg = '';
$password_msg = '';
$confirm_password_msg = '';

$info = getUserinfo();

// JSON-Daten werden empfangen
$data = json_decode(file_get_contents('php://input'), true);

//Altes Passwort
$old_password_final = '';
$old_password_validated = (password_verify(trim($data['old_password']), $info['password_hashed']) ? true : false);
$old_password_msg = ($old_password_validated ? '' : 'Dieses Passwort stimmt nicht mit deinem aktuellen Passwort überein.');

// Validate password
$password_final = '';
$password_validated = validatePassword(trim($data['password']));

// Validate confirm password
$confirm_password_validated = validateConfirmPassword(trim($data['confirm_password']));
$result = false;
// Check input errors before inserting in database
if($old_password_validated && $password_validated && $confirm_password_validated){
    $result = updateUserPassword($password_final);
}
$response = array('success' => $result, 'old_password_msg' => $old_password_msg, 'password_msg' => $password_msg, 'confirm_password_msg' => $confirm_password_msg);
echo json_encode($response);

// Close connection
mysqli_close($conn);
?>
