<div class="card" style="max-width: 480px;">
    <h1>Daftar (Kandidat)</h1>
    <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/register">
        <label>Nama</label>
        <input type="text" name="name" required value="<?= e($old['name']) ?>">
        <label>Email</label>
        <input type="email" name="email" required value="<?= e($old['email']) ?>">
        <label>No. HP</label>
        <input type="text" name="phone" value="<?= e($old['phone']) ?>">
        <label>Alamat</label>
        <textarea name="address"><?= e($old['address']) ?></textarea>
        <label>Password (min. 6 karakter)</label>
        <input type="password" name="password" required minlength="6">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirm" required>
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <p style="margin-top: 1rem;">
            <button type="submit" class="btn">Daftar</button>
            <a href="<?= BASE_URL ?>/auth/login">Sudah punya akun? Login</a>
        </p>
    </form>
</div>
