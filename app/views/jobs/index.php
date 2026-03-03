<h1>Daftar Lowongan</h1>
<?php if (empty($jobs)): ?>
    <div class="card">Belum ada lowongan.</div>
<?php else: ?>
    <?php foreach ($jobs as $j): ?>
        <div class="card">
            <h3 style="margin-top: 0;"><a href="<?= BASE_URL ?>/jobs/show?id=<?= (int)$j['id'] ?>"><?= e($j['title']) ?></a></h3>
            <p><?= e(mb_substr($j['description'], 0, 200)) ?><?= mb_strlen($j['description']) > 200 ? '…' : '' ?></p>
            <p><small>Lokasi: <?= e($j['location'] ?? '-') ?> | Gaji: <?= e($j['salary_range'] ?? '-') ?></small></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
