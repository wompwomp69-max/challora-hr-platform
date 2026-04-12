<?php require APP_PATH . '/views/layouts/header.php'; ?>
<?php
$activeHrMenu = currentRoutePath('hr/jobs');
$activeHrKey = 'dashboard';
if (str_starts_with($activeHrMenu, 'hr/applications/accepted')) {
    $activeHrKey = 'accepted';
} elseif ($activeHrMenu === 'hr/applications') {
    $activeHrKey = 'review';
} elseif (str_starts_with($activeHrMenu, 'hr/jobs/create')) {
    $activeHrKey = 'recruitment';
} elseif (str_starts_with($activeHrMenu, 'hr/jobs/applicants')) {
    $activeHrKey = 'applicants';
}
$hrUserName = $_SESSION['user_name'] ?? 'HR';
$initials = strtoupper(substr($hrUserName, 0, 1));
?>
<style>
/* ==============================================================
   Challora HR — Premium Dark Shell
   All colors from design-tokens.css — no hardcoded hex.
   ============================================================== */

.hr-shell,
.hr-shell * {
    --hr-bg:           var(--color-primary-muted);
    --hr-surface:      var(--color-secondary-muted);
    --hr-surface-2:    var(--color-secondary);
    --hr-border:       var(--color-border);
    --hr-border-sub:   var(--color-primary-hover);
    --hr-text:         var(--color-text);
    --hr-text-muted:   var(--color-text-muted);
    --hr-text-dim:     var(--gray-600);
    --hr-accent:       var(--color-accent);
    --hr-accent-hov:   var(--color-accent-hover);
    --hr-accent-muted: var(--color-accent-muted);
    --hr-on-accent:    var(--color-on-accent);
    --hr-success-text: #4ade80;
    --hr-success-bg:   rgba(74, 222, 128, 0.07);
    --hr-danger-text:  #f87171;
    --hr-danger-bg:    rgba(248, 113, 113, 0.07);
}

.hr-shell *, .hr-shell *::before, .hr-shell *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { background: var(--color-primary-muted); }

.hr-shell {
    display: flex;
    height: 100dvh;
    width: 100vw;
    overflow: hidden;
    background: var(--color-primary-muted);
    font-family: var(--font-sans);
}

/* ─── Sidebar ─────────────────────────────────────────────── */
.hr-sidebar {
    width: 240px;
    flex-shrink: 0;
    background: var(--color-secondary-muted);
    border-right: 1px solid var(--color-border);
    display: flex;
    flex-direction: column;
    padding: 0;
    position: relative;
    z-index: 20;
}

.hr-sidebar::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--color-accent) 40%, transparent);
}

.hr-sidebar-header {
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--color-primary-hover);
}

.hr-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.hr-brand-logo {
    width: 34px; height: 34px;
    background: var(--color-accent);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 800; color: var(--color-on-accent);
    letter-spacing: -1px;
    flex-shrink: 0;
    box-shadow: 0 0 16px var(--color-accent-muted);
}

.hr-brand-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--color-text);
    letter-spacing: -0.3px;
}
.hr-brand-badge {
    font-size: 9px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-accent);
    background: var(--color-accent-muted);
    border: 1px solid rgba(255,69,0,0.25);
    border-radius: 4px;
    padding: 1px 5px;
    display: block;
    margin-top: 1px;
}

/* Nav */
.hr-nav {
    flex: 1;
    padding: 12px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    overflow-y: auto;
}

.hr-nav-section {
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--gray-600);
    padding: 10px 8px 4px;
}

.hr-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 10px;
    border-radius: 7px;
    color: var(--color-text-muted);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.15s ease;
    position: relative;
    cursor: pointer;
}

.hr-nav-link svg {
    width: 16px; height: 16px;
    flex-shrink: 0;
    opacity: 0.7;
    transition: opacity 0.15s;
}

.hr-nav-link:hover {
    background: var(--color-secondary);
    color: var(--color-text);
}
.hr-nav-link:hover svg { opacity: 1; }

.hr-nav-link.active {
    background: var(--color-accent-muted);
    color: var(--color-accent);
    font-weight: 600;
}
.hr-nav-link.active svg { opacity: 1; color: var(--color-accent); }
.hr-nav-link.active::before {
    content: '';
    position: absolute;
    left: 0; top: 25%; bottom: 25%;
    width: 2.5px;
    background: var(--color-accent);
    border-radius: 0 2px 2px 0;
}

/* Sidebar bottom */
.hr-sidebar-footer {
    padding: 12px;
    border-top: 1px solid var(--color-primary-hover);
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.hr-user-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 8px;
    border-radius: 7px;
    margin-bottom: 2px;
}
.hr-user-avatar {
    width: 30px; height: 30px;
    background: var(--color-accent-muted);
    border: 1px solid rgba(255,69,0,0.3);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: var(--color-accent);
    flex-shrink: 0;
}
.hr-user-info { flex: 1; min-width: 0; }
.hr-user-name { font-size: 12px; font-weight: 600; color: var(--gray-200); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.hr-user-role { font-size: 10px; color: var(--gray-600); }

.hr-footer-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 10px;
    border-radius: 7px;
    color: var(--gray-600);
    font-size: 12px; font-weight: 500;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    background: none; border: none; width: 100%; text-align: left;
}
.hr-footer-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
.hr-footer-btn:hover { background: var(--color-secondary); color: var(--color-text-muted); }
.hr-footer-btn.danger:hover { background: rgba(248,113,113,0.07); color: #f87171; }

/* ─── Main area ───────────────────────────────────────────── */
.hr-main-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-width: 0;
}

