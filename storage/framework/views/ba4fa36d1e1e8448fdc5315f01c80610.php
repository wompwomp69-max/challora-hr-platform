<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($pageTitle ?? config('app.name', 'Challora')); ?></title>

    <!-- Token tema (warna, font, radius) -->
    <link rel="stylesheet" href="<?php echo e(asset('css/design-tokens.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Vite Assets (Tailwind & JS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700;800&display=swap"
        rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.jsx']); ?>

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

        <footer class="bg-accent border-t border-black pt-10">
            <!-- LAYER 1: CONTACT & CTA (Orange BG, Black Text) -->
            <div class="px-8 md:px-20 pb-10 border-b border-black text-black">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Left: Contact info -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="col-span-full mb-4">
                            <h2 class="font-mono text-xl font-bold uppercase leading-tight">GET IN TOUCH<br>TO LEARN MORE.</h2>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase font-bold mb-1 opacity-70">GENERAL INQUIRIES</p>
                            <p class="font-bold text-lg leading-tight hover:underline cursor-pointer">info@challora.id</p>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase font-bold mb-1 opacity-70">SUPPORT</p>
                            <p class="font-bold text-lg leading-tight hover:underline cursor-pointer">support@challora.id</p>
                        </div>
                        <div>
                            <p class="font-mono text-xs uppercase font-bold mb-1 opacity-70">PRESS</p>
                            <p class="font-bold text-lg leading-tight hover:underline cursor-pointer">press@challora.id</p>
                        </div>
                    </div>
                    
                    <!-- Right: Newsletter -->
                    <div class="flex flex-col justify-end">
                        <p class="font-mono text-xs uppercase font-bold mb-2 opacity-70">SIGN UP FOR UPDATES</p>
                        <div class="flex items-center border-b-2 border-black pb-2">
                            <input type="email" placeholder="Enter your email address" class="bg-transparent border-none outline-none text-xl sm:text-2xl font-bold placeholder-black/50 w-full text-black">
                            <button class="bg-black text-accent font-mono text-xs font-bold uppercase rounded-full px-6 py-3 ml-4 hover:bg-white hover:text-black transition-colors whitespace-nowrap">
                                SUBSCRIBE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LAYER 2: THE CONTROL CENTER -->
            <div class="bg-[#1A1A1A] text-white rounded-[48px] m-4 md:m-8 p-10 md:p-20 relative overflow-hidden flex flex-col justify-between" style="min-height: 60vh;">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 relative z-10 mb-20">
                    <!-- Col 1: Logo -->
                    <div class="text-accent">
                        <div class="w-16 h-16 border-4 border-accent flex items-center justify-center font-black text-4xl">C</div>
                    </div>
                    
                    <!-- Col 2: Platform -->
                    <div>
                        <a href="<?php echo e(route('jobs.index')); ?>" class="text-accent font-bold text-xl hover:text-white transition-colors block mb-4">Platform</a>
                    </div>

                    <!-- Col 3: Solutions -->
                    <div>
                        <h3 class="font-mono text-xs uppercase tracking-widest text-[#888] mb-6 flex items-start gap-1">Platform <span class="text-[8px]">4</span></h3>
                        <ul class="space-y-4 font-bold text-base">
                            <li><a href="<?php echo e(route('jobs.index')); ?>" class="hover:text-accent transition-colors">↳ Browse Jobs</a></li>
                            <li><a href="<?php echo e(route('register')); ?>" class="hover:text-accent transition-colors">↳ Post a Job</a></li>
                            <li><a href="<?php echo e(route('register')); ?>" class="hover:text-accent transition-colors">↳ For Candidates</a></li>
                            <li><a href="<?php echo e(route('register')); ?>" class="hover:text-accent transition-colors">↳ For HR Teams</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: About -->
                    <div>
                        <h3 class="font-mono text-xs uppercase tracking-widest text-[#888] mb-6 flex items-start gap-1">Account <span class="text-[8px]">2</span></h3>
                        <ul class="space-y-4 font-bold text-base">
                            <li><a href="<?php echo e(route('login')); ?>" class="hover:text-accent transition-colors">↳ Sign In</a></li>
                            <li><a href="<?php echo e(route('register')); ?>" class="hover:text-accent transition-colors">↳ Register</a></li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-end relative z-10 font-mono text-xs text-[#888] uppercase mb-10 md:mb-16">
                    <div class="flex items-center gap-3">
                        <span>BUILT FOR THE FUTURE OF WORK.</span>
                    </div>
                    <div class="text-left md:text-right mt-8 md:mt-0">
                        <p>CHALLORA &nbsp;·&nbsp; v<?php echo e($appVersion); ?></p>
                    </div>
                </div>

                <!-- Mega Wordmark -->
                <div class="text-[15vw] leading-[0.7] font-black text-center tracking-tighter text-[#2a2a2a] select-none absolute bottom-[-2vw] left-0 w-full pointer-events-none">
                    CHALLORA
                </div>
            </div>

            <!-- LAYER 3: LEGAL STRIP -->
            <div class="bg-accent border-t border-black py-4 px-8 md:px-20 text-black font-mono text-xs font-bold uppercase flex flex-col md:flex-row justify-between items-center gap-4">
                <div>©2026 CHALLORA, INC.</div>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="#" class="hover:underline">LICENSE AGREEMENT</a>
                    <a href="#" class="hover:underline">PRIVACY POLICY</a>
                    <a href="#" class="hover:underline">TERMS OF USE</a>
                </div>
            </div>
        </footer>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.from(".main-container", {
                    opacity: 0,
                    y: 20,
                    duration: 0.8,
                    ease: "power3.out"
                });
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\challora-hr-platform-4.2.2\resources\views/layouts/app.blade.php ENDPATH**/ ?>