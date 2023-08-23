<form method="post" id="formArticle">

    <div class="form-floating my-3">
        <input name="username" id="username" required value="<?= htmlspecialchars($user->username); ?>"
            class="form-control" placeholder="s">
        <label for="username">Username</label>
    </div>

    <div class="form-floating mb-3">
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($user->email); ?>"
            class="form-control" placeholder="s">
        <label for="email">Email</label>
    </div>

    <div class="form-floating mb-3">
        <input name="phone" id="phone" required value="<?= htmlspecialchars($user->phone); ?>" class="form-control"
            placeholder="s">
        <label for="phone">Phone</label>
    </div>

    <?php if (!isset($_SESSION['is_logged_in'])): ?>
        <div class="form-floating mb-3">
            <input type="password" name="password" id="password" required value="<?= htmlspecialchars($user->password); ?>"
                class="form-control" placeholder="s">
            <label for="password">Password</label>
        </div>
    <?php endif; ?>

    <button class="btn btn-primary">Save</button>

</form>