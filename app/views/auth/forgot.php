<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Challora</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/design-tokens.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-primary text-secondary" style="font-family: var(--font-sans);">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-2xl bg-surface border border-muted shadow-lg p-6">
        <div class="text-center mb-6">
            <div class="w-11 h-11 mx-auto rounded-xl bg-secondary text-accent flex items-center justify-center font-bold text-lg mb-3">C</div>
            <h1 class="text-2xl font-bold text-secondary">Lupa Password</h1>
            <p class="text-sm text-secondary/80 mt-1">Masukkan email untuk menerima tautan reset password.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 rounded-xl bg-danger-soft text-danger text-sm px-4 py-3">
                <?= e($error) ?>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="mb-4 rounded-xl bg-success-soft text-success text-sm px-4 py-3">
                <?= e($success) ?>
            </div>
            <?php if (!empty($link)): ?>
                <div class="mt-3 rounded-xl bg-info-soft text-info text-sm px-4 py-3 break-all">
                    <a href="<?= e($link) ?>" target="_blank" class="underline"><?= e($link) ?></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/forgot" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold mb-1 text-secondary">Alamat Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    required
                    class="w-full rounded-xl border border-default bg-surface px-4 py-3 text-sm text-secondary focus:outline-none focus:ring-2 focus:ring-primary/40"
                >
            </div>

            <button type="submit" class="w-full rounded-xl bg-accent text-secondary py-3 font-semibold hover:bg-accent-hover transition">
                Kirim Link Reset
            </button>

            <p class="text-sm text-secondary/80 text-center">
                Sudah ingat password?
                <a href="<?= BASE_URL ?>/auth/login" class="font-semibold text-secondary hover:underline">Masuk</a>
            </p>
        </form>
    </div>
</div>
</body>
</html>
