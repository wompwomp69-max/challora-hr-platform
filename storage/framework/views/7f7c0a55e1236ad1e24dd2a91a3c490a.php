<header class="brutal-header">
    <div class="flex h-full items-center">
        <a href="<?php echo e(auth()->check() && auth()->user()->isAdmin() ? route('hr.dashboard') : route('landing')); ?>"
            class="brand-accent-box">
            <div class="brand-logo-c">C</div>
            <span class="brand-name-text">challora</span>
        </a>

        <nav class="ml-12 hidden md:flex items-center gap-8">
            <?php if(auth()->check() && auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('hr.dashboard')); ?>"
                    class="nav-link-image <?php echo e(request()->routeIs('hr.dashboard') ? 'active' : ''); ?>">
                    Analytics
                </a>
                <a href="<?php echo e(route('hr.jobs.index')); ?>"
                    class="nav-link-image <?php echo e(request()->routeIs('hr.jobs.*') ? 'active' : ''); ?>">
                    Positions
                </a>
                <a href="<?php echo e(route('hr.applications.index')); ?>"
                    class="nav-link-image <?php echo e(request()->routeIs('hr.applications.*') ? 'active' : ''); ?>">
                    Pipelines
                </a>
                <a href="#" class="nav-link-image opacity-50">
                    Intelligence
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('jobs.index')); ?>"
                    class="nav-link-image <?php echo e((request()->routeIs('jobs.*') || request()->routeIs('landing')) && !request()->routeIs('user.jobs.saved') ? 'active' : ''); ?>">
                    Job Listings
                </a>
                <a href="<?php echo e(route('user.applications.index')); ?>"
                    class="nav-link-image <?php echo e(request()->routeIs('user.applications.*') ? 'active' : ''); ?>">
                    Applied Jobs
                </a>
                <a href="<?php echo e(route('user.jobs.saved')); ?>"
                    class="nav-link-image <?php echo e(request()->routeIs('user.jobs.saved') ? 'active' : ''); ?>">
                    Saved Board
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="flex items-center gap-6 pr-4">
        <?php if(auth()->guard()->check()): ?>
            <div class="relative">
                <div class="user-nav-trigger" id="user-menu-toggle">
                    <div class="nav-avatar-inner"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></div>
                    <span class="text-xs font-bold text-white uppercase hidden sm:block"><?php echo e(auth()->user()->name); ?></span>
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="opacity-50">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </div>

                <div id="user-menu-dropdown" class="dropdown-menu-image hidden">
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('hr.dashboard')); ?>" class="dropdown-link-image">HR Dashboard</a>
                        <a href="<?php echo e(route('jobs.index')); ?>" class="dropdown-link-image">Candidate View</a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('user.settings.index')); ?>" class="dropdown-link-image">Settings</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-link-image w-full text-left font-bold text-accent-800">Sign
                            Out</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="signin-btn-image">
                SIGN IN
            </a>
        <?php endif; ?>
    </div>
</header>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('user-menu-toggle');
            const dropdown = document.getElementById('user-menu-dropdown');

            if (toggle && dropdown) {
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (dropdown.classList.contains('hidden')) {
                        dropdown.classList.remove('hidden');
                        gsap.fromTo(dropdown, { y: -10, opacity: 0 }, { y: 0, opacity: 1, duration: 0.2, ease: "power2.out" });
                    } else {
                        dropdown.classList.add('hidden');
                    }
                });

                document.addEventListener('click', () => {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\challorav2\resources\views/partials/navbar.blade.php ENDPATH**/ ?>