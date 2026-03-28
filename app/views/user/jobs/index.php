<?php
$jobView = $jobView ?? 'all';
$selectedType = (string) ($searchParams['job_type'] ?? '');
?>
<style>
.jobs-search{display:grid;grid-template-columns:1fr 1fr 1fr 160px;background:var(--color-secondary);border-radius:0;overflow:hidden;margin:-16px calc(var(--user-content-pad-x, 10vw) * -1) 20px;width:calc(100% + (var(--user-content-pad-x, 10vw) * 2));height:100px;padding:0 var(--user-bar-pad-x, 3.5vw);box-sizing:border-box;}
.jobs-search-seg{display:flex;align-items:center;gap:12px;padding:18px 20px;color:#f8fafc;border-right:1px solid rgba(255,255,255,.2);}
.jobs-search-seg input,.jobs-search-seg select{width:100%;background:transparent;border:0;color:#fff;font-size:16px;outline:none;}
.jobs-search-seg input::placeholder{color:#d6dce4;}
.jobs-search-btn{background:#fff;color:#011627;border:0;border-radius:0;font-size:28px;font-weight:500;}
.jobs-body{margin:0 calc(var(--user-content-pad-x, 10vw) * -1);padding:0 var(--user-bar-pad-x, 3.5vw);}
.jobs-layout{display:grid;grid-template-columns:180px 1fr;gap:18px;}
.jobs-filter{background:rgba(255,255,255,.42);padding:12px;border-radius:8px;align-self:start;position:sticky;top:12px;}
.jobs-filter-title{font-size:38px;font-weight:600;color:#111827;margin-bottom:10px;}
.jobs-filter-box{border:2px solid #2ea0ff;border-radius:4px;padding:8px;background:#fff;}
.jobs-card-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;}
.job-card{background:#fff;border:2px solid #032146;border-radius:28px;padding:14px;min-height:320px;display:flex;flex-direction:column;justify-content:space-around;}
.job-card-top{background:#fff2d6;border-radius:18px;padding:18px 16px 18px;min-height:230px;display:flex;flex-direction:column;}
.job-date{display:inline-block;background:#fff;border-radius:18px;padding:6px 12px;font-size:12px;font-weight:500;color:#000;}
.job-title{font-size:24px;line-height:1.12;font-weight:700;color:#000;margin-top:14px;}
.job-tags{display:flex;gap:8px;flex-wrap:wrap;margin-top:auto;}
.job-tag{font-size:12px;padding:3px 10px;border:2px solid #011627;border-radius:999px;background:#fff;color:#011627;font-weight:500;}
.job-card-bottom{padding:14px 4px 2px;display:flex;justify-content:space-between;align-items:flex-end;gap:10px;}
.job-salary{font-size:22px;font-weight:700;color:#000;line-height:1;}
.job-loc{font-size:14px;color:#737982;line-height:1.25;margin-top:6px;}
.job-detail-btn{background:#011627;color:#fff;border:0;padding:10px 18px;border-radius:999px;font-size:12px;font-weight:600;line-height:1;}
.job-bookmark{width:42px;height:42px;border-radius:16px;background:#fff;display:flex;align-items:center;justify-content:center;}
.job-bookmark i{font-size:20px;color:#011627;}
@media (max-width: 1300px){.jobs-card-grid{grid-template-columns:repeat(3,minmax(0,1fr));}}
@media (max-width: 1024px){.jobs-layout{grid-template-columns:1fr;}.jobs-filter{position:static;}.jobs-card-grid{grid-template-columns:repeat(2,minmax(0,1fr));}.jobs-search{grid-template-columns:1fr;}}
@media (max-width: 640px){.jobs-card-grid{grid-template-columns:1fr;}}
</style>

<form method="get" action="<?= BASE_URL ?>/jobs" class="jobs-search">
    <div class="jobs-search-seg">
        <i class="bi bi-search"></i>
        <input type="text" name="q" placeholder="Cari Pekerjaan" value="<?= e($searchParams['q'] ?? '') ?>">
    </div>
    <div class="jobs-search-seg">
        <i class="bi bi-geo-alt-fill"></i>
        <input type="text" name="location" placeholder="Cari Lokasi" value="<?= e($searchParams['location'] ?? '') ?>">
    </div>
    <div class="jobs-search-seg">
        <i class="bi bi-briefcase-fill"></i>
        <select name="experience_level">
            <option value="">Level Pengalaman</option>
            <option value="fresh_grad" <?= ($searchParams['experience_level'] ?? '') === 'fresh_grad' ? 'selected' : '' ?>>Fresh Graduate</option>
            <option value="y_1_3" <?= ($searchParams['experience_level'] ?? '') === 'y_1_3' ? 'selected' : '' ?>>1-3 Tahun</option>
            <option value="y_3_5" <?= ($searchParams['experience_level'] ?? '') === 'y_3_5' ? 'selected' : '' ?>>3-5 Tahun</option>
            <option value="y_5_10" <?= ($searchParams['experience_level'] ?? '') === 'y_5_10' ? 'selected' : '' ?>>5-10 Tahun</option>
        </select>
    </div>
    <button type="submit" class="jobs-search-btn hover:bg-primary-muted">Cari</button>
    <input type="hidden" name="per_page" value="<?= (int)($perPage ?? 20) ?>">
    <input type="hidden" name="job_view" value="<?= e($jobView) ?>">
</form>

<div class="jobs-body">
<div class="jobs-layout mt-10">
    <aside class="jobs-filter">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-sm fw-semibold">Filter Lainnya</span>
            <span>▼</span>
        </div>
        <form method="get" action="<?= BASE_URL ?>/jobs" class="jobs-filter-box">
            <small class="text-muted">Working schedule</small>
            <label class="d-flex align-items-center gap-2 mt-2"><input type="radio" name="job_type" value="full_time" <?= $selectedType === 'full_time' ? 'checked' : '' ?>> Full time</label>
            <label class="d-flex align-items-center gap-2 mt-1"><input type="radio" name="job_type" value="part_time" <?= $selectedType === 'part_time' ? 'checked' : '' ?>> Part time</label>
            <label class="d-flex align-items-center gap-2 mt-1"><input type="radio" name="job_type" value="internship" <?= $selectedType === 'internship' ? 'checked' : '' ?>> Internship</label>
            <label class="d-flex align-items-center gap-2 mt-1"><input type="radio" name="job_type" value="project" <?= $selectedType === 'project' ? 'checked' : '' ?>> Project work</label>
            <label class="d-flex align-items-center gap-2 mt-1"><input type="radio" name="job_type" value="volunteer" <?= $selectedType === 'volunteer' ? 'checked' : '' ?>> Volunteering</label>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-sm bg-accent text-secondary fw-semibold">Apply</button>
                <a href="<?= BASE_URL ?>/jobs" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
            <input type="hidden" name="q" value="<?= e($searchParams['q'] ?? '') ?>">
            <input type="hidden" name="location" value="<?= e($searchParams['location'] ?? '') ?>">
            <input type="hidden" name="experience_level" value="<?= e($searchParams['experience_level'] ?? '') ?>">
            <input type="hidden" name="per_page" value="<?= (int)($perPage ?? 20) ?>">
            <input type="hidden" name="job_view" value="<?= e($jobView) ?>">
        </form>
    </aside>
    <section>
        <h2 class="jobs-filter-title">Lowongan Tersedia</h2>
        <?php if (empty($jobs)): ?>
            <div class="bg-white rounded-4 p-4 text-muted">Belum ada lowongan.</div>
        <?php else: ?>
            <div class="jobs-card-grid mt-10">
                <?php
                $monthId = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
                ];
                ?>
                <?php foreach ($jobs as $j): ?>
                    <?php
                    $applied = in_array((int)$j['id'], $appliedJobIds ?? [], true);
                    $saved = in_array((int)$j['id'], $savedJobIds ?? [], true);
                    $qs = array_filter(array_merge($searchParams ?? [], ['page' => $page ?? 1, 'per_page' => $perPage ?? 20, 'job_view' => $jobView]));
                    $redirectBack = '/jobs' . (empty($qs) ? '' : '?' . http_build_query($qs));
                    $jobTypeLabel = ucwords(str_replace('_', ' ', (string)($j['job_type'] ?? 'Part Time')));
                    $expLevelRaw = (string) ($j['experience_level'] ?? '');
                    if (in_array($expLevelRaw, ['fresh_grad', 'none', 'lt_1'], true)) {
                        $expLevelLabel = 'Fresh-Graduate';
                    } elseif (in_array($expLevelRaw, ['y_1_3'], true)) {
                        $expLevelLabel = 'Junior';
                    } else {
                        $expLevelLabel = 'Senior';
                    }
                    $postedRaw = (string) (!empty($j['created_at']) ? $j['created_at'] : ($j['updated_at'] ?? ''));
                    $postedDate = '-';
                    if ($postedRaw !== '') {
                        $ts = strtotime($postedRaw);
                        if ($ts !== false) {
                            $postedDate = (string) ((int) date('d', $ts)) . ' ' . ($monthId[(int) date('n', $ts)] ?? date('M', $ts)) . ' ' . date('Y', $ts);
                        }
                    }
                    ?>
                    <div class="job-card">
                        <div class="job-card-top">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="job-date"><?= e($postedDate) ?></span>
                                <div class="job-bookmark" onclick="event.stopPropagation()">
                                    <?php if (currentRole() === 'user'): ?>
                                        <?php if ($saved): ?>
                                        <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="d-inline">
                                            <input type="hidden" name="job_id" value="<?= (int)$j['id'] ?>">
                                            <input type="hidden" name="redirect" value="<?= e($redirectBack) ?>">
                                            <button type="submit" class="border-0 bg-transparent p-0"><i class="bi bi-bookmark-fill"></i></button>
                                        </form>
                                        <?php else: ?>
                                        <form method="post" action="<?= BASE_URL ?>/jobs/save" class="d-inline">
                                            <input type="hidden" name="job_id" value="<?= (int)$j['id'] ?>">
                                            <input type="hidden" name="redirect" value="<?= e($redirectBack) ?>">
                                            <button type="submit" class="border-0 bg-transparent p-0"><i class="bi bi-bookmark"></i></button>
                                        </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>/jobs/show?id=<?= (int)$j['id'] ?>" class="text-decoration-none">
                                <div class="job-title"><?= e($j['title']) ?></div>
                            </a>
                            <div class="job-tags">
                                <span class="job-tag"><?= e($jobTypeLabel) ?></span>
                                <span class="job-tag"><?= e($expLevelLabel) ?></span>
                                <span class="job-tag">Remote</span>
                                <?php if ($applied): ?><span class="job-tag">Applied</span><?php endif; ?>
                            </div>
                        </div>
                        <div class="job-card-bottom">
                            <div>
                                <div class="job-salary"><?= e($j['salary_range'] ?? '-') ?></div>
                                <div class="job-loc"><?= e($j['location'] ?? '-') ?></div>
                            </div>
                            <a href="<?= BASE_URL ?>/jobs/show?id=<?= (int)$j['id'] ?>" class="job-detail-btn text-decoration-none">Detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (($totalPages ?? 1) > 1): ?>
        <nav class="mt-3">
            <ul class="inline-flex items-center gap-1 text-xs">
                <?php
                $curPage = (int)($page ?? 1);
                $tp = (int)($totalPages ?? 1);
                $baseQ = array_merge(array_filter($searchParams ?? []), ['per_page' => $perPage ?? 20, 'job_view' => $jobView]);
                ?>
                <li class="<?= $curPage <= 1 ? 'opacity-40 pointer-events-none' : '' ?>">
                    <a class="px-2 py-1 rounded border sem-border-default sem-hover-bg-muted" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => $curPage - 1]) ?>">«</a>
                </li>
                <?php for ($i = 1; $i <= $tp; $i++): ?>
                <li><a class="px-2 py-1 rounded border <?= $i === $curPage ? 'bg-accent text-primary sem-border-accent' : 'sem-border-default sem-hover-bg-muted' ?>" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => $i]) ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <li class="<?= $curPage >= $tp ? 'opacity-40 pointer-events-none' : '' ?>">
                    <a class="px-2 py-1 rounded border sem-border-default sem-hover-bg-muted" href="<?= BASE_URL ?>/jobs?<?= http_build_query($baseQ + ['page' => min($curPage + 1, $tp)]) ?>">»</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </section>
</div>
</div>
