<div class="card" style="max-width: 480px;">
    <h1>Edit Profil</h1>
    <form method="post" action="<?= BASE_URL ?>/index.php?url=user/profile/edit">
        <label>Nama</label>
        <input type="text" name="name" required value="<?= e($user['name']) ?>">
        <label>No. HP</label>
        <input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>">
        <label>Alamat</label>
        <textarea name="address"><?= e($user['address'] ?? '') ?></textarea>
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <p style="margin-top: 1rem;">
            <button type="submit" class="btn">Simpan</button>
            <a href="<?= BASE_URL ?>/user/profile">Batal</a>
        </p>
    </form>
</div>
