<?php

require 'classes/Database.php';
require 'classes/User.php';
require 'includes/url.php';

$db = new Database();

$user = new User();
$conn = $db->getConn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($user->register($conn)) {
        redirect('/login.php');
    } else {
        echo "User registration failed";
    }
}
?>

<?php require 'includes/header.php'; ?>

<h2>Register</h2>

<?php require 'includes/user-form.php'; ?>

<?php require 'includes/footer.php'; ?>

