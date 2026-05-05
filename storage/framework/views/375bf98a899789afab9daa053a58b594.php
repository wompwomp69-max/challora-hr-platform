<?php $__env->startPush('styles'); ?>
<style>
    .candidate-show-container {
        padding: 60px 0;
    }
    .hero-glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 4px solid black;
        box-shadow: 12px 12px 0 black;
        padding: 60px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }
    .hero-glass::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 8px;
        background: var(--color-accent);
    }
    .candidate-name-giant {
        font-size: 80px;
        font-weight: 800;
        letter-spacing: -4px;
        line-height: 0.9;
        margin-bottom: 24px;
    }
    .meta-tags-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 32px;
    }
    .tag-brutalist {
        background: black;
        color: white;
        padding: 8px 16px;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        border: 2px solid white;
    }
    .profile-grid-premium {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 60px;
    }
    .section-premium {
        background: var(--color-surface);
        border: 4px solid black;
        box-shadow: 8px 8px 0 black;
        padding: 48px;
        margin-bottom: 48px;
    }
    .section-label-giant {
        font-size: 40px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 32px;
        border-bottom: 8px solid var(--color-accent);
        display: inline-block;
    }
    .biodata-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }
    .info-item label {
        display: block;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        color: var(--color-text-muted);
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }
    .info-item span {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text);
    }
    .ai-score-card {
        background: black;
        color: white;
        padding: 40px;
        text-align: center;
        border: 4px solid var(--color-accent);
        margin-bottom: 32px;
    }
    .ai-score-number {
        font-size: 80px;
        font-weight: 900;
        color: var(--color-accent);
        line-height: 1;
    }
    .ai-label {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 14px;
        margin-top: 8px;
    }
    .pro-con-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 32px;
    }
    .pro-box { border-left: 8px solid #4ade80; padding-left: 20px; }
    .con-box { border-left: 8px solid #f87171; padding-left: 20px; }
    .box-title { font-weight: 900; text-transform: uppercase; font-size: 12px; margin-bottom: 12px; }
    .box-list { font-size: 15px; color: var(--color-text-muted); }
    
    .timeline-item {
        border-left: 4px solid black;
        padding-left: 24px;
        padding-bottom: 32px;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -12px; top: 0;
        width: 20px; height: 20px;
        background: var(--color-accent);
        border: 4px solid black;
    }
    .timeline-date { font-weight: 800; font-size: 12px; color: var(--color-accent); margin-bottom: 4px; }
    .timeline-title { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
    .timeline-subtitle { font-weight: 700; color: var(--color-text-muted); margin-bottom: 12px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="candidate-show-container">
    <a href="<?php echo e(route('hr.applications.index')); ?>" class="inline-flex items-center gap-2 font-black uppercase text-xs tracking-widest mb-8 hover:text-accent transition-colors">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Pipeline
    </a>

    <div class="hero-glass gsap-hero">
        <h1 class="candidate-name-giant"><?php echo e($data->candidate['name']); ?></h1>
        <p class="text-2xl font-bold text-text-muted">Candidate for: <span class="text-accent"><?php echo e($data->job['title']); ?></span></p>
        
        <div class="meta-tags-flex">
            <span class="tag-brutalist"><?php echo e($data->candidate['email']); ?></span>
            <span class="tag-brutalist"><?php echo e($data->candidate['phone'] ?: 'No Phone'); ?></span>
            <span class="tag-brutalist"><?php echo e($data->candidate['gender'] ?: 'Unspecified'); ?></span>
            <span class="tag-brutalist"><?php echo e($data->candidate['address']); ?></span>
        </div>
    </div>

    <div class="profile-grid-premium">
        <div class="main-details">
            <!-- Biodata Section -->
            <div class="section-premium gsap-section">
                <h2 class="section-label-giant">Full Biodata</h2>
                <div class="biodata-grid">
                    <div class="info-item">
                        <label>Birth Info</label>
                        <span><?php echo e($data->candidate['birth_place'] ?: '-'); ?>, <?php echo e($data->candidate['birth_date'] ?: '-'); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Marital Status</label>
                        <span><?php echo e($data->candidate['marital_status'] ?: '-'); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Religion</label>
                        <span><?php echo e($data->candidate['religion'] ?: '-'); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Education</label>
                        <span><?php echo e($data->candidate['education_level']); ?> - <?php echo e($data->candidate['education_university']); ?> (Graduated: <?php echo e($data->candidate['graduation_year']); ?>)</span>
                    </div>
                    <div class="info-item">
                        <label>Major</label>
                        <span><?php echo e($data->candidate['education_major']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Experience Section -->
            <div class="section-premium gsap-section">
                <h2 class="section-label-giant">Career History</h2>
                <?php $__empty_1 = true; $__currentLoopData = $data->candidate['experiences']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo e($exp->year_start); ?> — <?php echo e($exp->year_end ?: 'Present'); ?></div>
                        <div class="timeline-title"><?php echo e($exp->title); ?></div>
                        <div class="timeline-subtitle"><?php echo e($exp->company_name); ?></div>
                        <p class="text-text-muted"><?php echo e($exp->description); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="font-bold text-text-muted italic">No work experience listed.</p>
                <?php endif; ?>
            </div>

            <!-- Organization Section -->
            <div class="section-premium gsap-section">
                <h2 class="section-label-giant">Organizational Experience</h2>
                <?php $__empty_1 = true; $__currentLoopData = $data->candidate['org_experiences']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo e($org->start_year); ?> — <?php echo e($org->year_end ?: 'Present'); ?></div>
                        <div class="timeline-title"><?php echo e($org->position); ?></div>
                        <div class="timeline-subtitle"><?php echo e($org->organization_name); ?></div>
                        <p class="text-text-muted"><?php echo e($org->description); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="font-bold text-text-muted italic">No organizational experience listed.</p>
                <?php endif; ?>
            </div>

            <!-- Achievements Section -->
            <div class="section-premium gsap-section">
                <h2 class="section-label-giant">Achievements</h2>
                <div class="grid grid-cols-1 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $data->candidate['achievements']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-6 border-2 border-black bg-secondary">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-black text-xl"><?php echo e($ach->title); ?></h4>
                                <div class="flex gap-2">
                                    <span class="bg-gray-800 text-white px-2 py-1 text-[10px] font-black uppercase"><?php echo e($ach->level); ?></span>
                                    <span class="bg-accent text-white px-2 py-1 text-[10px] font-black uppercase"><?php echo e($ach->type); ?></span>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-text-muted"><?php echo e($ach->organizer); ?> (<?php echo e($ach->year); ?>)</p>
                            <p class="mt-2"><?php echo e($ach->description); ?></p>
                            <?php if($ach->certificate_link): ?>
                                <a href="<?php echo e($ach->certificate_link); ?>" target="_blank" class="inline-flex items-center gap-2 mt-4 text-xs font-black uppercase text-accent hover:underline">
                                    <i class="bi bi-patch-check-fill"></i>
                                    View Certificate Proof
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="font-bold text-text-muted italic">No achievements listed.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <aside class="ai-intelligence-sidebar">
            <div class="ai-score-card gsap-sidebar">
                <div class="ai-label">AI Match Score</div>
                <div class="ai-score-number"><?php echo e($data->ai['score_total']); ?></div>
                <div class="ai-label text-accent">Confidence: <?php echo e($data->ai['confidence']); ?>%</div>
            </div>

            <div class="section-premium gsap-sidebar">
                <h3 class="box-title">AI Analysis</h3>
                <p class="text-sm italic text-text-muted mb-6">"<?php echo e($data->ai['summary_text'] ?: 'Analysis pending...'); ?>"</p>
                
                <div class="pro-con-grid">
                    <div class="pro-box">
                        <div class="box-title text-green-600">Strengths</div>
                        <?php $__currentLoopData = $data->ai['pros']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-xs font-bold mb-2">✓ <?php echo e($pro); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="con-box">
                        <div class="box-title text-red-600">Risks</div>
                        <?php $__currentLoopData = $data->ai['cons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-xs font-bold mb-2">! <?php echo e($con); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="section-premium gsap-sidebar">
                <h3 class="box-title">Supporting Files</h3>
                <div class="grid grid-cols-1 gap-4 mt-6">
                    <?php if($data->candidate['cv_path']): ?>
                        <a href="<?php echo e(route('view.document', ['type' => 'cv', 'id' => $data->application_id])); ?>" class="flex items-center gap-3 p-4 border-2 border-black hover:bg-accent hover:text-white transition-all no-underline">
                            <i class="bi bi-file-earmark-person text-2xl"></i>
                            <span class="font-black uppercase text-xs">Curriculum Vitae</span>
                        </a>
                    <?php endif; ?>
                    <?php if($data->candidate['diploma_path']): ?>
                        <a href="<?php echo e(route('view.document', ['type' => 'diploma', 'id' => $data->application_id])); ?>" class="flex items-center gap-3 p-4 border-2 border-black hover:bg-accent hover:text-white transition-all no-underline">
                            <i class="bi bi-mortarboard text-2xl"></i>
                            <span class="font-black uppercase text-xs">Academic Diploma</span>
                        </a>
                    <?php endif; ?>
                    <?php if($data->candidate['photo_path']): ?>
                        <a href="<?php echo e(route('view.document', ['type' => 'photo', 'id' => $data->application_id])); ?>" class="flex items-center gap-3 p-4 border-2 border-black hover:bg-accent hover:text-white transition-all no-underline">
                            <i class="bi bi-image text-2xl"></i>
                            <span class="font-black uppercase text-xs">Formal Photo</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.from(".gsap-hero", { opacity: 0, y: 40, duration: 1, ease: "power4.out" });
        gsap.from(".gsap-section", { opacity: 0, x: -40, stagger: 0.2, duration: 1, ease: "power4.out", delay: 0.3 });
        gsap.from(".gsap-sidebar", { opacity: 0, x: 40, stagger: 0.2, duration: 1, ease: "power4.out", delay: 0.5 });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\challora-hr-platform-4.2.2\resources\views/hr/candidates/show.blade.php ENDPATH**/ ?>