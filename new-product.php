<?php

require 'classes/Database.php';
require 'classes/Product.php';
require 'classes/Category.php';
require 'includes/url.php';

session_start();

$db = new Database();
$conn = $db->getConn();

$product = new Product();

$category_ids = [];

$categories = Category::getAll($conn);




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    

    $product->name = $_POST['name'];
    $product->price = $_POST['price'];

    if( isset($_SESSION['username'])){
        $product->added_by = $_SESSION['username'];
    }else {
        echo 'Please login';
        redirect("/login.php");
    }
    
    $category_ids = $_POST['category'];

    if ($product->create($conn)) {

        $product->setCategory($conn, $category_ids);

        redirect("/product.php?id={$product->id}");

    }   
}

?>
<?php require 'includes/header.php'; ?>

<h2>New Product</h2>

<?php require 'includes/product-form.php'; ?>

<?php require 'includes/footer.php'; ?>
