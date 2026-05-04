<?php $__env->startPush('styles'); ?>
<style>
    .hr-header-premium {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 60px;
        border-bottom: 2px solid var(--color-border);
        padding-bottom: 32px;
    }
    .hr-title-giant {
        font-size: 64px;
        font-weight: 800;
        letter-spacing: -4px;
        line-height: 1;
        color: var(--color-text);
    }
    .hr-subtitle {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text-muted);
        margin-top: 12px;
    }
    .hr-card-table {
        background: var(--color-surface);
        border: 4px solid black;
        box-shadow: 10px 10px 0 black;
        overflow: hidden;
        border-radius: 0;
    }
    .ax-premium-table {
        width: 100%;
        border-collapse: collapse;
    }
    .ax-premium-table thead th {
        background: var(--color-secondary);
        padding: 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--color-text-muted);
        border-bottom: 2px solid var(--color-border);
    }
    .ax-premium-table tbody td {
        padding: 32px 24px;
        border-bottom: 1px solid var(--color-border);
        vertical-align: middle;
    }
    .applicant-name {
        font-size: 20px;
        font-weight: 800;
        color: var(--color-text);
        letter-spacing: -0.5px;
    }
    .applicant-contact {
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-muted);
    }
    .status-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        border: 2px solid black;
    }
    .status-accepted { background: #4ade80; color: black; }
    .status-rejected { background: #f87171; color: black; }
    .status-pending { background: #fbbf24; color: black; }
    
    .action-select-premium {
        background: var(--color-surface);
        border: 4px solid black;
        padding: 12px 16px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        cursor: pointer;
        box-shadow: 4px 4px 0 black;
    }
    .action-select-premium:focus {
        border-color: var(--color-accent);
        outline: none;
    }
    .premium-btn-icon {
        background: black;
        color: white;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        box-shadow: 4px 4px 0 var(--color-accent);
        text-decoration: none;
        transition: all 0.1s;
    }
    .premium-btn-icon:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 var(--color-accent);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="hr-header-premium">
    <div class="gsap-reveal">
        <h1 class="hr-title-giant">Talent Pipeline</h1>
        <p class="hr-subtitle">Review and manage candidate applications across all postings.</p>
    </div>
    <div class="flex gap-4 gsap-reveal">
        <form action="<?php echo e(route('hr.applications.index')); ?>" method="GET" class="flex gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-black uppercase text-text-muted">Job Posting</label>
                <select name="job_id" class="action-select-premium" onchange="this.form.submit()">
                    <option value="">All Positions</option>
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($job->id); ?>" <?php echo e(request('job_id') == $job->id ? 'selected' : ''); ?>>
                            <?php echo e($job->title); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-black uppercase text-text-muted">Status</label>
                <select name="status" class="action-select-premium" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = \App\Enums\ApplicationStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') === $status->value ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($status->value)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-black uppercase text-text-muted">Sort by Rating</label>
                <select name="sort_rating" class="action-select-premium" onchange="this.form.submit()">
                    <option value="">Newest First</option>
                    <option value="high" <?php echo e(request('sort_rating') === 'high' ? 'selected' : ''); ?>>High to Low</option>
                    <option value="low" <?php echo e(request('sort_rating') === 'low' ? 'selected' : ''); ?>>Low to High</option>
                </select>
            </div>
        </form>
    </div>
</div>

<?php if($applications->isEmpty()): ?>
    <div class="py-24 text-center bg-secondary border-2 border-dashed border-border gsap-reveal">
        <i class="bi bi-person-slash text-6xl text-border mb-6 block"></i>
        <h3 class="font-black text-3xl">No Applicants Found</h3>
        <p class="text-text-muted font-bold mt-2">Try adjusting your filters or wait for new submissions.</p>
    </div>
<?php else: ?>
    <div class="hr-card-table gsap-reveal">
        <table class="ax-premium-table">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Applied For</th>
                    <th>AI Score</th>
                    <th>Status</th>
                    <th>Files</th>
                    <th class="text-right">Intelligence Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="applicant-name"><?php echo e($a->user->name); ?></div>
                            <?php if(($topApplicationId ?? null) === $a->id): ?>
                                <div class="text-[10px] font-black uppercase text-accent mt-1">Top Candidate</div>
                            <?php endif; ?>
                            <div class="applicant-contact"><?php echo e($a->user->email); ?></div>
                        </td>
                        <td>
                            <div class="font-bold uppercase text-xs tracking-widest text-accent"><?php echo e($a->job->title); ?></div>
                            <div class="text-[10px] font-bold text-text-muted mt-1"><?php echo e($a->created_at->format('d M Y')); ?></div>
                        </td>
                        <td>
                            <?php if($a->aiScore && $a->aiScore->status === 'completed'): ?>
                                <div class="font-black text-xl"><?php echo e($a->aiScore->score_total); ?>/100</div>
                                <div class="text-[10px] font-bold uppercase text-text-muted mt-1"><?php echo e($a->aiScore->core_strength); ?></div>
                            <?php elseif($a->aiScore && $a->aiScore->status === 'failed'): ?>
                                <span class="text-red-500 font-bold text-xs uppercase">AI Failed</span>
                            <?php else: ?>
                                <div class="flex flex-col items-center">
                                    <div class="h-6 w-6 border-4 border-accent border-t-transparent rounded-full animate-spin"></div>
                                    <span class="text-yellow-600 font-bold text-[10px] uppercase mt-2 animate-pulse">Analyzing...</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge-premium status-<?php echo e($a->status->value); ?>">
                                <?php echo e($a->status->value); ?>

                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <?php if($a->user->cv_path): ?>
                                    <a href="<?php echo e(route('download.file', ['type' => 'cv', 'id' => $a->id, 'back' => url()->current()])); ?>" class="premium-btn-icon" title="CV">
                                        <i class="bi bi-file-earmark-person"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($a->user->diploma_path): ?>
                                    <a href="<?php echo e(route('download.file', ['type' => 'diploma', 'id' => $a->id, 'back' => url()->current()])); ?>" class="premium-btn-icon" title="Ijazah">
                                        <i class="bi bi-mortarboard"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($a->user->photo_path): ?>
                                    <a href="<?php echo e(route('download.file', ['type' => 'photo', 'id' => $a->id, 'back' => url()->current()])); ?>" class="premium-btn-icon" title="Foto Formal">
                                        <i class="bi bi-image"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end items-center gap-4">
                            <a href="<?php echo e(route('hr.applications.berkas', $a->id)); ?>" class="action-select-premium" style="text-decoration:none;">
                                View Biodata
                            </a>
                            <form method="post" action="<?php echo e(route('hr.applications.ai_refresh', $a->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="action-select-premium" type="submit">Refresh AI</button>
                            </form>
                            <form method="post" action="<?php echo e(route('hr.applications.status', $a->id)); ?>" class="flex justify-end items-center gap-4">
                                <?php echo csrf_field(); ?>
                                <select name="status" class="action-select-premium" onchange="this.form.submit()">
                                    <?php $__currentLoopData = \App\Enums\ApplicationStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->value); ?>" <?php echo e($a->status === $status ? 'selected' : ''); ?>>
                                            Mark as <?php echo e(ucfirst($status->value)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-8">
        <?php echo e($applications->links()); ?>

    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.from(".gsap-reveal", {
            opacity: 0,
            y: 30,
            stagger: 0.15,
            duration: 1,
            ease: "power4.out"
        });
        
        gsap.from(".ax-premium-table tbody tr", {
            opacity: 0,
            x: -20,
            stagger: 0.05,
            duration: 0.8,
            ease: "power3.out",
            delay: 0.4
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\challora-hr-platform-4.1.17\resources\views/hr/applications/index.blade.php ENDPATH**/ ?>