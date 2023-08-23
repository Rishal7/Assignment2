<?php

require 'includes/url.php';
require 'classes/User.php';
require 'classes/Database.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->getConn();


    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {

        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;

        $_SESSION['username'] = $_POST['username'];

        $user = User::getUserByUsername($conn, $_POST['username']);

        $_SESSION['userID'] = $user->id;

        $_SESSION['role'] = $user->role;

        redirect('/home.php?id=' . $user->id);

    } else {

        $error = "login incorrect";

    }
}

?>
<?php require 'includes/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($error)): ?>
    <p>
        <?= $error ?>
    </p>
<?php endif; ?>

<form method="post">

    <div class="form-floating my-3">
        <input name="username" id="username" class="form-control" placeholder="username">
        <label for="username">Username</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" name="password" id="password" class="form-control" placeholder="password">
        <label for="password">Password</label>
    </div>

    <button class="btn btn-primary">Log in</button>

</form>

<?php require 'includes/footer.php'; ?>