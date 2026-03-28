<h1 class="text-2xl md:text-3xl font-semibold mb-4 text-center">CHALLORA RECRUITMENT</h1>

<form method="get" action="<?= BASE_URL ?>/jobs" class="mb-4">
    <div class="sem-bg-muted rounded-3xl px-4 py-3 md:py-4 flex flex-col gap-3">
        <div class="flex flex-col md:flex-row md:items-center gap-3">
            <div class="flex-1">
                <div class="flex items-center sem-bg-surface sem-text-default rounded-full px-4 py-2 shadow-sm border sem-border-primary">
                    <input
                        type="text"
                        name="q"
                        class="flex-1 bg-transparent border-none focus:outline-none text-sm sem-text-default placeholder:text-muted"
                        placeholder="Cari Judul"
                        value="<?= e($searchParams['q'] ?? '') ?>"
                    >
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center sem-bg-surface sem-text-default rounded-full px-4 py-2 shadow-sm border sem-border-primary">
                    <input
                        type="text"
                        name="location"
                        class="flex-1 bg-transparent border-none focus:outline-none text-sm sem-text-default placeholder:text-muted"
                        placeholder="Kota / Provinsi"
                        value="<?= e($searchParams['location'] ?? '') ?>"
                    >
                </div>
            </div>
            <div class="flex flex-row gap-2 md:w-auto md:justify-end items-center">
                <button
                    type="button"
                    id="toggle-filters"
                    class="px-4 md:px-5 py-2 rounded-full text-sm font-semibold sem-bg-primary sem-text-on-primary shadow-sm sem-bg-primary-hover transition"
                >
                    Filter
                </button>
                <button
                    type="submit"
                    class="px-4 md:px-5 py-2 rounded-full text-sm font-semibold sem-bg-primary sem-text-on-primary shadow-sm sem-bg-primary-hover transition"
                >
                    Cari
                </button>
                <a
                    href="<?= BASE_URL ?>/jobs"
                    class="text-xs sem-text-muted sem-hover-text-default underline-offset-2 hover:underline ml-1"
                >
                    Reset
                </a>
            </div>
        </div>
        <input type="hidden" name="per_page" value="<?= (int)($perPage ?? 20) ?>">
        <input type="hidden" name="job_view" value="<?= e($jobView ?? 'all') ?>">
        <?php
        $hasAdvancedFilters = !empty($searchParams['job_type'] ?? '')
            || !empty($searchParams['min_salary'] ?? '')
            || !empty($searchParams['max_salary'] ?? '')
            || !empty($searchParams['min_education'] ?? '')
            || !empty($searchParams['experience_level'] ?? '')
            || !empty($searchParams['updated'] ?? '');
        ?>
        <div
            id="advanced-filters"
            class="<?= $hasAdvancedFilters ? '' : 'hidden' ?> mt-3 border-t sem-border-muted pt-3 space-y-3 text-sm"
        >
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Jenis Pekerjaan</label>
                <select name="job_type" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand">
                    <option value="">Semua</option>
                    <?php
                    $jobTypeOptions = [
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'freelance' => 'Freelance',
                        'volunteer' => 'Volunteer',
                        'internship' => 'Internship / Magang',
                        'remote' => 'Remote',
                        'hybrid' => 'Hybrid',
                        'onsite' => 'On-site',
                    ];
                    foreach ($jobTypeOptions as $k => $v): ?>
                    <option value="<?= e($k) ?>" <?= ($searchParams['job_type'] ?? '') === $k ? 'selected' : '' ?>><?= e($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Gaji Min (jt)</label>
                <input type="number" name="min_salary" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand" placeholder="Min" min="0" value="<?= e($searchParams['min_salary'] ?? '') ?>">
            </div>
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Gaji Max (jt)</label>
                <input type="number" name="max_salary" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand" placeholder="Max" min="0" value="<?= e($searchParams['max_salary'] ?? '') ?>">
            </div>
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Pendidikan Minimal</label>
                <select name="min_education" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand">
                    <option value="">Semua</option>
                    <?php
                    $educations = ['sma' => 'SMA', 'd3' => 'D3', 's1' => 'S1', 's2' => 'S2', 's3' => 'S3'];
                    foreach ($educations as $k => $v): ?>
                    <option value="<?= e($k) ?>" <?= ($searchParams['min_education'] ?? '') === $k ? 'selected' : '' ?>><?= e($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Pengalaman</label>
                <select name="experience_level" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand">
                    <option value="">Semua</option>
                    <?php
                    $expOptions = [
                        'none' => 'Tidak berpengalaman',
                        'fresh_grad' => 'Fresh Graduate',
                        'lt_1' => 'Kurang dari setahun',
                        'y_1_3' => '1-3 tahun',
                        'y_3_5' => '3–5 tahun',
                        'y_5_10' => '5–10 tahun',
                        'gt_10' => 'Lebih dari 10 tahun',
                    ];
                    foreach ($expOptions as $k => $v): ?>
                    <option value="<?= e($k) ?>" <?= ($searchParams['experience_level'] ?? '') === $k ? 'selected' : '' ?>><?= e($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium sem-text-muted mb-1">Terakhir diperbarui</label>
                <select name="updated" class="w-full rounded-lg border sem-border-default px-2 py-1.5 text-sm sem-focus-brand">
                    <option value="">Kapan pun</option>
                    <option value="month" <?= ($searchParams['updated'] ?? '') === 'month' ? 'selected' : '' ?>>Sebulan terakhir</option>
                    <option value="week" <?= ($searchParams['updated'] ?? '') === 'week' ? 'selected' : '' ?>>Seminggu terakhir</option>
                    <option value="day" <?= ($searchParams['updated'] ?? '') === 'day' ? 'selected' : '' ?>>24 jam terakhir</option>
                </select>
            </div>
        </div>
        </div>
    </div>
</form>

<?php
$jobView = $jobView ?? 'all';
?>
<div class="flex justify-center mb-4">
    <div class="inline-flex items-center sem-bg-muted rounded-full px-2 py-1 text-xs sem-text-muted">
        <?php
        $viewOptions = [
            'all' => 'Semua Pekerjaan',
            'saved' => 'Tersimpan',
            'applied' => 'Telah Dilamar',
        ];
        foreach ($viewOptions as $key => $label):
            $isActive = $jobView === $key;
            $query = array_filter(array_merge($searchParams ?? [], ['job_view' => $key, 'per_page' => $perPage ?? 20]));
        ?>
        <a
            href="<?= BASE_URL ?>/jobs?<?= http_build_query($query) ?>"
            class="px-3 py-1 rounded-full transition <?= $isActive ? 'bg-primary sem-text-on-primary font-semibold' : 'sem-text-muted sem-hover-text-default' ?>"
        >
            <?= e($label) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('toggle-filters');
    var box = document.getElementById('advanced-filters');
    if (!btn || !box) return;
    btn.addEventListener('click', function () {
        box.classList.toggle('hidden');
    });
});
</script>

<?php if (empty($jobs)): ?>
    <div class="sem-bg-surface rounded-2xl shadow-sm p-6 text-center sem-text-muted text-sm">Belum ada lowongan.</div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php foreach ($jobs as $j): ?>
            <?php
            $applied = in_array((int)$j['id'], $appliedJobIds ?? [], true);
            $saved = in_array((int)$j['id'], $savedJobIds ?? [], true);
            $qs = array_filter(array_merge($searchParams ?? [], ['page' => $page ?? 1, 'per_page' => $perPage ?? 20, 'job_view' => $jobView ?? 'all']));
            $redirectBack = '/jobs' . (empty($qs) ? '' : '?' . http_build_query($qs));
            ?>
            <div class="cursor-pointer" onclick="window.location='<?= e(BASE_URL) ?>/jobs/show?id=<?= (int)$j['id'] ?>'" role="button">
                <div class="h-full sem-bg-surface rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col border <?= ($applied || $saved) ? 'border-accent' : 'border-transparent' ?>">
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow flex flex-col gap-1">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h2 class="text-sm font-semibold sem-text-default leading-snug flex-1"><?= e($j['title']) ?></h2>
                                <div class="flex flex-wrap gap-1 justify-end text-[10px]">
                                    <?php if (!empty($j['is_urgent'])): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-danger-soft text-danger font-medium">Urgent</span><?php endif; ?>
                                    <?php if ($applied): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-info-soft text-info font-medium">Sudah dilamar</span><?php endif; ?>
                                    <?php if ($saved): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-success-soft text-success font-medium">Tersimpan</span><?php endif; ?>
                                </div>
                            </div>
                            <p class="text-xs sem-text-muted mb-1 line-clamp-2 min-h-[2.5rem]"><?= e(!empty($j['short_description']) ? $j['short_description'] : mb_substr($j['description'], 0, 120) . (mb_strlen($j['description']) > 120 ? '…' : '')) ?></p>
                            <p class="text-[11px] sem-text-muted mb-0">Lokasi: <?= e($j['location'] ?? '-') ?> | Gaji: <?= e($j['salary_range'] ?? '-') ?></p>
                            <?php
                            $jobSkills = !empty($j['skills_json']) ? json_decode($j['skills_json'], true) : [];
                            $jobBenefits = !empty($j['benefits_json']) ? json_decode($j['benefits_json'], true) : [];
                            ?>
                            <div class="flex items-center justify-between gap-2 mt-2" onclick="event.stopPropagation()">
                                <p class="text-[11px] sem-text-muted mb-0 flex-1">
                                    <?php if (!empty($jobSkills) || !empty($jobBenefits)): ?>
                                    <?php if (!empty($jobSkills)): foreach (array_slice($jobSkills, 0, 5) as $s): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full sem-bg-muted sem-text-default mr-1 mb-1"><?= e($s) ?></span><?php endforeach; ?><?php if (count($jobSkills) > 5): ?>…<?php endif; ?><?php endif; ?>
                                    <?php if (!empty($jobBenefits)): foreach (array_slice($jobBenefits, 0, 3) as $b): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-sky-soft text-sky mr-1 mb-1"><?= e($b) ?></span><?php endforeach; ?><?php if (count($jobBenefits) > 3): ?>…<?php endif; ?><?php endif; ?>
                                    <?php else: ?><span class="sem-text-muted">—</span><?php endif; ?>
                                </p>
                                <?php if (currentRole() === 'user'): ?>
                                <div class="flex-shrink-0 pl-2">
                                    <?php if ($saved): ?>
                                    <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="d-inline">
                                        <input type="hidden" name="job_id" value="<?= (int)$j['id'] ?>">
                                        <input type="hidden" name="redirect" value="<?= e($redirectBack) ?>">
                                        <button type="submit" class="p-1 text-accent hover:text-primary" title="Hapus dari simpan">
                                            <i class="bi bi-bookmark-fill text-lg"></i>
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <form method="post" action="<?= BASE_URL ?>/jobs/save" class="d-inline">
                                        <input type="hidden" name="job_id" value="<?= (int)$j['id'] ?>">
                                        <input type="hidden" name="redirect" value="<?= e($redirectBack) ?>">
                                        <button type="submit" class="p-1 text-accent sem-hover-text-primary" title="Simpan">
                                            <i class="bi bi-bookmark text-lg"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (($totalPages ?? 1) > 1 || ($totalJobs ?? 0) > 0): ?>
    <div class="flex flex-col items-center gap-3 mt-4">
        <div class="flex items-center gap-2 text-xs sem-text-muted">
            <span>Tampilkan:</span>
            <form method="get" action="<?= BASE_URL ?>/jobs" class="inline-block" id="per-page-form">
                <?php foreach ($searchParams ?? [] as $k => $v): if ($v !== ''): ?>
                <input type="hidden" name="<?= e($k) ?>" value="<?= e($v) ?>">
                <?php endif; endforeach; ?>
                <input type="hidden" name="job_view" value="<?= e($jobView ?? 'all') ?>">
                <input type="hidden" name="page" value="1">
                <select name="per_page" class="border sem-border-default rounded-md px-2 py-1 text-xs sem-focus-brand" onchange="this.form.submit()">
                    <option value="20" <?= ($perPage ?? 20) == 20 ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= ($perPage ?? 20) == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($perPage ?? 20) == 100 ? 'selected' : '' ?>>100</option>
                </select>
            </form>
        </div>
        <nav>
            <ul class="inline-flex items-center gap-1 text-xs">
                <?php
                $curPage = (int)($page ?? 1);
                $tp = (int)($totalPages ?? 1);
                $baseQ = array_merge(array_filter($searchParams ?? []), ['per_page' => $perPage ?? 20, 'job_view' => $jobView ?? 'all']);
                ?>
                <li class="<?= $curPage <= 1 ? 'opacity-40 pointer-events-none' : '' ?>">
                    <a class="px-2 py-1 rounded border sem-border-default sem-hover-bg-muted" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => $curPage - 1]) ?>">«</a>
                </li>
                <?php for ($i = 1; $i <= $tp; $i++): ?>
                <li>
                    <a class="px-2 py-1 rounded border <?= $i === $curPage ? 'sem-bg-primary sem-text-on-primary sem-border-primary' : 'sem-border-default sem-hover-bg-muted' ?>" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => $i]) ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <li class="<?= $curPage >= $tp ? 'opacity-40 pointer-events-none' : '' ?>">
                    <a class="px-2 py-1 rounded border sem-border-default sem-hover-bg-muted" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => min($curPage + 1, $tp)]) ?>">»</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
<?php endif; ?>
