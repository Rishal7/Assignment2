<?php

require 'classes/Database.php';
require 'classes/Product.php';
require 'classes/Category.php';
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

$category_ids = array_column($product->getCategories($conn), 'id');



$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product->name = $_POST['name'];
    $product->price = $_POST['price'];

    $category_ids = $_POST['category'];
    

    if ($product->update($conn)) {

        $product->updateCategory($conn, $category_ids);

        redirect("/product.php?id={$product->id}");
    
    } else {
        echo "failed";
    }

}

?>
<?php require 'includes/header.php'; ?>

<h1>Edit Product</h1>

<?php require 'includes/product-form.php'; ?>

<?php require 'includes/footer.php'; ?>