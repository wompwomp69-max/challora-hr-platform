<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Challora</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/design-tokens.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: var(--font-sans); background: var(--color-surface); color: var(--color-text); }
        .brutalist-card {
            border: 2px solid var(--color-border);
            box-shadow: 8px 8px 0 rgba(0,0,0,1);
            background: #0a0a0a;
            border-radius: 0;
            overflow: hidden;
        }
        .brutalist-input {
            background: #111;
            border: 2px solid var(--color-border);
            border-radius: 0;
            color: var(--color-text);
            padding: 14px 16px;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 2px 2px 0 rgba(0,0,0,0.5);
            text-transform: lowercase;
            font-size: 16px;
        }
        .brutalist-input:focus {
            border-color: var(--color-accent);
            box-shadow: 4px 4px 0 var(--color-accent);
            outline: none;
            transform: translate(-2px, -2px);
        }
        .brutalist-btn {
            display: inline-block;
            width: 100%;
            background: var(--color-accent);
            color: var(--color-surface);
            padding: 16px 24px;
            font-weight: 800;
            font-size: 16px;
            text-transform: lowercase;
            text-decoration: none;
            text-align: center;
            border: 2px solid var(--color-border);
            border-radius: 0;
            cursor: pointer;
            box-shadow: 4px 4px 0 rgba(0,0,0,1);
            transition: all 0.2s ease;
        }
        .brutalist-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0 rgba(0,0,0,1);
        }
        .brutalist-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0 rgba(0,0,0,1);
        }
        .brutalist-label {
            text-transform: lowercase;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }
        .brutalist-title {
            font-size: 56px;
            font-weight: 600;
            letter-spacing: -3px;
            color: var(--color-text);
            margin-bottom: 12px;
            text-transform: lowercase;
            line-height: 1.1;
        }
        .brutalist-alert {
            background: var(--color-accent);
            color: var(--color-surface);
            padding: 16px;
            border: 2px solid var(--color-border);
            font-weight: bold;
            font-size: 14px;
            text-transform: lowercase;
            margin-bottom: 24px;
            box-shadow: 4px 4px 0 rgba(0,0,0,1);
        }
        .brutalist-hero {
            background: var(--color-accent);
            color: var(--color-surface);
            border-left: 2px solid var(--color-border);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        @media (max-width: 1024px) {
            .brutalist-hero { border-left: none; border-top: 2px solid var(--color-border); }
        }
    </style>
</head>
<body class="min-h-screen lowercase">
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8 relative">
        <div class="w-full max-w-6xl brutalist-card grid grid-cols-1 lg:grid-cols-2 relative z-10">
            <!-- Left Side / Form -->
            <div class="p-8 md:p-12 lg:p-16">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-accent text-surface flex items-center justify-center font-bold text-xl border-2 border-border" style="box-shadow: 4px 4px 0 rgba(0,0,0,1)">C</div>
                    <div>
                        <h2 class="text-xl font-bold" style="letter-spacing: -1px;">challora</h2>
                        <p class="text-sm font-semibold opacity-70">candidate registration</p>
                    </div>
                </div>

                <div class="max-w-md">
                    <h1 class="brutalist-title">register</h1>
                    <p class="text-base mb-8 font-semibold opacity-75">create your account & drop the aesthetics.</p>

                    <?php if (!empty($error)): ?>
                        <div class="brutalist-alert"><?= e($error) ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= BASE_URL ?>/index.php?url=auth/register" class="space-y-5">
                        <?= csrf_field() ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="brutalist-label">full name</label>
                                <input type="text" id="name" name="name" placeholder="john doe" required value="<?= e($old['name'] ?? '') ?>" class="brutalist-input">
                            </div>
                            <div>
                                <label for="phone" class="brutalist-label">phone no.</label>
                                <input type="text" id="phone" name="phone" placeholder="0812...." value="<?= e($old['phone'] ?? '') ?>" class="brutalist-input">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="brutalist-label">email address</label>
                            <input type="email" id="email" name="email" placeholder="john.doe@gmail.com" required value="<?= e($old['email'] ?? '') ?>" class="brutalist-input">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="password" class="brutalist-label">password (min 8 chars, mix case, num, spec)</label>
                                <input type="password" id="password" name="password" placeholder="enter password" required minlength="6" class="brutalist-input">
                            </div>
                            <div>
                                <label for="password_confirm" class="brutalist-label">confirm password</label>
                                <input type="password" id="password_confirm" name="password_confirm" placeholder="confirm" required class="brutalist-input">
                            </div>
                        </div>

                        <button type="submit" class="brutalist-btn mt-4">create account</button>
                        
                        <div class="pt-4 text-center font-semibold text-sm">
                            <p>already have an account? <a href="<?= BASE_URL ?>/auth/login" class="text-accent underline" style="text-underline-offset: 4px;">sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side / Hero Image Replacement -->
            <div class="brutalist-hero">
                <div>
                    <h2 class="font-bold" style="font-size: 64px; line-height: 1; letter-spacing: -3px; margin-bottom: 24px;">build<br>your profile.</h2>
                    <p class="font-bold" style="font-size: 20px; max-w: 400px; line-height: 1.4;">Stand out to HR dynamically. Provide data that counts. Leave the fluff behind.</p>
                </div>
                
                <div style="background: var(--color-surface); color: var(--color-text); border: 2px solid var(--color-border); padding: 24px; box-shadow: 6px 6px 0 rgba(0,0,0,1); display: inline-block; max-width: 380px;">
                    <h3 class="text-2xl font-bold mb-2 lowercase" style="letter-spacing:-1px;">straight to the point</h3>
                    <p class="text-sm font-semibold opacity-80 lowercase">We enforce structure so hr can read your capability seamlessly. Focus on your skills, not the layout.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
