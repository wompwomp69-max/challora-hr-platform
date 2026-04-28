<?php $__env->startSection('content'); ?>
    <div class="edit-container">
        <div class="edit-hero">
            <h1 class="edit-title">Profile Settings</h1>
        </div>

        <!-- Avatar Upload -->
        <div class="avatar-upload-hero">
            <div class="avatar-preview-lg">
                <?php if(auth()->user()->avatar_path): ?>
                    <img src="<?php echo e(route('avatar')); ?>" alt="Avatar" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-4xl font-black text-accent opacity-20">
                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-1">
                <h3 class="font-black text-lg uppercase tracking-widest mb-2">Profile Photo</h3>
                <p class="text-sm font-bold text-text-muted mb-4">Upload a formal photo to improve your credibility (Max.
                    1MB).</p>
                <form action="<?php echo e(route('user.settings.avatar')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="flex gap-4">
                        <input type="file" name="avatar" class="form-input text-xs" required accept="image/*">
                        <button type="submit" class="btn-submit py-2 px-6 text-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Profile Form -->
        <form method="post" action="<?php echo e(route('user.settings.update')); ?>">
            <?php echo csrf_field(); ?>

            <div class="edit-section" id="personal">
                <h2 class="edit-section-title">
                    <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" required value="<?php echo e(old('name', $user->name)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input opacity-50 cursor-not-allowed" value="<?php echo e($user->email); ?>"
                            readonly disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="<?php echo e(old('phone', $user->phone)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">— Select —</option>
                            <option value="laki-laki" <?php echo e($user->gender === 'laki-laki' ? 'selected' : ''); ?>>Male</option>
                            <option value="perempuan" <?php echo e($user->gender === 'perempuan' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Full Address</label>
                    <textarea name="address" class="form-textarea" rows="2"><?php echo e(old('address', $user->address)); ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Professional Summary</label>
                    <textarea name="user_summary" class="form-textarea"
                        rows="4"><?php echo e(old('user_summary', $user->user_summary)); ?></textarea>
                </div>
            </div>

            <div class="edit-section" id="education">
                <h2 class="edit-section-title">
                    <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    Education History
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">University / Institution</label>
                        <input type="text" name="education_university" class="form-input"
                            value="<?php echo e(old('education_university', $user->education_university)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Major</label>
                        <input type="text" name="education_major" class="form-input"
                            value="<?php echo e(old('education_major', $user->education_major)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Education Level</label>
                        <select name="education_level" class="form-select">
                            <option value="">— Select —</option>
                            <?php $__currentLoopData = \App\Enums\EducationLevel::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($level->value); ?>" <?php echo e($user->education_level === $level->value ? 'selected' : ''); ?>><?php echo e($level->value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Graduation Year</label>
                        <input type="text" name="graduation_year" class="form-input"
                            value="<?php echo e(old('graduation_year', $user->graduation_year)); ?>">
                    </div>
                </div>
            </div>

            <!-- Experience Section with Dynamic Rows -->
            <div class="edit-section" id="work-experience">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Work Experience
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-exp">ADD NEW</button>
                </div>
                <div id="exp-container">
                    <?php $__currentLoopData = $user->workExperiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="work_title[]" class="form-input" placeholder="Job Title"
                                    value="<?php echo e($exp->title); ?>">
                                <input type="text" name="work_company[]" class="form-input" placeholder="Company Name"
                                    value="<?php echo e($exp->company_name); ?>">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="work_year_start[]" class="form-input" placeholder="Start Year"
                                    value="<?php echo e($exp->year_start); ?>">
                                <input type="text" name="work_year_end[]" class="form-input" placeholder="End Year"
                                    value="<?php echo e($exp->year_end); ?>">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black"
                                    onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="work_description[]" class="form-textarea"
                                placeholder="Job description..."><?php echo e($exp->description); ?></textarea>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="flex gap-4 mt-12 pb-12">
                <button type="submit" class="btn-submit">Save All Changes</button>
                <a href="<?php echo e(route('user.settings.index')); ?>" class="btn-cancel">Back to Profile</a>
            </div>
        </form>

        <!-- Document Upload Section -->
        <div class="edit-section" id="documents">
            <h2 class="edit-section-title">
                <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Supporting Documents
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php $__currentLoopData = ['cv' => 'CV / Resume', 'diploma' => 'Ijazah', 'photo' => 'Pas Foto Formal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-secondary p-6 border-2 border-dashed border-border flex flex-col justify-between">
                        <div>
                            <h4 class="font-black text-xs uppercase tracking-widest mb-1"><?php echo e($label); ?></h4>
                            <?php $field = $key . '_path'; ?>
                            <?php if($user->$field): ?>
                                <p class="text-[10px] font-bold text-success-text mb-4 uppercase">Terunggah &bull; <a
                                        href="<?php echo e(route('preview.user_file', ['type' => $key])); ?>" target="_blank"
                                        class="underline">Lihat</a></p>
                            <?php else: ?>
                                <p class="text-[10px] font-bold text-red-600 mb-4 uppercase">Belum Diunggah</p>
                            <?php endif; ?>
                        </div>
                        <form action="<?php echo e(route('user.settings.upload', $key)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="file" name="<?php echo e($key); ?>" class="hidden" id="file-<?php echo e($key); ?>"
                                onchange="this.form.submit()">
                            <label for="file-<?php echo e($key); ?>"
                                class="btn-cancel py-2 px-4 text-[10px] block text-center cursor-pointer">UPLOAD NEW</label>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <template id="exp-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="work_title[]" class="form-input" placeholder="Job Title">
                <input type="text" name="work_company[]" class="form-input" placeholder="Company Name">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="work_year_start[]" class="form-input" placeholder="Start Year">
                <input type="text" name="work_year_end[]" class="form-input" placeholder="End Year">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black"
                    onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="work_description[]" class="form-textarea" placeholder="Job description..."></textarea>
        </div>
    </template>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function initEditAnim() {
        if (!window.gsap) return setTimeout(initEditAnim, 50);

        const addExpBtn = document.getElementById('add-exp');
        if (addExpBtn && !addExpBtn.dataset.listenerAttached) {
            addExpBtn.dataset.listenerAttached = 'true';
            addExpBtn.addEventListener('click', () => {
                const container = document.getElementById('exp-container');
                const template = document.getElementById('exp-template');
                container.appendChild(template.content.cloneNode(true));
            });
        }

        window.gsap.killTweensOf(".edit-hero, .edit-section");
        window.gsap.fromTo(".edit-hero",
            { opacity: 0, x: -30 },
            { opacity: 1, x: 0, duration: 0.8, ease: "power4.out" }
        );
        window.gsap.fromTo(".edit-section",
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, stagger: 0.1, duration: 1, ease: "power4.out", delay: 0.2 }
        );
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\challorav2\resources\views/user/settings/edit.blade.php ENDPATH**/ ?>