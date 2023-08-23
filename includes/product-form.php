<?php

$productID = isset($product->id) ? $product->id : null;

$cancelURL = $productID ? "/product.php?id=$productID" : "/home.php";

$button = $productID ? "Update" : "Add";

?>

<form method="post">

    <div class="form-floating my-3">
        <input name="name" id="name" value="<?= htmlspecialchars($product->name); ?>" class="form-control" placeholder="s" required>
        <label for="name" class="form-label">Name</label>
    </div>

    <div class="form-floating mb-3">
        <input name="price" id="price" value="<?= htmlspecialchars($product->price); ?>" class="form-control" placeholder="s" required>
        <label for="price" class="form-label">Price</label>
    </div>

    <fieldset>
        <legend>Categories</legend>

        <?php foreach ($categories as $category): ?>
            <div class="form-check">
                <input type="radio" name="category" value="<?= $category['id']; ?>" 
                    id="category<?= $category['id'] ?>" class="form-check-input"
                    <?php if (in_array($category['id'], $category_ids)) :?>checked<?php endif; ?> required >
                <label for="category<?= $category['id'] ?>" class="form-check-label"><?= htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>

    <button class="btn btn-outline-primary btn-sm my-3"><?= $button ?></button>
    <a href="<?= $cancelURL; ?>" class="btn btn-outline-primary btn-sm ms-2">Cancel</a>

</form>