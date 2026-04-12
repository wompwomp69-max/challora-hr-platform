<style>
    .brutalist-title {
        font-size: 56px;
        font-weight: 600;
        letter-spacing: -2px;
        color: var(--color-text-muted);
        margin-bottom: 60px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--color-border);
    }

    .brutalist-job-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px 32px;
        border-bottom: 1px solid var(--color-border);
        transition: background-color 0.2s ease;
    }

    .brutalist-job-name,
    .brutalist-job-desc {
        font-size: 28px;
        font-weight: 400;
        color: var(--color-text);
        text-decoration: none;
        letter-spacing: -1px;
    }

    .brutalist-job-desc {
        opacity: 0.6;
    }

    .brutalist-job-row:hover .brutalist-job-name {
        color: var(--color-accent);
    }

    .brutalist-job-row:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .brutalist-job-left {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .brutalist-company-icon {
        width: 48px;
        height: 48px;
        background-color: var(--color-text);
        color: var(--color-surface);
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
    }

    .brutalist-job-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .brutalist-company-name {
        font-size: 28px;
        font-weight: 600;
        color: var(--color-text);
        text-decoration: none;
        letter-spacing: -1px;
    }

    .brutalist-company-name:hover {
        color: var(--color-accent);
    }

    .brutalist-job-title {
        font-size: 24px;
        font-weight: 500;
        color: var(--color-text-muted);
        letter-spacing: -0.5px;
    }

    .brutalist-job-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .brutalist-salary {
        font-size: 32px;
        font-weight: 600;
        color: var(--color-accent);
        letter-spacing: -1px;
    }

    .brutalist-meta {
        font-size: 14px;
        color: var(--color-text-muted);
        font-weight: 500;
    }

    .brutalist-btn-icon {
        background: transparent;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
        font-size: 20px;
    }

    .brutalist-btn-icon:hover {
        color: var(--color-accent);
    }

    @media (max-width: 768px) {
        .brutalist-job-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .brutalist-job-right {
            align-items: flex-start;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }
    }
</style>

<div class="lowercase">
    <h1 class="brutalist-title">saved jobs</h1>

    <div class="brutalist-job-list">
        <?php if (empty($jobs)): ?>
            <div class="py-10 text-xl text-gray-500 font-medium">
                no saved jobs.
            </div>
        <?php else: ?>
            <?php foreach ($jobs as $j): ?>
                <?php
                $companies = ['qclay studio', 'malvah', 'motto', 'netflix', 'google'];
                $companyIndex = ((int) $j['id']) % count($companies);
                $companyName = $companies[$companyIndex];
                $companyInitial = mb_substr($companyName, 0, 1);

                // Format salary
                $salaryDisplay = '';
                $curr = $j['currency'] ?? 'IDR';
                if (!empty($j['min_salary']) && !empty($j['max_salary'])) {
                    $salaryDisplay = $curr . ' ' . number_format($j['min_salary'], 0, '.', ',') . ' - ' . number_format($j['max_salary'], 0, '.', ',');
                } else {
                    $salaryDisplay = e($j['salary_range'] ? $j['salary_range'] : 'IDR 10,000,000');
                }
                ?>
                <div class="brutalist-job-row" style="cursor: pointer;"
                    onclick="window.location.href='<?= BASE_URL ?>/jobs/show?id=<?= $j['id'] ?>'">
                    <div class="brutalist-job-left">
                        <div class="brutalist-job-info">
                            <a href="<?= BASE_URL ?>/jobs/show?id=<?= $j['id'] ?>"
                                class="brutalist-job-name"><?= e($j['title']) ?></a>
                            <span class="brutalist-job-desc"
                                style="font-size: 20px; margin-top: 4px;"><?= e($j['short_description'] ?? 'No description available.') ?></span>
                        </div>
                    </div>
                    <div class="brutalist-job-right">
                        <div class="brutalist-salary" style="font-size: 24px;"><?= $salaryDisplay ?></div>
                        <div class="flex items-center gap-4">
                            <div class="brutalist-meta">
                                <?= e($companyName) ?> / <?= e($j['location'] ?: 'remote') ?>
                            </div>
                            <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="d-inline">
                                <input type="hidden" name="job_id" value="<?= (int) $j['id'] ?>">
                                <input type="hidden" name="redirect" value="/jobs/saved">
                                <button type="submit" class="brutalist-btn-icon" title="Remove from saved"
                                    onclick="event.stopPropagation()"><i class="bi bi-bookmark-fill"
                                        style="color:var(--color-accent)"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>