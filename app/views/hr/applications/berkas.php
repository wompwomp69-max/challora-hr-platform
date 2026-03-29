<?php
// $app contains application row with cv_path, diploma_path, photo_path
$hasCv = !empty($app['cv_path'] ?? '');
$hasDiploma = !empty($app['diploma_path'] ?? '');
$hasPhoto = !empty($app['photo_path'] ?? '');
$hasAnyDocument = $hasCv || $hasDiploma || $hasPhoto;
?>
<div class="card">
    <div class="card-body">
        <h1 class="card-title h4">Berkas Pelamar</h1>
        <a href="<?= BASE_URL ?>/hr/jobs/applicants?id=<?= (int)($app['job_id'] ?? 0) ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        <hr>
        <?php if (empty($app)): ?>
            <div class="alert alert-warning mb-0">Data lamaran tidak ditemukan.</div>
        <?php elseif (!$hasAnyDocument): ?>
            <div class="alert alert-info mb-0">Pelamar belum melengkapi berkas.</div>
        <?php endif; ?>
        <div class="mb-4">
            <?php if ($hasCv): ?>
                <h5>CV</h5>
                <iframe src="<?= BASE_URL ?>/index.php?url=download/file&id=<?= (int)$app['id'] ?>&type=cv" width="100%" height="600" frameborder="0"></iframe>
                <p class="mt-1"><a href="<?= BASE_URL ?>/index.php?url=download/file&id=<?= (int)$app['id'] ?>&type=cv" class="btn btn-sm btn-outline-secondary">Download CV</a></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <?php if ($hasDiploma): ?>
                <h5>Ijazah</h5>
                <iframe src="<?= BASE_URL ?>/index.php?url=download/file&id=<?= (int)$app['id'] ?>&type=diploma" width="100%" height="600" frameborder="0"></iframe>
                <p class="mt-1"><a href="<?= BASE_URL ?>/index.php?url=download/file&id=<?= (int)$app['id'] ?>&type=diploma" class="btn btn-sm btn-outline-secondary">Download Ijazah</a></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <?php if ($hasPhoto): ?>
                <h5>Pas Foto</h5>
                <img src="<?= BASE_URL ?>/index.php?url=download/file&id=<?= (int)$app['id'] ?>&type=photo" alt="Pas foto" class="img-fluid" />
            <?php endif; ?>
        </div>
    </div>
</div>
