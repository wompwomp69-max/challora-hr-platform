<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'HR Recruitment') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_URL ?>"><?= e($siteName ?? 'HR Recruitment') ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/jobs">Lowongan</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                        <?php if (currentRole() === 'hr'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>/hr/jobs">Dashboard HR</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>/hr/jobs/create">Buat Lowongan</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>/applications">Status Lamaran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>/user/profile">Profil Saya</a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/register">Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <span class="navbar-text me-3"><?= e($_SESSION['user_name'] ?? 'User') ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/login">Login</a>
                        </li>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
