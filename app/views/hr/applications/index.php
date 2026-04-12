<?php
$maritalLabels = ['single' => 'Single', 'married' => 'Married', 'divorced' => 'Divorced', 'widowed' => 'Widowed'];
$achTypeLabels = ['kompetisi' => 'Competition', 'webinar_seminar' => 'Webinar/Seminar', 'workshop' => 'Workshop', 'pelatihan_kursus' => 'Training/Course', 'sertifikasi' => 'Certification', 'lainnya' => 'Others'];
$achLevelLabels = ['kota' => 'City', 'provinsi' => 'Province', 'nasional' => 'National', 'internasional' => 'International'];
$statusOptions = applicationStatusOptions();
?>
<style>
/* ── Applicants Index — design-tokens.css ───────────────── */
.ax-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.ax-title  { font-size: 20px; font-weight: 700; color: var(--color-text); letter-spacing: -0.4px; }
.ax-back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 600;
    text-decoration: none; color: var(--color-text-muted);
    border: 1px solid var(--color-border); background: transparent; transition: all 0.15s;
}
.ax-back-btn:hover { border-color: var(--color-secondary-hover); color: var(--color-text); }
.ax-back-btn svg { width: 14px; height: 14px; }

.ax-table-wrap { background: var(--color-secondary-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); overflow: hidden; }
.ax-table { width: 100%; border-collapse: collapse; }
.ax-table thead th {
    font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
    color: var(--gray-600); padding: 12px 14px; border-bottom: 1px solid var(--color-primary-hover);
    text-align: left; background: var(--color-primary-muted);
}
.ax-table tbody tr { border-bottom: 1px solid var(--color-primary-hover); transition: background 0.15s; }
.ax-table tbody tr:hover { background: var(--color-secondary); }
.ax-table tbody tr:last-child { border-bottom: none; }
.ax-table tbody td { padding: 12px 14px; font-size: 13px; color: var(--color-text-muted); vertical-align: middle; }

.ax-name { font-weight: 600; color: var(--color-text); }
.ax-status-badge { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; }
.ax-dl-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 10px; border-radius: var(--radius-sm); font-size: 11px; font-weight: 600;
    text-decoration: none; color: var(--color-text-muted);
    border: 1px solid var(--color-border); background: var(--color-secondary); transition: all 0.15s;
}
.ax-dl-btn:hover { border-color: var(--color-accent); color: var(--color-accent); }
.ax-dl-btn svg { width: 11px; height: 11px; }

.ax-select {
    background: var(--color-secondary); border: 1px solid var(--color-border);
    color: var(--color-text-muted); padding: 4px 8px; border-radius: var(--radius-sm);
    font-size: 11px; font-weight: 600; cursor: pointer; outline: none; font-family: var(--font-sans);
}
.ax-select:focus { border-color: var(--color-accent); }

.ax-btn-mini {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: 700;
    text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;
    border: 1px solid var(--color-accent); color: var(--color-accent); background: transparent; transition: all 0.15s;
}
.ax-btn-mini:hover { background: var(--color-accent); color: var(--color-on-accent); }

.ax-empty { text-align: center; padding: 60px 20px; background: var(--color-secondary-muted); border: 1px solid var(--color-border); border-radius: var(--radius-md); }
</style>

<div class="ax-header">
    <div>
        <div class="ax-title">Applicants: <?= e($job['title']) ?></div>
        <div style="font-size:12px;color:var(--gray-600);margin-top:2px"><?= !empty($job['location']) ? e($job['location']) : 'Remote' ?></div>
    </div>
    <div style="display:flex;gap:10px">
        <?php if (!empty($manualMailto ?? null)): ?>
            <a href="<?= e((string) $manualMailto) ?>" class="ax-btn-mini" style="border-color:var(--color-primary-hover);color:var(--color-text-muted)">Send Email Manually</a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/hr/jobs" class="ax-back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
            Dashboard
        </a>
    </div>
</div>

<?php if (empty($applicants)): ?>
    <div class="ax-empty">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="width:48px;height:48px;color:var(--color-border);margin-bottom:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <div style="font-size:14px;color:var(--gray-600)">No applicants for this position yet.</div>
    </div>
<?php else: ?>
    <div class="ax-table-wrap">
        <table class="ax-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Documents</th>
                    <th>Current Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $a): ?>
                    <tr>
                        <td class="ax-name"><?= e($a['name']) ?></td>
                        <td>
                            <div style="font-size:12px;color:var(--color-text-muted)"><?= !empty($a['email']) ? e($a['email']) : '—' ?></div>
                            <div style="font-size:11px;color:var(--gray-600);margin-top:2px"><?= e($a['phone'] ?? '-') ?></div>
                        </td>
                        <td>
                            <?php if (!empty($a['cv_path']) || !empty($a['diploma_path']) || !empty($a['photo_path'])): ?>
                                <a href="<?= BASE_URL ?>/index.php?url=download/berkas&id=<?= (int)$a['id'] ?>" class="ax-dl-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Review Docs
                                </a>
                            <?php else: ?>
                                <span style="font-size:11px;color:var(--gray-600)">No docs provided</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php $meta = applicationStatusMeta($a['status'] ?? ''); ?>
                            <div style="display:flex;flex-direction:column;gap:4px">
                                <span class="ax-status-badge <?= e($meta['badge']) ?>"><?= e($meta['label']) ?></span>
                                <?php if (in_array($a['status'] ?? '', ['accepted','rejected'], true) && !empty($a['email'])):
                                    $email = applicationStatusEmailTemplate($a['name']??'', $job['title']??'', $a['status']);
                                    $mailto = 'mailto:'.rawurlencode($a['email']).'?subject='.rawurlencode($email['subject']).'&body='.rawurlencode($email['body']);
                                ?>
                                    <a href="<?= e($mailto) ?>" style="font-size:10px;color:var(--color-accent);text-decoration:none;font-weight:700">SEND NOTIFICATION</a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/applications/update-status" style="display:flex;align-items:center;gap:6px">
                                <input type="hidden" name="application_id" value="<?= (int)$a['id'] ?>">
                                <input type="hidden" name="open_mailto" value="1">
                                <select name="status" class="ax-select" onchange="this.form.submit()">
                                    <?php foreach ($statusOptions as $val => $lbl): ?>
                                        <option value="<?= e($val) ?>" <?= ($a['status']??'') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
