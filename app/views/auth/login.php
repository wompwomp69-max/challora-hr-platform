<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Challora</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/design-tokens.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-primary text-default" style="font-family: var(--font-sans);">
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
        <div class="w-full max-w-6xl bg-surface rounded-3xl shadow-lg overflow-hidden border border-muted grid grid-cols-1 lg:grid-cols-2">
            <div class="p-6 md:p-10 lg:p-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-11 h-11 rounded-xl bg-secondary text-accent flex items-center justify-center font-bold text-lg">A</div>
                    <div>
                        <h2 class="text-lg font-bold text-default">Challora</h2>
                        <p class="text-xs text-muted">Masuk atau Registrasi untuk melanjutkan.</p>
                    </div>
                </div>

                <div class="max-w-md">
                    <h1 class="text-3xl font-bold text-default mb-2">Masuk</h1>
                    <p class="text-sm text-muted mb-6">Masuk untuk melanjutkan ke dashboard rekrutmen.</p>

                    <?php if (!empty($error)): ?>
                        <div class="mb-4 rounded-xl bg-danger-soft text-danger text-sm px-4 py-3"><?= e($error) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['flash'])): ?>
                        <div class="mb-4 rounded-xl bg-success-soft text-success text-sm px-4 py-3"><?= e($_SESSION['flash']) ?></div>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>

                    <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/login" class="space-y-4">
                        <div>
                            <label for="email" class="block text-secondary font-semibold mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="john.doe@gmail.com" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label for="password" class="block text-secondary font-semibold mb-1">Password</label>
                            <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div class="flex items-center justify-end">
                            <a href="<?= BASE_URL ?>/auth/forgot" class="text-sm font-semibold text-secondary hover:underline">Lupa password?</a>
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-secondary text-accent py-3 text-sm font-semibold hover:bg-secondary-hover transition">Masuk</button>
                        <div class="pt-1 text-sm text-muted">
                            <p>Belum punya akun? <a href="<?= BASE_URL ?>/auth/register" class="font-semibold text-default hover:underline">Registrasi</a></p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="relative min-h-[360px] lg:min-h-full p-6 md:p-8 text-white overflow-hidden" style="background-image: linear-gradient(180deg, rgba(1,22,39,0.82), rgba(1,22,39,0.92)), url('<?= BASE_URL ?>/assets/images/login-side.jpg'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="text-sm font-semibold text-accent mb-5">Challora</div>
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight mb-3 text-white">Selamat datang di Challora</h2>
                        <p class="text-sm text-white/85 max-w-md">Challora membantu kandidat dan HR terhubung dalam satu platform rekrutmen yang rapi, cepat, dan mudah digunakan.</p>
                    </div>
                    <div class="bg-white/10 rounded-2xl border border-white/20 p-5 max-w-md mt-6">
                        <h3 class="text-2xl font-bold text-white mb-2">Temukan pekerjaan yang tepat untukmu</h3>
                        <p class="text-sm text-white/80">Lengkapi profilmu, lamar posisi terbaik, dan pantau proses seleksi dengan lebih terstruktur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
