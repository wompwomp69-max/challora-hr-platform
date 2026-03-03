<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'HR Recruitment') ?></title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .navbar { background: #1a1a2e; color: #eee; padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .navbar a { color: #eee; text-decoration: none; margin-right: 1rem; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 900px; margin: 0 auto; padding: 1.5rem; }
        .card { background: #fff; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .btn { display: inline-block; padding: 0.5rem 1rem; background: #16213e; color: #fff; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 0.95rem; }
        .btn:hover { background: #0f3460; }
        .btn-danger { background: #c0392b; }
        .btn-danger:hover { background: #a93226; }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.85rem; }
        form label { display: block; margin-top: 0.75rem; margin-bottom: 0.25rem; font-weight: 500; }
        form input[type="text"], form input[type="email"], form input[type="password"], form textarea { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        form textarea { min-height: 120px; }
        .error { color: #c0392b; margin-top: 0.5rem; }
        .flash { background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; }
        .flash-error { background: #f8d7da; color: #721c24; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.5rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; }
        .badge-pending { background: #e3f2fd; color: #1565c0; }
        .badge-accepted { background: #e8f5e9; color: #2e7d32; }
        .badge-rejected { background: #ffebee; color: #c62828; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="<?= BASE_URL ?>"><?= e($siteName ?? 'HR Recruitment') ?></a>
            <a href="<?= BASE_URL ?>/jobs">Lowongan</a>
            <?php if (isLoggedIn()): ?>
                <?php if (currentRole() === 'hr'): ?>
                    <a href="<?= BASE_URL ?>/hr/jobs">Dashboard HR</a>
                    <a href="<?= BASE_URL ?>/hr/jobs/create">Buat Lowongan</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/applications">Status Lamaran</a>
                    <a href="<?= BASE_URL ?>/user/profile">Profil Saya</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth/register">Daftar</a>
            <?php endif; ?>
        </div>
        <div>
            <?php if (isLoggedIn()): ?>
                <span><?= e($_SESSION['user_name'] ?? 'User') ?></span>
                <a href="<?= BASE_URL ?>/auth/logout">Logout</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth/login">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="container">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash"><?= e($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="flash flash-error"><?= e($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>
        <?= $content ?? '' ?>
    </main>
</body>
</html>
