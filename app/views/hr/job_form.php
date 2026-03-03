<?php
$isEdit = !empty($job);
$action = $isEdit ? (BASE_URL . '/index.php?url=hr/jobs/edit&id=' . (int)$job['id']) : (BASE_URL . '/index.php?url=hr/jobs/create');
?>
<div class="card" style="max-width: 600px;">
    <h1><?= $isEdit ? 'Edit Lowongan' : 'Buat Lowongan' ?></h1>
    <form method="post" action="<?= e($action) ?>">
        <label>Judul</label>
        <input type="text" name="title" required value="<?= e($old['title']) ?>">
        <label>Deskripsi</label>
        <textarea name="description" required><?= e($old['description']) ?></textarea>
        <label>Lokasi</label>
        <input type="text" name="location" value="<?= e($old['location']) ?>">
        <label>Kisaran Gaji</label>
        <input type="text" name="salary_range" value="<?= e($old['salary_range']) ?>" placeholder="Contoh: 5-8 jt">
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <p style="margin-top: 1rem;">
            <button type="submit" class="btn"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?></button>
            <a href="<?= BASE_URL ?>/hr/jobs">Batal</a>
        </p>
    </form>
</div>
