<?php

require 'classes/Database.php';
require 'classes/Product.php';
require 'roles.php';

session_start();

$db = new Database();
$conn = $db->getConn();
$product = new Product();

if (isset($_GET['id'])) {
    $product = Product::getWithCategories($conn, $_GET['id']);
} else {
    $product = null;
}

?>
<?php require 'includes/header.php'; ?>

<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']): ?>

    <a href="home.php?id=<?= $_SESSION['userID']; ?>" class="btn btn-primary">Home</a>

    <h1 class="my-3">Welcome</h1>

    <?php if ($product): ?>

        <article class="mt-4">
            <h3>
                <?= $product[0]['name']; ?>
            </h3>
            <p>
                Rs: <?= $product[0]['price']; ?>
            </p>
            <p>
                Category: <?= $product[0]['category_name']; ?>
            </p>
            <p>
                Added by: <?= $product[0]['added_by']; ?>
            </p>
            
        </article>

        <!-- <?php if($_SESSION['username'] == $product[0]['added_by']): ?>

        <a href="edit-product.php?id=<?= $product[0]['id']; ?>" class="btn btn-outline-primary btn-sm">Edit</a>
        <a href="delete-product.php?id=<?= $product[0]['id']; ?>"class="btn btn-outline-primary btn-sm ms-2">Delete</a>

        <?php endif;?> -->


        <?php
        $loggedInUsername = $_SESSION['username'];
        $role = $_SESSION['role'];

        if (array_key_exists($role, $roleCapabilities)) {
            $capabilities = $roleCapabilities[$role];

            if (($role === 'admin' && $capabilities['edit']) ||    ($capabilities['edit'] && $loggedInUsername == $product[0]['added_by'])) {
                echo '<a href="edit-product.php?id=' . $product[0]['id'] . '" class="btn btn-outline-primary btn-sm">Edit</a>';
            }

            if (($role === 'admin' && $capabilities['delete']) ||    ($capabilities['delete'] && $loggedInUsername == $product[0]['added_by'])) {
                echo '<a href="delete-product.php?id=' . $product[0]['id'] . '" class="btn btn-outline-primary btn-sm ms-2">Delete</a>';
            }
        }
        ?>


    <?php else: ?>

        <p>Product not found</p>

    <?php endif; ?>

<?php else: ?>

    <p>You are not logged in. <a href="login.php">Log in</a></p>

<?php endif; ?>