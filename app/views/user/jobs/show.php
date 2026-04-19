<?php
$companies = ['qclay studio', 'malvah', 'motto', 'netflix', 'google'];
$companyIndex = ((int) ($job['id'] ?? 1)) % count($companies);
$companyName = $companies[$companyIndex];
$companyInitial = mb_substr($companyName, 0, 1);
?>
<style>
    /* Brutalist Detail Overrides */
    .brutalist-back {
        display: inline-flex;
        align-items: center;
        color: var(--color-text);
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 40px;
        letter-spacing: -0.5px;
        transition: color 0.2s;
    }

    .brutalist-back:hover {
        color: var(--color-text-muted);
    }

    .brutalist-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 60px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .brutalist-layout {
            grid-template-columns: 1fr;
        }
    }

    .brutalist-content-head {
        margin-bottom: 32px;
    }

    .brutalist-detail-title {
        font-size: 48px;
        font-weight: 500;
        color: var(--color-text-muted);
        letter-spacing: -1.5px;
        margin-bottom: 16px;
        line-height: 1.1;
    }

    .brutalist-detail-company {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 600;
        color: var(--color-text);
        letter-spacing: -0.5px;
    }

    .brutalist-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 48px;
    }

    .brutalist-tag {
        padding: 6px 16px;
        border: 1px solid var(--color-border);
        font-size: 14px;
        font-weight: 500;
        color: var(--color-text);
    }

    .brutalist-section {
        margin-bottom: 48px;
    }

    .brutalist-h3 {
        font-size: 24px;
        font-weight: 500;
        color: var(--color-text);
        margin-bottom: 16px;
        letter-spacing: -0.5px;
    }

    .brutalist-text {
        font-size: 16px;
        line-height: 1.6;
        color: var(--color-text-muted);
    }

    .brutalist-text ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-top: 12px;
    }

    .brutalist-text li {
        margin-bottom: 8px;
    }

    .brutalist-sidebar {
        background-color: #161616;
        padding: 32px;
        border: 1px solid var(--color-border);
    }

    .brutalist-sidebar-salary {
        font-size: 32px;
        font-weight: 600;
        color: var(--color-accent);
        margin-bottom: 24px;
        letter-spacing: -1px;
    }

    .brutalist-sidebar-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 15px;
        color: var(--color-text-muted);
        margin-bottom: 32px;
    }

    .brutalist-sidebar-meta strong {
        color: var(--color-text);
        font-weight: 500;
    }

    .brutalist-btn {
        display: block;
        width: 100%;
        background-color: var(--color-accent);
        color: var(--color-surface);
        text-align: center;
        padding: 16px;
        font-size: 18px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .brutalist-btn:hover {
        background-color: var(--color-accent-hover);
    }

    .brutalist-btn-alt {
        background-color: #222;
        color: var(--color-text) !important;
    }

    .brutalist-btn-alt:hover {
        background-color: #333;
    }
</style>

<div class="lowercase">
    <a href="<?= BASE_URL ?>/jobs" class="brutalist-back">
        <i class="bi bi-arrow-left mr-2"></i> back
    </a>

    <div class="brutalist-layout">
        <!-- Main Content -->
        <div>
            <div class="brutalist-content-head">
                <h1 class="brutalist-detail-title"><?= e($job['title']) ?></h1>
                <div class="brutalist-detail-company">
                    <div
                        class="brutalist-company-icon w-8 h-8 rounded-full bg-white text-black flex items-center justify-center text-sm font-bold">
                        <?php if ($companyIndex === 3)
                            echo '<i class="bi bi-netflix text-[#e50914] bg-transparent"></i>';
                        else if ($companyIndex === 4)
                            echo '<i class="bi bi-google text-[#4285F4] bg-transparent"></i>';
                        else
                            echo e($companyInitial);
                        ?>
                    </div>
                    <?= e($companyName) ?>
                </div>
            </div>

            <div class="brutalist-tags">
                <span class="brutalist-tag">full-time</span>
                <span class="brutalist-tag">remote possible</span>
                <span class="brutalist-tag">english required</span>
                <span class="brutalist-tag">senior level</span>
            </div>

            <div class="brutalist-section">
                <h3 class="brutalist-h3">description</h3>
                <div class="brutalist-text">
                    <?= nl2br(e($job['description'])) ?>
                </div>
            </div>

            <div class="brutalist-section">
                <h3 class="brutalist-h3">responsibilities</h3>
                <div class="brutalist-text">
                    <ul>
                        <li>own the design process from research to final handoff</li>
                        <li>collaborate with product managers, engineers, and other designers</li>
                        <li>create wireframes, user flows, and high-fidelity mockups</li>
                        <li>conduct usability testing and apply insights to improve ux</li>
                        <li>maintain and evolve our design system</li>
                    </ul>
                </div>
            </div>

            <div class="brutalist-section">
                <h3 class="brutalist-h3">requirements</h3>
                <div class="brutalist-text">
                    <ul>
                        <li>6+ years of experience in product/ui/ux design</li>
                        <li>strong portfolio demonstrating product thinking and craft</li>
                        <li>proficiency in figma and prototyping tools</li>
                        <li>understanding of html/css is a plus</li>
                        <li>leadership or mentoring experience is a bonus</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div>
            <div class="brutalist-sidebar">
                <div class="brutalist-sidebar-salary"><?= e($job['salary_range'] ? $job['salary_range'] : '$1400') ?>
                </div>

                <div class="brutalist-sidebar-meta">
                    <div>company: <strong><?= e($companyName) ?></strong></div>
                    <div>location: <strong><?= e($job['location'] ?: 'london') ?></strong></div>
                    <div>experience required: <strong>6+ years</strong></div>
                    <div>job type: <strong>full-time</strong></div>
                    <div>posted on: <strong>27 may 2026</strong></div>
                </div>

                <?php if (isLoggedIn() && currentRole() === 'user'): ?>
                    <?php if ($alreadyApplied): ?>
                        <div class="brutalist-btn brutalist-btn-alt cursor-not-allowed text-center">already applied</div>
                    <?php elseif (!$hasRequiredDocs): ?>
                        <button type="button" class="brutalist-btn"
                            onclick="showMissingDocsToast(<?= htmlspecialchars(json_encode($missingDocs), ENT_QUOTES, 'UTF-8') ?>)">apply
                            now</button>
                    <?php else: ?>
                        <form method="post" action="<?= BASE_URL ?>/index.php?url=jobs/apply">
                            <?= csrf_field() ?>
                            <input type="hidden" name="job_id" value="<?= (int) $job['id'] ?>">
                            <button type="submit" class="brutalist-btn">apply now</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/auth/login" class="brutalist-btn brutalist-btn-alt">login to apply</a>
                <?php endif; ?>
            </div>

            <?php if (isLoggedIn() && currentRole() === 'user'): ?>
                <form method="post" action="<?= BASE_URL ?><?= $isSaved ? '/jobs/unsave' : '/jobs/save' ?>" class="mt-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                    <input type="hidden" name="redirect" value="<?= e('/jobs/show?id=' . $job['id']) ?>">
                    <button type="submit" class="brutalist-btn brutalist-btn-alt">
                        <?= $isSaved ? 'remove from saved' : 'save for later' ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="missing-docs-toast"
    style="position: fixed; bottom: -100vh; right: 24px; background: var(--color-accent); border: 2px solid var(--color-border); padding: 16px 24px; color: var(--color-surface); font-weight: bold; font-size: 14px; text-transform: lowercase; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 9999; display: flex; align-items: flex-start; gap: 12px; max-width: 350px; box-shadow: 4px 4px 0 rgba(0,0,0,1);">
    <i class="bi bi-x-circle" style="font-size: 20px; margin-top: -2px;"></i>
    <div>
        <div style="font-size: 16px; margin-bottom: 4px;">cannot apply yet</div>
        <div style="font-weight: 500;">you are missing required documents: <span id="missing-docs-list"></span>. <a
                href="<?= BASE_URL ?>/user/settings"
                style="color: var(--color-surface); text-decoration: underline;">upload now</a>.</div>
    </div>
</div>

<script>
    let toastTimeout;
    function showMissingDocsToast(docsArray) {
        const toast = document.getElementById('missing-docs-toast');
        const list = document.getElementById('missing-docs-list');
        list.textContent = docsArray.join(', ');
        toast.style.bottom = '24px';
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.style.bottom = '-100vh';
        }, 5000);
    }
</script>