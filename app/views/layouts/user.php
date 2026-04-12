<?php require APP_PATH . '/views/layouts/header.php'; ?>
<?php
$activeUserPath = currentRoutePath('jobs');
?>
<style>
    /* Brutalist Basic Overrides */
    html,
    body {
        background-color: var(--color-primary);
        color: var(--color-text);
        font-family: var(--font-sans);
        overflow-x: hidden;
    }

    .brutalist-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 40px;
        background-color: transparent;
        border-bottom: 1px solid var(--color-border);
    }

    .brutalist-brand {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 20px;
        font-weight: 700;
        color: var(--color-text);
        text-decoration: none;
        letter-spacing: -0.5px;
    }

    .brutalist-links {
        display: flex;
        gap: 32px;
    }

    .brutalist-link {
        font-size: 14px;
        font-weight: 500;
        color: var(--color-text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .brutalist-link:hover,
    .brutalist-link.active {
        color: var(--color-text);
    }

    .brutalist-link.active {
        border-bottom: 2px solid var(--color-text);
        padding-bottom: 4px;
    }

    .brutalist-profile {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--color-text-muted);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .brutalist-profile:hover {
        color: var(--color-text);
    }

    .brutalist-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px;
        width: 100%;
    }
</style>
<div class="user-shell min-h-screen flex flex-col">
    <header class="brutalist-nav">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>/jobs" class="brutalist-brand lowercase">
            challora
        </a>

        <!-- Navigation -->
        <nav class="hidden md:flex brutalist-links lowercase">
            <a href="<?= BASE_URL ?>/jobs"
                class="brutalist-link <?= str_starts_with($activeUserPath, 'jobs') && !str_starts_with($activeUserPath, 'jobs/saved') ? 'active' : '' ?>">job
                lists</a>
            <a href="<?= BASE_URL ?>/applications"
                class="brutalist-link <?= str_contains($activeUserPath, 'applications') ? 'active' : '' ?>">applied jobs</a>
            <a href="<?= BASE_URL ?>/jobs/saved"
                class="brutalist-link <?= str_contains($activeUserPath, 'jobs/saved') ? 'active' : '' ?>">saved jobs</a>
        </nav>

        <!-- Right User Area -->
        <div class="flex items-center gap-6">
            <?php if (isLoggedIn() && currentRole() === 'user'): ?>
                <div class="relative group" id="user-menu-root">
                    <button type="button" id="user-menu-toggle" class="brutalist-profile lowercase"
                        style="display:flex; align-items:center; gap:8px;">
                        <?php if (!empty($_SESSION['user_avatar_path'])): ?>
                            <img src="<?= BASE_URL . '/download/avatar?v=' . e((string) ($_SESSION['user_avatar_ver'] ?? '')) ?>"
                                style="width:24px; height:24px; border-radius:50%; object-fit:cover; border:1px solid var(--color-border);"
                                alt="">
                        <?php else: ?>
                            <div
                                style="width:24px; height:24px; border-radius:50%; background:var(--color-text); color:var(--color-surface); display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:14px; text-transform:uppercase;">
                                <?= e(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <span><?= e($_SESSION['user_name'] ?? 'my profile') ?></span>
                    </button>
                    <!-- Dropdown -->
                    <div id="user-menu-dropdown"
                        style="background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 0;"
                        class="absolute right-0 mt-3 w-40 shadow-xl hidden z-50 text-left">
                        <a href="<?= BASE_URL ?>/user/settings" style="color: var(--color-text-muted);"
                            class="block px-4 py-3 text-sm hover:bg-[#1a1a1a] hover:text-white transition-colors lowercase">settings</a>
                        <a href="<?= BASE_URL ?>/auth/logout"
                            style="color: var(--color-accent); border-top: 1px solid var(--color-border);"
                            class="block px-4 py-3 text-sm hover:bg-[#1a1a1a] transition-colors lowercase">logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth/login" class="brutalist-link lowercase">login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Global Alerts -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <?php
        $flashClass = ($_SESSION['flash_type'] ?? 'success') === 'error' ? 'bg-[#ff4500] text-white' : 'bg-green-600 text-white';
        ?>
        <div class="mx-10 mt-6 px-4 py-3 <?= $flashClass ?> text-sm font-bold lowercase"><?= e($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash'], $_SESSION['flash_type']); ?>
    <?php endif; ?>

    <main class="brutalist-main flex-1 w-full min-h-0">
        <?= $content ?? '' ?>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('user-menu-toggle');
        var dropdown = document.getElementById('user-menu-dropdown');
        if (!toggle || !dropdown) return;
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function () {
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>