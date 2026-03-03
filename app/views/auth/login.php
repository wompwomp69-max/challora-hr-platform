<div class="card" style="max-width: 400px;">
    <h1>Login</h1>
    <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/login">
        <label>Email</label>
        <input type="email" name="email" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>">
        <label>Password</label>
        <input type="password" name="password" required autocomplete="current-password" value="<?= e($_POST['password'] ?? '') ?>">
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <p style="margin-top: 1rem;">
            <button type="submit" class="btn">Login</button>
            <a href="<?= BASE_URL ?>/auth/register">Belum punya akun? Daftar</a>
        </p>
    </form>
</div>