<?php $__env->startSection('content'); ?>
    <div class="profile-container">
        <a href="<?php echo e(route('user.settings.edit')); ?>" class="btn-edit-float">
            Edit My Profile
        </a>

        <header class="profile-header">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar-lg">
                    <?php if($user->avatar_path): ?>
                        <img src="<?php echo e(route('avatar')); ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-8xl font-black text-accent opacity-20"><?php echo e(substr($user->name, 0, 1)); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile-name-section">
                <h1 class="profile-name"><?php echo e($user->name); ?></h1>
                <div class="flex items-center gap-3">
                    <span class="profile-role-badge">Candidate</span>
                    <span class="text-sm font-bold text-text-muted italic"><?php echo e($user->email); ?></span>
                </div>
            </div>
        </header>

        <div class="profile-grid">
            <div class="profile-main">
                <?php if($user->user_summary): ?>
                    <section class="info-card">
                        <h2 class="info-card-title">Professional Summary</h2>
                        <p class="summary-text"><?php echo e($user->user_summary); ?></p>
                    </section>
                <?php endif; ?>

                <section class="info-card">
                    <h2 class="info-card-title">Personal Data</h2>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="data-row">
                            <span class="data-label">Phone</span>
                            <span class="data-value"><?php echo e($user->phone ?? '—'); ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Gender</span>
                            <span
                                class="data-value"><?php echo e($user->gender ? ($user->gender === 'laki-laki' ? 'Male' : 'Female') : '—'); ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Address</span>
                            <span class="data-value"><?php echo e($user->address ?? '—'); ?></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Religion</span>
                            <span class="data-value"><?php echo e($user->religion ?? '—'); ?></span>
                        </div>
                    </div>
                </section>

                <section class="info-card">
                    <h2 class="info-card-title">Education</h2>
                    <?php if($user->education_university): ?>
                        <div class="data-row">
                            <span class="data-label"><?php echo e($user->education_level); ?> in <?php echo e($user->education_major); ?></span>
                            <span class="data-value text-2xl"><?php echo e($user->education_university); ?></span>
                            <span class="text-sm font-bold text-accent">Class of <?php echo e($user->graduation_year); ?></span>
                        </div>
                    <?php else: ?>
                        <p class="text-text-muted italic font-bold">No education history added yet.</p>
                    <?php endif; ?>
                </section>

                <section class="info-card">
                    <h2 class="info-card-title">Work Experience</h2>
                    <?php $__empty_1 = true; $__currentLoopData = $user->workExperiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="experience-item">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-black uppercase"><?php echo e($exp->title); ?></h3>
                                    <p class="text-accent font-bold"><?php echo e($exp->company_name); ?></p>
                                </div>
                                <span class="bg-black text-white px-3 py-1 text-xs font-black">
                                    <?php echo e($exp->year_start); ?> — <?php echo e($exp->year_end); ?>

                                </span>
                            </div>
                            <p class="mt-4 text-text-muted font-medium"><?php echo e($exp->description); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-text-muted italic font-bold">No work experience added yet.</p>
                    <?php endif; ?>
                </section>
            </div>

            <aside class="profile-sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Supporting Documents</h3>
                    <?php $__currentLoopData = ['cv' => 'CV / Resume', 'diploma' => 'Educational Diploma', 'photo' => 'Formal Photo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $field = $key . '_path'; ?>
                        <?php if($user->$field): ?>
                            <a href="<?php echo e(route('preview.user_file', ['type' => $key])); ?>" target="_blank" class="doc-link">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="font-bold uppercase text-xs"><?php echo e($label); ?></span>
                            </a>
                        <?php else: ?>
                            <div class="doc-link opacity-40 grayscale">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="font-bold uppercase text-xs"><?php echo e($label); ?> (Empty)</span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="info-card bg-secondary border-dashed">
                    <h3 class="font-black uppercase text-xs mb-4">Account Stats</h3>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between border-b border-border pb-2">
                            <span class="text-[10px] font-black uppercase text-text-muted">Applications</span>
                            <span class="font-black text-accent"><?php echo e($user->applications()->count()); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-border pb-2">
                            <span class="text-[10px] font-black uppercase text-text-muted">Saved Jobs</span>
                            <span class="font-black text-accent"><?php echo e($user->savedJobs()->count()); ?></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        (function initIndexAnim() {
            if (!window.gsap) return setTimeout(initIndexAnim, 50);

            // Kill existing animations on these targets to prevent conflicts when Swup re-navigates
            window.gsap.killTweensOf(".profile-header, .info-card, .profile-sidebar, .btn-edit-float");

            window.gsap.fromTo(".profile-header",
                { opacity: 0, x: -50 },
                { opacity: 1, x: 0, duration: 1, ease: "power4.out" }
            );
            window.gsap.fromTo(".info-card",
                { opacity: 0, y: 40 },
                { opacity: 1, y: 0, stagger: 0.15, duration: 1.2, ease: "power4.out", delay: 0.2 }
            );
            window.gsap.fromTo(".profile-sidebar",
                { opacity: 0, x: 50 },
                { opacity: 1, x: 0, duration: 1, ease: "power4.out", delay: 0.5 }
            );
            window.gsap.fromTo(".btn-edit-float",
                { scale: 0 },
                { scale: 1, duration: 0.6, ease: "back.out(1.7)", delay: 1 }
            );
        })();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\challorav2\resources\views/user/settings/index.blade.php ENDPATH**/ ?>