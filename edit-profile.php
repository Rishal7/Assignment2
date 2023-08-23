<?php

require 'includes/url.php';
require 'classes/User.php';
require 'classes/Database.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    redirect('/login.php'); // Redirect to the login page if not logged in
}

$db = new Database();
$conn = $db->getConn();
$user = new User();

if (isset($_GET['id'])) {

    $user = User::getUserByID($conn, $_GET['id']);

    if (!$user) {
        die("article not found");
    }

} else {
    die("id not supplied, user not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];

    if ($user->update($conn)) {
        redirect("/profile.php?id={$user->id}");
    } else {
        echo "failed";
    }
}
?>




<?php require 'includes/header.php'; ?>

<h2>Edit profile</h2>

<?php require 'includes/user-form.php'; ?>

<?php require 'includes/footer.php'; ?>