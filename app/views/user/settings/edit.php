<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="card-title h4 mb-4">Edit Profil</h1>
        <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/edit">
            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?= e($user['name']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">No. HP</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= e($user['phone'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= e($user['address'] ?? '') ?></textarea>
            </div>
            <?php if (!empty($error)): ?><p class="text-danger"><?= e($error) ?></p><?php endif; ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= BASE_URL ?>/user/settings" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
