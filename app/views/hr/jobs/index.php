<?php
$stats = $stats ?? ['total' => 0, 'accepted' => 0, 'rejected' => 0, 'pending' => 0];
$totalJobs        = (int) ($totalJobs ?? 0);
$totalApplicants  = (int) ($stats['total'] ?? 0);
$accepted         = (int) ($stats['accepted'] ?? 0);
$rejected         = (int) ($stats['rejected'] ?? 0);
$pending          = (int) ($stats['pending'] ?? 0);
$topRegions       = $topRegions ?? [];
$monthlyTrend     = $monthlyTrend ?? [];
$jobsByApplicants = $jobsByApplicants ?? [];
$sortApplicants   = $sortApplicants ?? 'desc';

$hiringRate          = $totalApplicants > 0 ? (int) round(($accepted / $totalApplicants) * 100) : 0;
$callbackRate        = $totalApplicants > 0 ? (int) round((($pending + $accepted) / $totalApplicants) * 100) : 0;
$offerAcceptanceRate = ($accepted + $rejected) > 0 ? (int) round(($accepted / ($accepted + $rejected)) * 100) : 0;

$trendLabels = $trendTotal = $trendAccepted = [];
foreach ($monthlyTrend as $m) {
    $trendLabels[]   = $m['month_label'];
    $trendTotal[]    = (int) $m['total'];
    $trendAccepted[] = (int) $m['accepted'];
}

$jobTypeLabels = ['full_time' => 'Full Time', 'part_time' => 'Part Time', 'freelance' => 'Freelance', 'volunteer' => 'Volunteer', 'internship' => 'Internship'];
?>
<style>
:root {
    --db-bg:        var(--color-primary-muted);
    --db-card:      var(--color-secondary-muted);
    --db-card-2:    var(--color-secondary);
    --db-border:    var(--color-border);
    --db-border2:   var(--color-primary-hover);
    --db-text:      var(--color-text);
    --db-muted:     var(--color-text-muted);
    --db-dim:       var(--gray-600);
    --db-accent:    var(--color-accent);
    --db-acc-hov:   var(--color-accent-hover);
    --db-acc-muted: var(--color-accent-muted);
    --db-on-acc:    var(--color-on-accent);
    --db-green:     #4ade80;
    --db-green-bg:  rgba(74,222,128,0.07);
    --db-red:       #f87171;
    --db-red-bg:    rgba(248,113,113,0.07);
    --db-amber:     #fbbf24;
    --db-amber-bg:  rgba(251,191,36,0.07);
}

.db-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 20px; }
.db-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; }
.db-full   { margin-bottom: 20px; }

.db-card { background: var(--db-card); border: 1px solid var(--db-border); border-radius: var(--radius-md); overflow: hidden; }
.db-card-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px 0; }
.db-card-title  { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; color: var(--db-dim); }
.db-card-body   { padding: 12px 16px 16px; }

.kpi-card {
    background: var(--db-card); border: 1px solid var(--db-border);
    border-radius: var(--radius-md); padding: 16px; position: relative; overflow: hidden;
    transition: border-color 0.2s, transform 0.2s;
}
.kpi-card::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--kpi-accent, var(--db-border)); }
.kpi-card:hover { border-color: var(--db-card-2); transform: translateY(-1px); }
.kpi-card-label { font-size: 11px; font-weight: 600; color: var(--db-dim); text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 8px; }
.kpi-card-value { font-size: 40px; font-weight: 700; color: var(--db-text); line-height: 1; letter-spacing: -1.5px; }
.kpi-card-sub   { font-size: 11px; color: var(--db-dim); margin-top: 6px; }
.kpi-card-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 20px; margin-top: 6px; }

.section-link { font-size: 12px; color: var(--db-dim); text-decoration: none; display: flex; align-items: center; gap: 4px; transition: color 0.15s; }
.section-link:hover { color: var(--db-accent); }

