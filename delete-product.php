<?php

require 'classes/Database.php';
require 'classes/Product.php';
require 'includes/url.php';

session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    redirect('/login.php'); // Redirect to the login page if not logged in
}

$db = new Database();
$conn = $db->getConn();
$product = new Product();

if (isset($_GET['id'])) {

    $product = Product::getByID($conn, $_GET['id']);

    if (!$product) {
        die("Product not found");
    }

} else {
    die("id not supplied, product not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($product->delete($conn)) {

        redirect("/home.php");

    }
}

?>

<?php require 'includes/header.php'; ?>

<h1>Delete product</h1>

<form method="post">

    <p class="my-3">Are you sure?</p>

    <button class="btn btn-outline-primary btn-sm">Delete</button>

    <a href="/product.php?id=<?= $product->id;?>" class="btn btn-outline-primary btn-sm ms-2">Cancel</a>

</form>
<?php require 'includes/footer.php'; ?>