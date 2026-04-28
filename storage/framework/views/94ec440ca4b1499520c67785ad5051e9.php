<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($pageTitle ?? config('app.name', 'Challora')); ?></title>

    <!-- Token tema (warna, font, radius) -->
    <link rel="stylesheet" href="<?php echo e(asset('css/design-tokens.css')); ?>">

    <!-- Vite Assets (Tailwind & JS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700;800&display=swap"
        rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        :root {
            --nav-height: 80px;
        }



        .main-container,
        .hr-main-content {
            width: 100%;
            min-height: calc(100vh - var(--nav-height));
            max-width: 1600px;
            margin: 0 auto;
            padding: 60px 80px;
            /* Desired horizontal padding */
        }

        /* Landing-only: merge hero with navbar */
        body.landing-page .brutal-header {
            position: fixed;
            background: rgba(0, 0, 0, 0.72);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.landing-page .main-container {
            max-width: none;
            padding-top: 0;
            padding-left: 0;
            padding-right: 0;
        }
    </style>
</head>

<body class="antialiased bg-primary text-text font-sans <?php echo e(request()->routeIs('landing') ? 'landing-page' : ''); ?>">
    <div class="min-h-screen bg-surface flex flex-col">
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if(session('flash_toast')): ?>
            <div class="mx-[80px] mt-8 flex items-center justify-between p-4 border-4 border-black shadow-[6px_6px_0_0_black] bg-success-bg text-success-text font-bold"
                id="flash-alert">
                <div class="flex items-center gap-3">
                    <svg width="24" height="24" class="text-success-text" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="tracking-tight uppercase"><?php echo e(session('flash_toast')['message']); ?></span>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="opacity-50 hover:opacity-100 transition-opacity bg-black text-white p-1 rounded-sm">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div
                class="mx-[80px] mt-8 flex flex-col p-4 border-4 border-black shadow-[6px_6px_0_0_black] bg-red-100 text-red-700 font-bold">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="tracking-tight uppercase"><?php echo e($error); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <main id="swup" class="main-container flex-1 transition-fade">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="p-10 border-t-2 border-border text-center">
            <p class="text-sm font-bold text-text-muted lowercase tracking-tight">challora
                v<?php echo e($appVersion); ?> &nbsp;·&nbsp; no compromises in recruitment.
            </p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Entrance animation for main content
            gsap.from(".main-container", {
                opacity: 0,
                y: 20,
                duration: 0.8,
                ease: "power3.out"
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\challorav2\resources\views/layouts/app.blade.php ENDPATH**/ ?>