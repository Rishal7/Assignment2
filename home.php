<?php
require 'classes/Database.php';
require 'classes/Product.php';
require 'classes/Category.php';
require 'roles.php';

session_start();

$db = new Database();
$conn = $db->getConn();

$categories = Category::getAll($conn);

$selectedCategoryId = $_GET['category'] ?? null;

if ($selectedCategoryId) {

    $products = Product::getByCategory($conn, $selectedCategoryId);

} else {

    $products = Product::getAll($conn);

}
?>

<?php require 'includes/header.php'; ?>

<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']): ?>

    <div class="py-2">
        <a href="profile.php?id=<?= $_SESSION['userID']; ?>" class="btn btn-primary me-3">View Profile</a>
        <a href="logout.php" class="btn btn-primary">Log Out</a>
        
    </div>

    <h1 class="my-3">Welcome</h1>

    <?php if (empty($products)): ?>

        <p>No products found</p>

    <?php else: ?>

        <ul id="index">
            <!-- <a href="new-product.php" class="btn btn-outline-primary btn-sm my-1">Add new</a> -->

            <?php if ($_SESSION['role'] === 'admin' || $roleCapabilities[$_SESSION['role']]['add']): ?>
                <a href="new-product.php" class="btn btn-outline-primary btn-sm my-1">Add new</a>
            <?php endif; ?>

            <div class="row g-5 align-items-center">

                <div class="col-auto">
                    <h2 class="my-3">Products</h2>
                </div>

                <div class="col-auto ms-5">
                    <form method="get">
                        <div class="row g-3 align-items-center">

                            <select class="col-auto form-select form-select-sm" name="category" id="category"
                                onchange="this.form.submit();">

                                <option value="">All Products</option>

                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']); ?>"
                                        <?= $selectedCategoryId == $category['id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <?php foreach ($products as $product): ?>
                <li>
                    <article>
                        <h4>
                            <a href="product.php?id=<?= $product['id']; ?>" id="link">
                                <?= $product['name']; ?>
                            </a>
                        </h4>
                        <p>
                            Rs:
                            <?= $product['price']; ?>
                        </p>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

<?php else: ?>

    <p>You are not logged in.<a href="login.php" class="btn btn-primary ms-4">Log in</a></p>

<?php endif; ?>

<?php require 'includes/footer.php'; ?>