.hr-topbar {
    padding: 0 28px;
    height: 56px;
    border-bottom: 1px solid var(--color-primary-hover);
    background: var(--color-secondary-muted);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.hr-topbar-left { display: flex; align-items: center; gap: 12px; }

.hr-topbar-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--color-text);
    letter-spacing: -0.2px;
}

.hr-topbar-right { display: flex; align-items: center; gap: 12px; }

.hr-topbar-tag {
    padding: 4px 10px;
    background: var(--color-accent-muted);
    border: 1px solid rgba(255,69,0,0.2);
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: var(--color-accent);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Content scroll area */
.hr-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 24px 28px;
    background: var(--color-primary-muted);
}
.hr-content::-webkit-scrollbar { width: 4px; }
.hr-content::-webkit-scrollbar-track { background: transparent; }
.hr-content::-webkit-scrollbar-thumb { background: var(--color-border); border-radius: 4px; }

/* Flash alerts */
.hr-alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 8px;
}
.hr-alert.success { background: rgba(74,222,128,0.07); border: 1px solid rgba(74,222,128,0.25); color: #4ade80; }
.hr-alert.error   { background: rgba(248,113,113,0.07); border: 1px solid rgba(248,113,113,0.25); color: #f87171; }

/* ─── Stagger animation ──────────────────────────────────── */
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-8px); }
    to   { opacity: 1; transform: translateX(0); }
}
.hr-nav-link { animation: slideInLeft 0.3s ease both; }
.hr-nav-link:nth-child(1) { animation-delay: 0.05s; }
.hr-nav-link:nth-child(2) { animation-delay: 0.10s; }
.hr-nav-link:nth-child(3) { animation-delay: 0.15s; }
.hr-nav-link:nth-child(4) { animation-delay: 0.20s; }
.hr-nav-link:nth-child(5) { animation-delay: 0.25s; }
@media (prefers-reduced-motion: reduce) { .hr-nav-link { animation: none; } }
</style>

<div class="hr-shell">
    <!-- ─── Sidebar ──────────────────────────────────────── -->
    <aside class="hr-sidebar" aria-label="HR Navigation">
        <div class="hr-sidebar-header">
            <a class="hr-brand" href="<?= BASE_URL ?>/hr/jobs">
                <div class="hr-brand-logo">C</div>
                <div>
                    <div class="hr-brand-name">challora</div>
                    <span class="hr-brand-badge">HR Panel</span>
                </div>
            </a>
        </div>

        <nav class="hr-nav">
            <div class="hr-nav-section">Main Menu</div>

            <a class="hr-nav-link <?= $activeHrKey === 'dashboard' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/jobs" aria-label="Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a class="hr-nav-link <?= $activeHrKey === 'recruitment' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/jobs/create" aria-label="Post a Job">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Post a Job
            </a>

            <div class="hr-nav-section">Applicants</div>

            <a class="hr-nav-link <?= $activeHrKey === 'review' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/applications" aria-label="Review Applicants">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Review Applicants
            </a>

            <a class="hr-nav-link <?= $activeHrKey === 'accepted' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/applications/accepted" aria-label="Hired Applicants">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Hired Applicants
            </a>
        </nav>

        <div class="hr-sidebar-footer">
            <div class="hr-user-row">
                <div class="hr-user-avatar"><?= e($initials) ?></div>
                <div class="hr-user-info">
                    <div class="hr-user-name"><?= e($hrUserName) ?></div>
                    <div class="hr-user-role">HR Manager</div>
                </div>
            </div>
            <a class="hr-footer-btn" href="<?= BASE_URL ?>/jobs">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                User Mode
            </a>
            <a class="hr-footer-btn danger" href="<?= BASE_URL ?>/auth/logout">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                </svg>
                Sign Out
            </a>
        </div>
    </aside>

    <!-- ─── Main ──────────────────────────────────────────── -->
    <main class="hr-main-wrap">
        <div class="hr-topbar">
            <div class="hr-topbar-left">
                <div class="hr-topbar-title"><?= e($pageTitle ?? 'Dashboard') ?></div>
            </div>
            <div class="hr-topbar-right">
                <span class="hr-topbar-tag">HR Panel</span>
            </div>
        </div>

        <div class="hr-content">
            <?php if (!empty($_SESSION['flash'])): ?>
                <?php $isError = (($_SESSION['flash_type'] ?? '') === 'error'); ?>
                <div class="hr-alert <?= $isError ? 'error' : 'success' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;flex-shrink:0">
                        <?php if ($isError): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <?php endif; ?>
                    </svg>
                    <?= e($_SESSION['flash']) ?>
                </div>
                <?php unset($_SESSION['flash'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="hr-alert error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?= e($_SESSION['flash_error']) ?>
                </div>
                <?php unset($_SESSION['flash_error']); ?>
            <?php endif; ?>
            <?= $content ?? '' ?>
        </div>
    </main>
</div>
<?php require APP_PATH . '/views/layouts/footer.php'; ?>