.funnel-row { display: grid; grid-template-columns: repeat(3,1fr); }
.funnel-item { padding: 16px; border-right: 1px solid var(--db-border); }
.funnel-item:last-child { border-right: none; }
.funnel-num   { font-size: 48px; font-weight: 700; color: var(--db-text); line-height: 1; letter-spacing: -2px; }
.funnel-label { font-size: 13px; font-weight: 600; color: var(--db-muted); margin-top: 4px; }
.funnel-pct   { font-size: 11px; color: var(--db-dim); margin-top: 2px; }

.chart-wrap { position: relative; height: 200px; }

.donut-wrap { display: flex; align-items: center; gap: 20px; padding: 8px 0; }
.donut-legend { flex: 1; }
.donut-legend-item { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-size: 12px; }
.donut-legend-dot   { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.donut-legend-label { color: var(--db-muted); }
.donut-legend-value { margin-left: auto; font-weight: 700; color: var(--db-text); }

.rank-table { width: 100%; border-collapse: collapse; }
.rank-table thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--db-dim); padding: 8px 12px; border-bottom: 1px solid var(--db-border2); text-align: left; }
.rank-table thead th.num { text-align: right; }
.rank-table tbody tr { border-bottom: 1px solid var(--db-border2); transition: background 0.15s; }
.rank-table tbody tr:hover { background: var(--db-card-2); }
.rank-table tbody tr:last-child { border-bottom: none; }
.rank-table tbody td { padding: 10px 12px; font-size: 13px; color: var(--db-muted); vertical-align: middle; }
.rank-table tbody td.title { color: var(--db-text); font-weight: 500; }
.rank-table tbody td.num { text-align: right; font-weight: 700; color: var(--db-text); font-size: 15px; }
.rank-table .tag { display: inline-flex; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background: var(--db-acc-muted); color: var(--db-accent); border: 1px solid rgba(255,69,0,0.2); }

.region-list { display: flex; flex-direction: column; gap: 8px; }
.region-item { display: flex; align-items: center; gap: 10px; }
.region-name { font-size: 13px; color: var(--db-muted); flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.region-bar-wrap { flex: 2; height: 6px; background: var(--db-border2); border-radius: 999px; overflow: hidden; }
.region-bar { height: 100%; background: linear-gradient(90deg, var(--db-accent), var(--db-acc-hov)); border-radius: 999px; transition: width 0.6s ease; }
.region-count { font-size: 13px; font-weight: 700; color: var(--db-text); width: 28px; text-align: right; flex-shrink: 0; }

.cta-strip {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--db-acc-muted);
    border: 1px solid rgba(255,69,0,0.15);
    border-radius: var(--radius-md); padding: 14px 20px; margin-bottom: 20px;
}
.cta-strip-text { font-size: 13px; color: var(--db-muted); }
.cta-strip-text strong { color: var(--db-text); }
.cta-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--radius-sm);
    font-size: 13px; font-weight: 600;
    text-decoration: none; cursor: pointer; border: none;
    transition: all 0.15s; font-family: var(--font-sans);
}
.cta-btn-primary { background: var(--db-accent); color: var(--db-on-acc); box-shadow: var(--shadow-sm); }
.cta-btn-primary:hover { background: var(--db-acc-hov); color: var(--db-on-acc); transform: translateY(-1px); }
.cta-btn-outline { background: transparent; color: var(--db-muted); border: 1px solid var(--db-border); }
.cta-btn-outline:hover { border-color: var(--db-card-2); color: var(--db-text); }

.see-more-row { text-align: center; margin-top: 10px; }
.see-more-btn {
    font-size: 12px; color: var(--db-dim); text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 14px; border-radius: var(--radius-sm);
    border: 1px solid var(--db-border2); transition: all 0.15s;
}
.see-more-btn:hover { border-color: var(--db-border); color: var(--db-muted); background: var(--db-card-2); }

