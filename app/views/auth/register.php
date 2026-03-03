<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="card-title h4 mb-4">Daftar (Kandidat)</h1>
        <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/register">
            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?= e($old['name']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?= e($old['email']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">No. HP</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= e($old['phone']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= e($old['address']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password (min. 6 karakter)</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="6">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password_confirm">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
            </div>
            <?php if (!empty($error)): ?><p class="text-danger"><?= e($error) ?></p><?php endif; ?>
            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="btn btn-primary">Daftar</button>
                <a href="<?= BASE_URL ?>/auth/login">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</div>
