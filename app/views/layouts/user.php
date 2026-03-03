<?php require APP_PATH . '/views/layouts/header.php'; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= BASE_URL ?>"><?= e($siteName ?? 'HR Recruitment') ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/jobs">Lowongan</a></li>
                <?php if (isLoggedIn() && currentRole() === 'user'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/applications">Status Lamaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/user/settings">Profil Saya</a></li>
                <?php elseif (isLoggedIn() && currentRole() === 'hr'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/hr/jobs">Dashboard HR</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/register">Daftar</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item"><span class="navbar-text me-3"><?= e($_SESSION['user_name'] ?? 'User') ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/logout">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['flash_error']) ?></div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>
    <?= $content ?? '' ?>
</main>
<?php require APP_PATH . '/views/layouts/footer.php'; ?>
