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
                    <div class="form-group">
                        <label class="form-label">Birth Place</label>
                        <input type="text" name="birth_place" class="form-input" value="<?php echo e(old('birth_place', $user->birth_place)); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" class="form-input" value="<?php echo e(old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Religion</label>
                        <select name="religion" class="form-select">
                            <option value="">— Select —</option>
                            <?php $__currentLoopData = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r); ?>" <?php echo e($user->religion === $r ? 'selected' : ''); ?>><?php echo e($r); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select">
                            <option value="">— Select —</option>
                            <?php $__currentLoopData = ['Lajang', 'Menikah', 'Cerai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m); ?>" <?php echo e($user->marital_status === $m ? 'selected' : ''); ?>><?php echo e($m); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

            <!-- Achievements Section -->
            <div class="edit-section" id="achievements">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Achievements
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-ach">ADD NEW</button>
                </div>
                <div id="ach-container">
                    <?php $__currentLoopData = $user->achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="ach_title[]" class="form-input" placeholder="Achievement Title" value="<?php echo e($ach->title); ?>">
                                <select name="ach_type[]" class="form-select">
                                    <option value="Sertifikat" <?php echo e($ach->type === 'Sertifikat' ? 'selected' : ''); ?>>Certificate</option>
                                    <option value="Penghargaan" <?php echo e($ach->type === 'Penghargaan' ? 'selected' : ''); ?>>Award</option>
                                    <option value="Lomba" <?php echo e($ach->type === 'Lomba' ? 'selected' : ''); ?>>Competition</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="ach_organizer[]" class="form-input" placeholder="Organizer" value="<?php echo e($ach->organizer); ?>">
                                <input type="text" name="ach_year[]" class="form-input" placeholder="Year" value="<?php echo e($ach->year); ?>">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="ach_level[]" class="form-input" placeholder="Level (e.g. Nasional)" value="<?php echo e($ach->level); ?>">
                                <input type="text" name="ach_certificate_link[]" class="form-input" placeholder="Certificate Link / URL" value="<?php echo e($ach->certificate_link); ?>">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="ach_description[]" class="form-textarea" placeholder="Description..."><?php echo e($ach->description); ?></textarea>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Organizational Experience Section -->
            <div class="edit-section" id="org-experience">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="edit-section-title" style="margin:0;">
                        <svg width="20" height="20" class="text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Organizational Experience
                    </h2>
                    <button type="button" class="btn-cancel py-1 px-4 text-xs tracking-widest" id="add-org">ADD NEW</button>
                </div>
                <div id="org-container">
                    <?php $__currentLoopData = $user->organizationalExperiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <input type="text" name="org_name[]" class="form-input" placeholder="Organization Name" value="<?php echo e($org->organization_name); ?>">
                                <input type="text" name="org_position[]" class="form-input" placeholder="Position / Role" value="<?php echo e($org->position); ?>">
                            </div>
                            <div class="flex gap-4 w-full">
                                <input type="text" name="org_year_start[]" class="form-input" placeholder="Start Year" value="<?php echo e($org->start_year); ?>">
                                <input type="text" name="org_year_end[]" class="form-input" placeholder="End Year" value="<?php echo e($org->year_end); ?>">
                                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
                            </div>
                            <textarea name="org_description[]" class="form-textarea" placeholder="Describe your role and impact..."><?php echo e($org->description); ?></textarea>
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
                                        href="<?php echo e(route('view.document', ['type' => $key])); ?>"
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

    <template id="ach-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="ach_title[]" class="form-input" placeholder="Achievement Title">
                <select name="ach_type[]" class="form-select">
                    <option value="Sertifikat">Certificate</option>
                    <option value="Penghargaan">Award</option>
                    <option value="Lomba">Competition</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="ach_organizer[]" class="form-input" placeholder="Organizer">
                <input type="text" name="ach_year[]" class="form-input" placeholder="Year">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="ach_level[]" class="form-input" placeholder="Level (e.g. Nasional)">
                <input type="text" name="ach_certificate_link[]" class="form-input" placeholder="Certificate Link / URL">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="ach_description[]" class="form-textarea" placeholder="Description..."></textarea>
        </div>
    </template>

    <template id="org-template">
        <div class="dynamic-list-item flex-col items-start gap-4 mb-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <input type="text" name="org_name[]" class="form-input" placeholder="Organization Name">
                <input type="text" name="org_position[]" class="form-input" placeholder="Position / Role">
            </div>
            <div class="flex gap-4 w-full">
                <input type="text" name="org_year_start[]" class="form-input" placeholder="Start Year">
                <input type="text" name="org_year_end[]" class="form-input" placeholder="End Year">
                <button type="button" class="bg-red-600 text-white px-4 border-2 border-black" onclick="this.parentElement.parentElement.remove()">X</button>
            </div>
            <textarea name="org_description[]" class="form-textarea" placeholder="Describe your role and impact..."></textarea>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const setupAddButton = (btnId, containerId, templateId) => {
                const btn = document.getElementById(btnId);
                const container = document.getElementById(containerId);
                const template = document.getElementById(templateId);
                
                if (btn && container && template) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const clone = template.content.cloneNode(true);
                        container.appendChild(clone);
                    });
                }
            };

            setupAddButton('add-exp', 'exp-container', 'exp-template');
            setupAddButton('add-ach', 'ach-container', 'ach-template');
            setupAddButton('add-org', 'org-container', 'org-template');

            if (window.gsap) {
                gsap.fromTo(".edit-hero", { opacity: 0, x: -30 }, { opacity: 1, x: 0, duration: 0.8, ease: "power4.out" });
                gsap.fromTo(".edit-section", { opacity: 0, y: 30 }, { opacity: 1, y: 0, stagger: 0.1, duration: 1, ease: "power4.out", delay: 0.2 });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\challora-hr-platform-4.2.2\resources\views/user/settings/edit.blade.php ENDPATH**/ ?>