@media (max-width: 1200px) { .db-grid-4 { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 768px)  { .db-grid-2, .db-grid-4 { grid-template-columns: 1fr; } }
</style>

<!-- ── CTA Strip ─────────────────────────────────────────── -->
<div class="cta-strip">
    <div class="cta-strip-text">
        <strong><?= $pending ?></strong> applicants awaiting review &nbsp;·&nbsp; <strong><?= $totalJobs ?></strong> active job postings
    </div>
    <div style="display:flex;gap:8px;align-items:center">
        <a href="<?= BASE_URL ?>/hr/applications" class="cta-btn cta-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            View Pending Applicants
        </a>
        <a href="<?= BASE_URL ?>/hr/jobs/create" class="cta-btn cta-btn-outline">+ Post a Job</a>
    </div>
</div>

<!-- ── KPI Cards ─────────────────────────────────────────── -->
<div class="db-grid-4">
    <div class="kpi-card" style="--kpi-accent:var(--color-accent)">
        <div class="kpi-card-label">Total Applicants</div>
        <div class="kpi-card-value"><?= $totalApplicants ?></div>
        <div class="kpi-card-sub"><?= $totalJobs ?> jobs posted</div>
        <span class="kpi-card-badge" style="background:var(--db-acc-muted);color:var(--db-accent);border:1px solid rgba(255,69,0,.2)">● Live</span>
    </div>
    <div class="kpi-card" style="--kpi-accent:#4ade80">
        <div class="kpi-card-label">Hired</div>
        <div class="kpi-card-value"><?= $accepted ?></div>
        <div class="kpi-card-sub">Hiring Rate: <?= $hiringRate ?>%</div>
        <span class="kpi-card-badge" style="background:var(--db-green-bg);color:var(--db-green);border:1px solid rgba(74,222,128,.2)">● Live</span>
    </div>
    <div class="kpi-card" style="--kpi-accent:#fbbf24">
        <div class="kpi-card-label">In Review</div>
        <div class="kpi-card-value"><?= $pending ?></div>
        <div class="kpi-card-sub">Callback Rate: <?= $callbackRate ?>%</div>
        <span class="kpi-card-badge" style="background:var(--db-amber-bg);color:var(--db-amber);border:1px solid rgba(251,191,36,.2)">● Live</span>
    </div>
    <div class="kpi-card" style="--kpi-accent:#f87171">
        <div class="kpi-card-label">Rejected</div>
        <div class="kpi-card-value"><?= $rejected ?></div>
        <div class="kpi-card-sub">Offer Acceptance: <?= $offerAcceptanceRate ?>%</div>
        <span class="kpi-card-badge" style="background:var(--db-red-bg);color:var(--db-red);border:1px solid rgba(248,113,113,.2)">● Live</span>
    </div>
</div>

<!-- ── Charts ────────────────────────────────────────────── -->
<div class="db-grid-2">
    <div class="db-card">
        <div class="db-card-header"><span class="db-card-title">Applicant Trend (6 Months)</span></div>
        <div class="db-card-body"><div class="chart-wrap"><canvas id="trendChart"></canvas></div></div>
    </div>
    <div class="db-card">
        <div class="db-card-header"><span class="db-card-title">Applicant Status</span></div>
        <div class="db-card-body">
            <div class="donut-wrap">
                <canvas id="donutChart" width="130" height="130" style="flex-shrink:0"></canvas>
                <div class="donut-legend">
                    <div class="donut-legend-item">
                        <div class="donut-legend-dot" style="background:var(--color-accent)"></div>
                        <span class="donut-legend-label">In Review</span>
                        <span class="donut-legend-value"><?= $pending ?></span>
                    </div>
                    <div class="donut-legend-item">
                        <div class="donut-legend-dot" style="background:#4ade80"></div>
                        <span class="donut-legend-label">Hired</span>
                        <span class="donut-legend-value"><?= $accepted ?></span>
                    </div>
                    <div class="donut-legend-item">
                        <div class="donut-legend-dot" style="background:#f87171"></div>
                        <span class="donut-legend-label">Rejected</span>
                        <span class="donut-legend-value"><?= $rejected ?></span>
                    </div>
                    <div class="donut-legend-item" style="margin-top:16px;padding-top:10px;border-top:1px solid var(--db-border2)">
                        <div class="donut-legend-dot" style="background:var(--color-accent)"></div>
                        <span class="donut-legend-label" style="color:var(--db-text);font-weight:600">Total</span>
                        <span class="donut-legend-value" style="color:var(--color-accent)"><?= $totalApplicants ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Funnel + Top Regions ──────────────────────────────── -->
<div class="db-grid-2">
    <div class="db-card">
        <div class="db-card-header"><span class="db-card-title">Recruiting Funnel</span></div>
        <div class="funnel-row">
            <div class="funnel-item">
                <div class="funnel-num"><?= $totalApplicants ?></div>
                <div class="funnel-label">Applications</div>
                <div class="funnel-pct">100%</div>
            </div>
            <div class="funnel-item">
                <div class="funnel-num"><?= $pending ?></div>
                <div class="funnel-label">Under Review</div>
                <div class="funnel-pct"><?= $totalApplicants > 0 ? (int)round(($pending/$totalApplicants)*100) : 0 ?>%</div>
            </div>
            <div class="funnel-item">
                <div class="funnel-num"><?= $accepted ?></div>
                <div class="funnel-label">Hired</div>
                <div class="funnel-pct"><?= $totalApplicants > 0 ? (int)round(($accepted/$totalApplicants)*100) : 0 ?>%</div>
            </div>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-header">
            <span class="db-card-title">Top Applicant Regions</span>
            <a href="<?= BASE_URL ?>/hr/applications" class="section-link">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="db-card-body">
            <?php if (empty($topRegions)): ?>
                <p style="font-size:13px;color:var(--db-dim);text-align:center;padding:20px 0">No regional data yet</p>
            <?php else: ?>
                <?php $maxR = max(array_column($topRegions,'total') ?: [1]); ?>
                <div class="region-list">
                    <?php foreach (array_slice($topRegions,0,5) as $r): ?>
                        <div class="region-item">
                            <span class="region-name" title="<?= e($r['region']) ?>"><?= e($r['region']) ?></span>
                            <div class="region-bar-wrap"><div class="region-bar" style="width:<?= $maxR>0?round(($r['total']/$maxR)*100):0 ?>%"></div></div>
                            <span class="region-count"><?= (int)$r['total'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($topRegions) > 5): ?>
                    <div class="see-more-row">
                        <a href="#" class="see-more-btn" id="toggleRegions">View <?= count($topRegions)-5 ?> more ↓</a>
                    </div>
                    <div id="moreRegions" style="display:none;margin-top:8px" class="region-list">
                        <?php foreach (array_slice($topRegions,5) as $r): ?>
                            <div class="region-item">
                                <span class="region-name" title="<?= e($r['region']) ?>"><?= e($r['region']) ?></span>
                                <div class="region-bar-wrap"><div class="region-bar" style="width:<?= $maxR>0?round(($r['total']/$maxR)*100):0 ?>%"></div></div>
                                <span class="region-count"><?= (int)$r['total'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── Jobs by Applicants ─────────────────────────────────→ -->
<div class="db-full">
    <div class="db-card">
        <div class="db-card-header" style="padding:14px 16px">
            <span class="db-card-title">Jobs by Applicant Count</span>
            <a href="<?= BASE_URL ?>/hr/jobs?sort_applicants=<?= $sortApplicants === 'desc' ? 'asc' : 'desc' ?>"
               style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:<?= $sortApplicants==='desc' ? 'var(--color-accent)' : 'var(--db-dim)' ?>;text-decoration:none">
                <?= $sortApplicants === 'desc' ? '↓ Most First' : '↑ Least First' ?>
            </a>
        </div>
        <table class="rank-table">
            <thead>
                <tr>
                    <th style="width:28px">#</th>
                    <th>Position</th>
                    <th>Type</th>
                    <th>Deadline</th>
                    <th class="num">Applicants</th>
                    <th class="num">Hired</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jobsByApplicants)): ?>
                    <tr><td colspan="6" style="text-align:center;color:var(--db-dim);padding:24px">No job postings yet</td></tr>
                <?php else: ?>
                    <?php foreach ($jobsByApplicants as $i => $jb): ?>
                        <?php
                        $dlLabel   = !empty($jb['deadline']) ? date('d M Y', strtotime($jb['deadline'])) : '—';
                        $typeLabel = $jobTypeLabels[$jb['job_type'] ?? ''] ?? ($jb['job_type'] ? ucfirst($jb['job_type']) : '—');
                        ?>
                        <tr>
                            <td style="color:var(--db-dim);font-weight:700;font-size:12px"><?= $i+1 ?></td>
                            <td class="title">
                                <?= e($jb['title']) ?>
                                <?php if (!empty($jb['location'])): ?><div style="font-size:11px;color:var(--db-dim);margin-top:1px"><?= e($jb['location']) ?></div><?php endif; ?>
                            </td>
                            <td><span class="tag"><?= e($typeLabel) ?></span></td>
                            <td style="font-size:12px"><?= e($dlLabel) ?></td>
                            <td class="num"><?= (int)$jb['applicant_count'] ?></td>
                            <td class="num" style="color:var(--db-green)"><?= (int)$jb['accepted_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function() {
    var style     = getComputedStyle(document.documentElement);
    var accent    = style.getPropertyValue('--color-accent').trim()          || '#ff4500';
    var surface   = style.getPropertyValue('--color-secondary-muted').trim() || '#151515';
    var border    = style.getPropertyValue('--color-primary-hover').trim()   || '#2a2a2a';
    var textMuted = style.getPropertyValue('--color-text-muted').trim()      || '#9ca3af';

    var trendLabels   = <?= json_encode($trendLabels) ?>;
    var trendTotal    = <?= json_encode($trendTotal) ?>;
    var trendAccepted = <?= json_encode($trendAccepted) ?>;
    var donutData     = [<?= $pending ?>, <?= $accepted ?>, <?= $rejected ?>];

    Chart.defaults.font.family = style.getPropertyValue('--font-sans').trim() || 'sans-serif';
    Chart.defaults.color = textMuted;

    var trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels.length ? trendLabels : ['—'],
                datasets: [
                    { label: 'Total Applicants', data: trendTotal.length ? trendTotal : [0], borderColor: accent, backgroundColor: 'rgba(255,69,0,0.07)', borderWidth: 2, pointRadius: 3, pointBackgroundColor: accent, fill: true, tension: 0.4 },
                    { label: 'Hired', data: trendAccepted.length ? trendAccepted : [0], borderColor: '#4ade80', backgroundColor: 'rgba(74,222,128,0.06)', borderWidth: 2, pointRadius: 3, pointBackgroundColor: '#4ade80', fill: true, tension: 0.4 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, padding: 16, font: { size: 11 } } },
                    tooltip: { mode: 'index', intersect: false, backgroundColor: surface, borderColor: border, borderWidth: 1 }
                },
                scales: {
                    x: { grid: { color: border }, ticks: { font: { size: 11 } } },
                    y: { grid: { color: border }, ticks: { font: { size: 11 }, stepSize: 1, precision: 0 }, beginAtZero: true }
                }
            }
        });
    }

    var donutCtx = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: { datasets: [{ data: donutData, backgroundColor: [accent, '#4ade80', '#f87171'], borderColor: surface, borderWidth: 3, hoverOffset: 4 }] },
            options: { responsive: false, cutout: '72%', plugins: { legend: { display: false }, tooltip: { backgroundColor: surface, borderColor: border, borderWidth: 1 } } }
        });
    }

    var toggleBtn = document.getElementById('toggleRegions');
    var moreDiv   = document.getElementById('moreRegions');
    if (toggleBtn && moreDiv) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var open = moreDiv.style.display !== 'none';
            moreDiv.style.display = open ? 'none' : 'flex';
            moreDiv.style.flexDirection = 'column';
            toggleBtn.textContent = open ? 'View more ↓' : 'Collapse ↑';
        });
    }
})();
</script>
