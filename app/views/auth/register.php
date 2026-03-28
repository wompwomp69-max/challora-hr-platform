<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Challora</title>

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
                        <p class="text-xs text-muted">Buat akun-mu sekarang</p>
                    </div>
                </div>

                <div class="max-w-md">
                    <h1 class="text-3xl font-bold text-default mb-2">Registrasi</h1>
                    <p class="text-sm text-muted mb-6">Lengkapi data untuk mendaftar sebagai kandidat.</p>

                    <?php if (!empty($error)): ?>
                        <div class="mb-4 rounded-xl bg-danger-soft text-danger text-sm px-4 py-3"><?= e($error) ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/register" class="space-y-3">
                        <div>
                            <label for="name" class="block text-sm font-semibold mb-1">Nama</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama" required value="<?= e($old['name'] ?? '') ?>" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan email" required value="<?= e($old['email'] ?? '') ?>" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold mb-1">No. HP</label>
                            <input type="text" id="phone" name="phone" placeholder="Masukkan nomor HP" value="<?= e($old['phone'] ?? '') ?>" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-semibold mb-1">Password (min. 6 karakter)</label>
                            <input type="password" id="password" name="password" placeholder="Masukkan password" required minlength="6" class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <div>
                            <label for="password_confirm" class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
                            <input type="password" id="password_confirm" name="password_confirm" placeholder="Konfirmasi password" required class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-secondary text-accent py-3 text-sm font-semibold hover:bg-secondary-hover transition mt-1">Buat Akun</button>
                        <div class="pt-1 text-sm text-muted">
                            <p>Sudah punya akun? <a href="<?= BASE_URL ?>/auth/login" class="font-semibold text-default hover:underline">Masuk</a></p>
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
                        <p class="text-sm text-white/85 max-w-md">Mulai perjalanan kariermu dengan membangun profil kandidat yang lengkap dan profesional.</p>
                    </div>
                    <div class="bg-white/10 rounded-2xl border border-white/20 p-5 max-w-md mt-6">
                        <h3 class="text-2xl font-bold text-white mb-2">Bangun profilmu dan dilirik lebih cepat</h3>
                        <p class="text-sm text-white/80">Buat akun sekarang, lengkapi data diri, lalu lamar lowongan yang paling sesuai dengan kemampuanmu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
