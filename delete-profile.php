<?php

require 'classes/Database.php';
require 'classes/User.php';
require 'includes/url.php';

session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    redirect('/login.php'); // Redirect to the login page if not logged in
}

$db = new Database();
$conn = $db->getConn();

if (isset($_GET['id'])) {

    $user = User::getUserByID($conn, $_GET['id']);

    if (!$user) {
        die("User not found");
    }

} else {
    die("id not supplied, user not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($user->delete($conn)) {

        redirect("/login.php");

    }
}

?>

<?php require 'includes/header.php'; ?>

<h1>Delete user</h1>

<form method="post">

    <p class="my-3">Are you sure?</p>

    <button class="btn btn-outline-primary btn-sm">Delete</button>

    <a href="/profile.php?id=<?= $product->id;?>" class="btn btn-outline-primary btn-sm ms-2">Cancel</a>

</form>
<?php require 'includes/footer.php'; ?>