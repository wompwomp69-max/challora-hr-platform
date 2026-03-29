<?php require APP_PATH . '/views/layouts/header.php'; ?>
<?php
$activeHrMenu = currentRoutePath('hr/jobs');
$activeHrKey = 'dashboard';
if (str_starts_with($activeHrMenu, 'hr/applications/accepted')) {
    $activeHrKey = 'accepted';
} elseif (str_starts_with($activeHrMenu, 'hr/jobs/create')) {
    $activeHrKey = 'recruitment';
} elseif (str_starts_with($activeHrMenu, 'hr/jobs/applicants')) {
    $activeHrKey = 'applicants';
}
?>
<style>
.hr-body-override{background:var(--color-secondary) !important;color:var(--color-on-secondary);}
.hr-shell{padding:0;height:100vh;width:100vw;}
.hr-sidebar{width:230px;background:var(--color-primary);color:var(--color-on-primary);border-radius:0;padding:14px;display:flex;flex-direction:column;gap:12px;box-shadow:var(--shadow-md);}
.hr-brand{font-weight:700;font-size:1.6rem;letter-spacing:.2px;color:var(--color-on-primary);}
.hr-nav-link{display:flex;align-items:center;gap:8px;padding:10px 12px;border-radius:10px;color:var(--color-on-primary);text-decoration:none;font-size:13px;font-weight:500;opacity:.92;}
.hr-nav-link:hover{background:var(--color-primary-hover);opacity:1;}
.hr-nav-link.active{background:rgba(255,255,255,.09);font-weight:600;}
.hr-main-wrap{background:var(--color-primary);border-radius:0;padding:10px 12px;display:flex;flex-direction:column;gap:10px;box-shadow:var(--shadow-md);}
.hr-topbar{background:var(--color-primary-hover);border-radius:12px;padding:10px 14px;color:var(--color-on-primary);display:flex;align-items:center;justify-content:space-between;}
.hr-content{background:var(--color-secondary-muted);border-radius:12px;padding:14px;overflow:auto;min-height:0;flex:1;}
</style>
<script>document.body.classList.add('hr-body-override');</script>
<div class="hr-shell">
    <div class="d-flex h-100">
        <aside class="hr-sidebar flex-shrink-0">
            <a class="hr-brand text-decoration-none" href="<?= BASE_URL ?>/hr/jobs">MyRecruit</a>
            <nav class="d-flex flex-column gap-1">
                <a class="hr-nav-link <?= $activeHrKey === 'dashboard' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/jobs">Dashboard</a>
                <a class="hr-nav-link <?= $activeHrKey === 'recruitment' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/jobs/create">Recruitment</a>
                <a class="hr-nav-link <?= $activeHrKey === 'applicants' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/jobs">Applicant Database</a>
                <a class="hr-nav-link <?= $activeHrKey === 'accepted' ? 'active' : '' ?>" href="<?= BASE_URL ?>/hr/applications/accepted">Pelamar Diterima</a>
            </nav>
            <div class="mt-auto d-grid gap-2">
                <a class="btn btn-sm btn-light fw-semibold" href="<?= BASE_URL ?>/jobs">User Account Mode</a>
                <a class="btn btn-sm bg-accent text-secondary hover:bg-accent-hover fw-semibold" href="<?= BASE_URL ?>/auth/logout">Logout</a>
            </div>
        </aside>
        <main class="hr-main-wrap flex-grow-1 h-100">
            <div class="hr-topbar">
                <strong>Dashboard</strong>
                <span class="small opacity-75">HR Panel</span>
            </div>
            <div class="hr-content d-flex flex-column">
                <?php if (!empty($_SESSION['flash'])): ?>
                    <?php
                    $flashType = (string) ($_SESSION['flash_type'] ?? 'success');
                    $flashClass = $flashType === 'error' ? 'danger' : ($flashType === 'info' ? 'info' : 'success');
                    ?>
                    <div class="alert alert-<?= e($flashClass) ?>"><?= e($_SESSION['flash']) ?></div>
                    <?php unset($_SESSION['flash']); ?>
                    <?php unset($_SESSION['flash_type']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['flash_error'])): ?>
                    <div class="alert alert-danger"><?= e($_SESSION['flash_error']) ?></div>
                    <?php unset($_SESSION['flash_error']); ?>
                <?php endif; ?>
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
</div>
<?php require APP_PATH . '/views/layouts/footer.php'; ?>
