<?php require APP_PATH . '/views/layouts/header.php'; ?>

<header class="bg-transparent py-4">
    <div class="flex items-center justify-between mx-4 md:mx-[150px]">
        <a href="<?= BASE_URL ?>/jobs" class="text-base md:text-lg font-semibold tracking-wide hover:opacity-80">
            CHALLORA
        </a>
        <div class="flex items-center gap-3">
            <?php if (isLoggedIn() && currentRole() === 'user'): ?>
                <?php
                $initial = mb_strtoupper(mb_substr($_SESSION['user_name'] ?? 'U', 0, 1));
                $headerAvatarSrc = currentUserAvatarImgSrc();
                ?>
                <div class="relative" id="user-menu-root">
                    <button
                        type="button"
                        id="user-menu-toggle"
                        class="flex items-center gap-2 focus:outline-none"
                    >
                        <span class="hidden md:inline-block text-xs text-muted hover:text-default">
                            <?= e($_SESSION['user_name'] ?? 'User') ?>
                        </span>
                        <span class="w-9 h-9 rounded-full overflow-hidden bg-primary flex items-center justify-center text-white text-xs font-semibold shrink-0 ring-2 ring-white shadow-sm">
                            <?php if ($headerAvatarSrc): ?>
                                <img src="<?= e($headerAvatarSrc) ?>" alt="" class="w-full h-full object-cover" width="36" height="36">
                            <?php else: ?>
                                <?= e($initial) ?>
                            <?php endif; ?>
                        </span>
                    </button>
                    <div
                        id="user-menu-dropdown"
                        class="absolute right-0 mt-2 w-40 bg-surface rounded-xl shadow-lg border border-muted py-1 text-xs text-muted hidden z-20"
                    >
                        <a href="<?= BASE_URL ?>/user/settings" class="block px-3 py-2 hover:bg-muted">
                            Pengaturan user
                        </a>
                        <a href="<?= BASE_URL ?>/auth/logout" class="block px-3 py-2 hover:bg-muted">
                            Logout
                        </a>
                    </div>
                </div>
            <?php elseif (!isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/auth/login" class="text-xs text-muted hover:text-default">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="py-4 mx-4 md:mx-[150px]">
    <?php if (!empty($_SESSION['flash']) && empty($_SESSION['flash_toast'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['flash_error']) ?></div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>
    <?php if (isLoggedIn() && currentRole() === 'user' && !($hideProfileBar ?? false) && !isProfileComplete()): ?>
        <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span>Datamu belum dilengkapi, lengkapi agar HR semakin yakin untuk menerima mu.</span>
            <a href="<?= BASE_URL ?>/user/settings/edit" class="btn btn-warning btn-sm">Lengkapi Data</a>
        </div>
    <?php endif; ?>
    <?= $content ?? '' ?>
</main>
<?php if (isLoggedIn() && currentRole() === 'user' && !empty($_SESSION['flash_toast'])): ?>
<?php
$toast = $_SESSION['flash_toast'];
unset($_SESSION['flash_toast']);
?>
<div id="toast-user" class="toast-user" role="alert">
    <div class="toast-user-inner">
        <span class="toast-user-msg"><?= e($toast['message']) ?></span>
        <div class="toast-user-actions">
            <?php if (!empty($toast['undo'])): ?>
            <form id="toast-undo-form" method="post" action="<?= e($toast['undo']['url']) ?>" class="d-inline">
                <?php foreach ($toast['undo']['fields'] ?? [] as $k => $v): ?>
                <input type="hidden" name="<?= e($k) ?>" value="<?= e($v) ?>">
                <?php endforeach; ?>
                <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none fw-bold toast-undo-btn"><?= e($toast['undo']['label'] ?? 'Undo') ?></button>
            </form>
            <span class="toast-user-sep">|</span>
            <?php endif; ?>
            <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none fw-bold toast-close-btn" aria-label="Tutup">&times;</button>
        </div>
    </div>
</div>
<style>
.toast-user {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    z-index: 1050;
    min-width: 280px;
    max-width: 400px;
    padding: 1rem 1.25rem;
    background: var(--color-secondary-hover);
    color: var(--color-surface);
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.25);
    animation: toastSlideIn 0.3s ease-out;
}
.toast-user.toast-out {
    animation: toastSlideOut 0.3s ease-in forwards;
}
.toast-user-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.toast-user-msg {
    flex: 1;
}
.toast-user-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
}
.toast-user-sep {
    opacity: 0.6;
}
.toast-close-btn, .toast-undo-btn {
    color: var(--color-surface) !important;
    text-decoration: none !important;
    font-weight: bold;
    opacity: 0.9;
}
.toast-close-btn:hover, .toast-undo-btn:hover {
    opacity: 1;
}
@keyframes toastSlideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
@keyframes toastSlideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
</style>
<script>
(function() {
    var toast = document.getElementById('toast-user');
    if (!toast) return;
    var close = toast.querySelector('.toast-close-btn');
    var undoForm = document.getElementById('toast-undo-form');
    function dismiss() {
        toast.classList.add('toast-out');
        setTimeout(function() { toast.remove(); }, 300);
    }
    if (close) close.addEventListener('click', dismiss);
    setTimeout(dismiss, 5000);
})();
</script>
<?php endif; ?>
<script>
// simple user dropdown (selalu aktif untuk user)
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
