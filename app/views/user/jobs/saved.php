<h1 class="text-2xl md:text-3xl font-semibold mb-4 text-center md:text-left">Lowongan Tersimpan</h1>
<p class="mb-3">
    <a href="<?= BASE_URL ?>/jobs" class="inline-flex items-center px-3 py-1.5 rounded-full border border-default text-xs text-muted hover:bg-muted">← Kembali ke daftar</a>
</p>

<?php if (empty($jobs)): ?>
    <div class="bg-surface rounded-2xl shadow-sm p-6 text-center text-muted text-sm">Belum ada lowongan tersimpan.</div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php foreach ($jobs as $j): ?>
            <?php $applied = in_array((int)$j['id'], $appliedJobIds ?? [], true); ?>
            <div class="cursor-pointer" onclick="window.location='<?= e(BASE_URL) ?>/jobs/show?id=<?= (int)$j['id'] ?>'" role="button">
                <div class="h-full bg-surface rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col border border-accent">
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow flex flex-col gap-1">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h2 class="text-sm font-semibold text-default leading-snug flex-1"><?= e($j['title']) ?></h2>
                                <div class="flex flex-wrap gap-1 justify-end text-[10px]">
                                    <?php if (!empty($j['is_urgent'])): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-danger-soft text-danger font-medium">Urgent</span><?php endif; ?>
                                    <?php if ($applied): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-info-soft text-info font-medium">Sudah dilamar</span><?php endif; ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-success-soft text-success font-medium">Tersimpan</span>
                                </div>
                            </div>
                            <p class="text-xs text-muted mb-1 line-clamp-2 min-h-[2.5rem]"><?= e(!empty($j['short_description']) ? $j['short_description'] : mb_substr($j['description'], 0, 120) . (mb_strlen($j['description']) > 120 ? '…' : '')) ?></p>
                            <p class="text-[11px] text-muted mb-0">Lokasi: <?= e($j['location'] ?? '-') ?> | Gaji: <?= e($j['salary_range'] ?? '-') ?></p>
                            <?php
                            $jobSkills = !empty($j['skills_json']) ? json_decode($j['skills_json'], true) : [];
                            $jobBenefits = !empty($j['benefits_json']) ? json_decode($j['benefits_json'], true) : [];
                            ?>
                            <div class="flex items-center justify-between gap-2 mt-2" onclick="event.stopPropagation()">
                                <p class="text-[11px] text-muted mb-0 flex-1">
                                    <?php if (!empty($jobSkills) || !empty($jobBenefits)): ?>
                                    <?php if (!empty($jobSkills)): foreach (array_slice($jobSkills, 0, 5) as $s): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-muted text-default mr-1 mb-1"><?= e($s) ?></span><?php endforeach; ?><?php if (count($jobSkills) > 5): ?>…<?php endif; ?><?php endif; ?>
                                    <?php if (!empty($jobBenefits)): foreach (array_slice($jobBenefits, 0, 3) as $b): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-sky-soft text-sky mr-1 mb-1"><?= e($b) ?></span><?php endforeach; ?><?php if (count($jobBenefits) > 3): ?>…<?php endif; ?><?php endif; ?>
                                    <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                                </p>
                                <div class="flex-shrink-0">
                                    <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="d-inline">
                                        <input type="hidden" name="job_id" value="<?= (int)$j['id'] ?>">
                                        <input type="hidden" name="redirect" value="/jobs/saved">
                                        <button type="submit" class="p-1 text-primary hover:text-primary" title="Hapus dari simpan"><i class="bi bi-bookmark-fill text-lg"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
