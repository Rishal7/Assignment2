<?php
require 'includes/url.php';
require 'classes/User.php';
require 'classes/Database.php';

session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    redirect('/login.php'); 
}

$db = new Database();
$conn = $db->getConn();

//$userID = $_SESSION["user_id"];


$user = User::getUserByID($conn, $_GET['id']);

?>
<?php require 'includes/header.php'; ?>

<a href="home.php?id=<?= $_SESSION['userID']; ?>" class="btn btn-primary">Home</a>

<h1 class="my-3">User Details</h1>

<p><strong>Username:</strong> <?php echo $user->username; ?></p>
<p><strong>Email:</strong> <?php echo $user->email; ?></p>
<p><strong>Phone:</strong> <?php echo $user->phone; ?></p>

<a href="edit-profile.php?id=<?= $_GET['id']; ?>" class="btn btn-outline-primary btn-sm">Edit Profile</a>
<a href="delete-profile.php?id=<?= $_GET['id']; ?>" class="btn btn-outline-primary btn-sm ms-2">Delete Profile</a>

<?php require 'includes/footer.php'; ?>

