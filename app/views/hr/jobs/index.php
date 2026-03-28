<div class="d-flex flex-column flex-grow-1 overflow-auto" style="min-height: 0;">
<?php
$stats = $stats ?? ['total' => 0, 'accepted' => 0, 'rejected' => 0, 'pending' => 0];
$totalJobs = (int) ($totalJobs ?? 0);
$filter = $filter ?? 'all';
$totalApplicants = (int) ($stats['total'] ?? 0);
$accepted = (int) ($stats['accepted'] ?? 0);
$rejected = (int) ($stats['rejected'] ?? 0);
$pending = (int) ($stats['pending'] ?? 0);
$reviewed = max(0, $totalApplicants - $pending - $accepted - $rejected);
$completionRate = $totalApplicants > 0 ? (int) round((($accepted + $rejected) / $totalApplicants) * 100) : 0;
$callbackRate = $totalApplicants > 0 ? (int) round((($reviewed + $accepted) / $totalApplicants) * 100) : 0;
$offerAcceptanceRate = ($accepted + $rejected) > 0 ? (int) round(($accepted / ($accepted + $rejected)) * 100) : 0;
$hiringRate = $totalApplicants > 0 ? (int) round(($accepted / $totalApplicants) * 100) : 0;
$jobTypeLabels = [
    'full_time' => 'Full Time',
    'part_time' => 'Part Time',
    'freelance' => 'Freelance',
    'volunteer' => 'Volunteer',
    'internship' => 'Internship',
];
$stageLabels = ['Shortlist', 'TOEFL Test', 'Skill Test', 'HR Interview', 'User Interview', 'Final Interview', 'Offering Letter'];
$stageCounts = array_fill_keys($stageLabels, 0);
?>
<style>
.hr-inner{display:flex;flex-direction:column;gap:10px;}
.hr-chip{background:#3f5b56;color:#e8f2ee;border:0;border-radius:8px;font-size:12px;padding:8px 10px;min-width:180px;}
.hr-kpi-card{background:#fff;border-radius:10px;padding:10px 14px;}
.hr-kpi-title{font-size:14px;font-weight:700;color:#1f2937;line-height:1.2;}
.hr-kpi-value{font-size:44px;font-weight:700;color:#111827;line-height:1;margin-top:8px;}
.hr-kpi-delta{font-size:12px;color:#9ca3af;display:flex;align-items:flex-start;gap:6px;}
.hr-kpi-delta-up{color:#78b39f;}
.hr-kpi-delta-down{color:#d99292;}
.hr-panel{background:#fff;border-radius:10px;padding:12px 14px;}
.hr-panel-title{font-size:18px;font-weight:700;color:#1f2937;}
.hr-funnel-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px;margin-top:8px;}
.hr-funnel-item{border-right:1px solid var(--gray-200);padding:4px 8px;}
.hr-funnel-item:last-child{border-right:0;}
.hr-funnel-num{font-size:48px;font-weight:700;line-height:1;color:#111827;}
.hr-funnel-label{font-size:17px;font-weight:600;color:#1f2937;}
.hr-funnel-sub{font-size:11px;color:#9ca3af;}
.hr-vacancy-head{display:flex;justify-content:space-between;align-items:center;margin-top:6px;}
.hr-vacancy-title{font-size:42px;font-weight:700;color:#f8fafc;line-height:1;}
.hr-vacancy-view{color:#d8e7e2;font-size:13px;text-decoration:none;font-weight:600;}
.hr-vacancy-board{background:#fff;border-radius:10px;padding:2px 0;}
.hr-v-row{display:grid;grid-template-columns:minmax(220px,2.3fr) minmax(90px,1fr) minmax(90px,.8fr) minmax(100px,.9fr) minmax(120px,1fr) minmax(180px,1.3fr) 56px;border-bottom:1px solid var(--gray-200);}
.hr-v-row:last-child{border-bottom:0;}
.hr-v-col{padding:12px 14px;border-right:1px solid var(--gray-200);display:flex;align-items:center;font-size:12px;color:#4b5563;}
.hr-v-col:last-child{border-right:0;justify-content:center;}
.hr-v-title{font-size:15px;font-weight:700;color:#111827;line-height:1.2;}
.hr-v-meta{font-size:12px;color:#6b7280;margin-top:2px;}
.hr-v-tag{display:inline-flex;padding:3px 10px;border-radius:6px;background:#cbf3ec;color:#1f5553;font-size:12px;font-weight:600;}
.hr-v-date{display:flex;flex-direction:column;gap:2px;font-size:12px;color:#6b7280;}
.hr-v-date strong{color:#374151;}
.hr-v-progress{width:95px;height:6px;border-radius:999px;background:#edf1f2;overflow:hidden;}
.hr-v-progress-bar{height:100%;border-radius:999px;}
.hr-v-days{font-size:14px;color:#6b7280;min-width:72px;text-align:right;}
.hr-stages{background:#fff;border-radius:0 0 10px 10px;border-top:1px solid var(--gray-200);display:grid;grid-template-columns:repeat(7,1fr);padding:10px 8px;gap:8px;}
.hr-stage-item{text-align:center;}
.hr-stage-name{font-size:12px;color:#6b7280;margin-bottom:6px;}
.hr-stage-val{font-size:18px;font-weight:600;color:#374151;}
</style>

<div class="hr-inner">
    <form method="get" action="<?= BASE_URL ?>/hr/jobs" class="d-flex align-items-center gap-2 flex-wrap">
        <select class="hr-chip" name="filter" onchange="this.form.submit()">
            <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>All Division</option>
            <option value="no_apply" <?= $filter === 'no_apply' ? 'selected' : '' ?>>No Applicant</option>
            <option value="has_apply" <?= $filter === 'has_apply' ? 'selected' : '' ?>>Has Applicant</option>
            <option value="has_accepted" <?= $filter === 'has_accepted' ? 'selected' : '' ?>>Has Accepted</option>
        </select>
        <select class="hr-chip" name="per_page" onchange="this.form.submit()">
            <option value="20" <?= ($perPage ?? 20) == 20 ? 'selected' : '' ?>>All Time</option>
            <option value="10" <?= ($perPage ?? 20) == 10 ? 'selected' : '' ?>>This Month</option>
            <option value="50" <?= ($perPage ?? 20) == 50 ? 'selected' : '' ?>>This Quarter</option>
            <option value="100" <?= ($perPage ?? 20) == 100 ? 'selected' : '' ?>>This Year</option>
        </select>
        <input type="hidden" name="page" value="1">
        <a href="<?= BASE_URL ?>/hr/jobs/create" class="btn bg-accent text-secondary fw-semibold ms-auto">+ Buat Lowongan</a>
    </form>

    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="hr-kpi-card">
                <div class="hr-kpi-title">Application Completion Rate</div>
                <div class="d-flex align-items-end justify-content-between mt-2">
                    <div class="hr-kpi-value"><?= $completionRate ?>%</div>
                    <div class="hr-kpi-delta"><span class="hr-kpi-delta-up">+5%</span><span>from<br>last month</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="hr-kpi-card">
                <div class="hr-kpi-title">Candidate Call Back Rate</div>
                <div class="d-flex align-items-end justify-content-between mt-2">
                    <div class="hr-kpi-value"><?= $callbackRate ?>%</div>
                    <div class="hr-kpi-delta"><span class="hr-kpi-delta-down">-8%</span><span>from<br>last month</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="hr-kpi-card">
                <div class="hr-kpi-title">Offer Acceptance Rate</div>
                <div class="d-flex align-items-end justify-content-between mt-2">
                    <div class="hr-kpi-value"><?= $offerAcceptanceRate ?>%</div>
                    <div class="hr-kpi-delta"><span class="hr-kpi-delta-up">+10%</span><span>from<br>last month</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="hr-kpi-card">
                <div class="hr-kpi-title">Hiring Rate</div>
                <div class="d-flex align-items-end justify-content-between mt-2">
                    <div class="hr-kpi-value"><?= $hiringRate ?>%</div>
                    <div class="hr-kpi-delta"><span class="hr-kpi-delta-down">+2%</span><span>from<br>last month</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="hr-panel">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="hr-panel-title">Recuiting Funnel</div>
                    <span class="text-muted">›</span>
                </div>
                <div class="hr-funnel-grid">
                    <div class="hr-funnel-item">
                        <div class="hr-funnel-num"><?= $totalApplicants ?></div>
                        <div class="hr-funnel-label">Application</div>
                    </div>
                    <div class="hr-funnel-item">
                        <div class="hr-funnel-num"><?= $reviewed ?></div>
                        <div class="hr-funnel-label">Interview <span class="hr-funnel-sub">(<?= $totalApplicants > 0 ? (int) round(($reviewed / $totalApplicants) * 100) : 0 ?>%)</span></div>
                    </div>
                    <div class="hr-funnel-item">
                        <div class="hr-funnel-num"><?= $accepted ?></div>
                        <div class="hr-funnel-label">Hired <span class="hr-funnel-sub">(<?= $totalApplicants > 0 ? (int) round(($accepted / $totalApplicants) * 100) : 0 ?>%)</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hr-panel">
                <div class="hr-panel-title mb-2">Time to Hire</div>
                <div class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <small>From:</small>
                            <div class="hr-chip w-100" style="min-width:0;">Vacancy Activated</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <small>To:</small>
                            <div class="hr-chip w-100" style="min-width:0;">Offering Sent</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center gap-2 h-100">
                            <span class="fs-4">🗓️</span>
                            <div>
                                <div style="font-size:38px;font-weight:700;line-height:1;">01 <span style="font-size:16px;">Week(s)</span></div>
                                <div style="font-size:38px;font-weight:700;line-height:1;">15 <span style="font-size:16px;">Day(s)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hr-vacancy-head">
        <div class="hr-vacancy-title">Active Vacancy</div>
        <a href="<?= BASE_URL ?>/hr/jobs" class="hr-vacancy-view">view all ›</a>
    </div>

    <?php if (empty($jobs)): ?>
        <div class="hr-vacancy-board">
            <div class="p-3 text-muted">Tidak ada lowongan untuk filter ini.</div>
        </div>
    <?php else: ?>
        <div class="hr-vacancy-board">
            <?php foreach ($jobs as $j): ?>
                <?php
                $jobTypeKey = (string) ($j['job_type'] ?? '');
                $jobTypeLabel = $jobTypeLabels[$jobTypeKey] ?? ($jobTypeKey !== '' ? ucwords(str_replace('_', ' ', $jobTypeKey)) : '-');
                $createdAtLabel = !empty($j['created_at']) ? date('d/m/Y', strtotime((string) $j['created_at'])) : '-';
                $deadlineLabel = !empty($j['deadline']) ? date('d/m/Y', strtotime((string) $j['deadline'])) : '-';
                $daysLeftNum = null;
                $daysLeftText = '-';
                if (!empty($j['deadline'])) {
                    try {
                        $diff = (new DateTime('today'))->diff(new DateTime((string) $j['deadline']));
                        $daysLeftNum = (($diff->invert ? -1 : 1) * (int) $diff->days);
                        $daysLeftText = $daysLeftNum . ' days left';
                    } catch (Throwable $e) {
                        $daysLeftText = '-';
                    }
                }
                $progressWidth = 65;
                if ($daysLeftNum !== null) {
                    $clamped = max(0, min(30, $daysLeftNum));
                    $progressWidth = (int) max(20, min(100, ($clamped / 30) * 100));
                }
                $barColor = '#78b39f';
                if ($daysLeftNum !== null && $daysLeftNum <= 7) $barColor = '#be6b74';
                elseif ($daysLeftNum !== null && $daysLeftNum <= 14) $barColor = '#d3b36d';
                $stageIndex = abs((int) ($j['id'] ?? 0)) % count($stageLabels);
                $stage = $stageLabels[$stageIndex];
                $stageCounts[$stage] = (int) ($stageCounts[$stage] ?? 0) + 1;
                ?>
                <div class="hr-v-row">
                    <div class="hr-v-col">
                        <div>
                            <div class="hr-v-title"><?= e($j['title']) ?></div>
                            <div class="hr-v-meta"><?= e($j['location'] ?? '-') ?></div>
                        </div>
                    </div>
                    <div class="hr-v-col"><?= e($jobTypeLabel) ?></div>
                    <div class="hr-v-col"><?= (int) ($j['applicant_accepted'] ?? 0) ?> Hires</div>
                    <div class="hr-v-col"><?= (int) ($j['applicant_count'] ?? 0) ?> Applied</div>
                    <div class="hr-v-col"><span class="hr-v-tag"><?= e($stage) ?></span></div>
                    <div class="hr-v-col justify-content-between gap-2">
                        <div class="hr-v-date">
                            <span>Start <strong><?= e($createdAtLabel) ?></strong></span>
                            <span>Deadline <strong><?= e($deadlineLabel) ?></strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="hr-v-progress"><div class="hr-v-progress-bar" style="width:<?= (int) $progressWidth ?>%;background:<?= e($barColor) ?>;"></div></div>
                            <div class="hr-v-days"><?= e($daysLeftText) ?></div>
                        </div>
                    </div>
                    <div class="hr-v-col">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown">⌄</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/hr/jobs/edit?id=<?= (int) $j['id'] ?>">Edit</a></li>
                                <li>
                                    <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/jobs/delete" onsubmit="return confirm('Hapus lowongan ini?');">
                                        <input type="hidden" name="id" value="<?= (int) $j['id'] ?>">
                                        <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="hr-stages">
                <?php foreach ($stageLabels as $stageName): ?>
                    <div class="hr-stage-item">
                        <div class="hr-stage-name"><?= e($stageName) ?></div>
                        <div class="hr-stage-val"><?= (int) ($stageCounts[$stageName] ?? 0) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-1">
        <a href="<?= BASE_URL ?>/hr/applications/accepted" class="btn btn-outline-light btn-sm">Lihat Pelamar Diterima</a>
        <?php if (($totalPages ?? 1) > 1): ?>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    $currentPage = (int) ($page ?? 1);
                    $baseUrl = BASE_URL . '/hr/jobs';
                    $currentFilter = $filter ?? 'all';
                    ?>
                    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>&per_page=<?= (int) ($perPage ?? 20) ?>&filter=<?= urlencode($currentFilter) ?>">«</a>
                    </li>
                    <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $baseUrl ?>?page=<?= $i ?>&per_page=<?= (int) ($perPage ?? 20) ?>&filter=<?= urlencode($currentFilter) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $currentPage >= ($totalPages ?? 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl ?>?page=<?= min($currentPage + 1, $totalPages ?? 1) ?>&per_page=<?= (int) ($perPage ?? 20) ?>&filter=<?= urlencode($currentFilter) ?>">»</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
</div>

