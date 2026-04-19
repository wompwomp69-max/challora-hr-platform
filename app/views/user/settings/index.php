<?php
$maritalLabels = ['single' => 'single', 'married' => 'married', 'divorced' => 'divorced', 'widowed' => 'widowed'];
$religionLabels = ['islam' => 'islam', 'katolik' => 'catholic', 'kristen' => 'christian', 'hindu' => 'hindu', 'buddha' => 'buddhist', 'konghucu' => 'confucian', 'lainnya' => 'other'];
$genderLabels = ['male' => 'male', 'female' => 'female', 'other' => 'other'];
$genderLabel = $genderLabels[(string) ($user['gender'] ?? '')] ?? '-';
$profileAvatarSrc = currentUserAvatarImgSrc();
$profileInitial = mb_strtoupper(mb_substr($user['name'] ?? 'U', 0, 1));
$formatDocUploadedAt = static function (?string $relativePath): string {
    if (empty($relativePath)) return '-';
    $fullPath = BASE_PATH . '/' . ltrim($relativePath, '/');
    if (!is_file($fullPath)) return '-';
    $ts = @filemtime($fullPath);
    if ($ts === false) return '-';
    return date('d/m/Y H:i', $ts);
};
?>
<style>
/* Brutalist Settings Overrides */
.brutalist-title {
    font-size: 56px;
    font-weight: 600;
    letter-spacing: -2px;
    color: var(--color-text-muted);
    margin-bottom: 40px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--color-border);
}
.brutalist-block {
    background: transparent;
    border: 1px solid var(--color-border);
    padding: 32px;
    margin-bottom: 32px;
}
.brutalist-block-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--color-border);
    padding-bottom: 16px;
    margin-bottom: 32px;
}
.brutalist-block-title {
    font-size: 24px;
    font-weight: 500;
    color: var(--color-text);
    text-transform: lowercase;
}
.brutalist-btn {
    display: inline-block;
    background: var(--color-accent);
    color: var(--color-surface);
    padding: 8px 16px;
    font-weight: 600;
    font-size: 14px;
    text-transform: lowercase;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.brutalist-btn:hover { background: var(--color-accent-hover); color: var(--color-surface); }
.brutalist-btn-outline {
    background: transparent;
    color: var(--color-text);
    border: 1px solid var(--color-text);
}
.brutalist-btn-outline:hover {
    background: var(--color-text);
    color: var(--color-surface);
}
.brutalist-avatar-wrap {
    width: 120px;
    height: 120px;
    background: var(--color-text);
    color: var(--color-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: bold;
    position: relative;
    border-radius: 0;
}
.brutalist-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}
.brutalist-label {
    font-size: 12px;
    color: var(--color-text-muted);
    margin-bottom: 4px;
    text-transform: lowercase;
}
.brutalist-value {
    font-size: 18px;
    font-weight: 500;
    color: var(--color-text);
    text-transform: lowercase;
}
.brutalist-timeline-item {
    border-left: 2px solid var(--color-accent);
    padding-left: 24px;
    margin-bottom: 32px;
    position: relative;
}
.brutalist-timeline-item::before {
    content: '';
    position: absolute;
    left: -6px;
    top: 0;
    width: 10px;
    height: 10px;
    background: var(--color-accent);
}
.brutalist-doc-card {
    border: 1px solid var(--color-border);
    padding: 24px;
    background: #161616;
}
@media (max-width: 768px) {
    .brutalist-grid { grid-template-columns: 1fr; }
    .brutalist-block { padding: 20px; }
}
</style>

<div class="lowercase">
    <h1 class="brutalist-title">settings</h1>

    <div class="brutalist-block">
        <div class="brutalist-block-header">
            <h2 class="brutalist-block-title">my profile</h2>
            <a href="<?= BASE_URL ?>/user/settings/edit" class="brutalist-btn brutalist-btn-outline">edit profile</a>
        </div>
        
        <div class="flex flex-col md:flex-row gap-8 items-start">
            <div class="shrink-0">
                <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/avatar" enctype="multipart/form-data" class="group relative inline-block">
                    <?= csrf_field() ?>
                    <label for="settings-avatar-input" class="cursor-pointer brutalist-avatar-wrap inline-flex items-center justify-center">
                        <?php if ($profileAvatarSrc): ?>
                            <img src="<?= e($profileAvatarSrc) ?>" alt="" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?= e($profileInitial) ?>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-black/60 text-white text-sm font-bold flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            upload
                        </div>
                    </label>
                    <input type="file" id="settings-avatar-input" name="avatar" accept=".jpg,.jpeg,.png" class="sr-only" onchange="if (this.files.length) this.form.submit()">
                </form>
            </div>
            
            <div class="flex-1 w-full relative">
                <div class="brutalist-grid">
                    <div>
                        <div class="brutalist-label">full name</div>
                        <div class="brutalist-value text-2xl mb-4"><?= e($user['name']) ?></div>
                    </div>
                    <div>
                        <div class="brutalist-label">summary</div>
                        <div class="brutalist-value" style="font-size:15px; color:var(--color-text-muted);">
                            <?= empty($user['user_summary']) ? 'no summary provided.' : nl2br(e($user['user_summary'])) ?>
                        </div>
                    </div>
                    <div>
                        <div class="brutalist-label">email</div>
                        <div class="brutalist-value"><?= e($user['email']) ?></div>
                    </div>
                    <div>
                        <div class="brutalist-label">phone</div>
                        <div class="brutalist-value"><?= e($user['phone'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="brutalist-label">location</div>
                        <div class="brutalist-value"><?= e($user['address'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="brutalist-label">demographics</div>
                        <div class="brutalist-value">
                            <?php
                            $age = '-';
                            if (!empty($user['birth_date'])) {
                                try {
                                    $b = new DateTime((string) $user['birth_date']);
                                    $age = $b->diff(new DateTime())->y . ' y.o';
                                } catch (Throwable $e) {}
                            }
                            ?>
                            <?= e($age) ?> / <?= e($genderLabel) ?> / <?= e(!empty($user['marital_status']) ? ($maritalLabels[$user['marital_status']] ?? $user['marital_status']) : '-') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="brutalist-block">
        <div class="brutalist-block-header">
            <h2 class="brutalist-block-title">work experience</h2>
            <a href="<?= BASE_URL ?>/user/settings/edit#work-experiences" class="brutalist-btn brutalist-btn-outline">manage</a>
        </div>
        
        <?php if (empty($workExperiences)): ?>
            <p class="text-gray-500 font-medium">no work experience listed.</p>
        <?php else: ?>
            <div class="mt-6">
                <?php foreach ($workExperiences as $we): ?>
                    <div class="brutalist-timeline-item">
                        <div class="brutalist-value" style="font-size:24px;"><?= e($we['title']) ?></div>
                        <div class="brutalist-label" style="font-size:16px; margin:4px 0 12px;"><?= e($we['company_name'] ?? '') ?> &nbsp;|&nbsp; <?= e($we['year_start']) ?> – <?= e($we['year_end']) ?></div>
                        <?php if (!empty($we['description'])): ?>
                            <div class="brutalist-value" style="font-size:15px; color:var(--color-text-muted);"><?= nl2br(e($we['description'])) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- PENDIDIKAN & PENCAPAIAN Dihilangkan untuk simpel, atau dimuat format serupa timeline -->
    <div class="brutalist-block">
        <div class="brutalist-block-header">
            <h2 class="brutalist-block-title">education & achievements</h2>
            <a href="<?= BASE_URL ?>/user/settings/edit#education" class="brutalist-btn brutalist-btn-outline">manage</a>
        </div>
        
        <?php if (!empty($user['education_level']) || !empty($user['education_university'])): ?>
            <div class="brutalist-timeline-item">
                <div class="brutalist-value" style="font-size:20px;"><?= e($user['education_university'] ?? '-') ?></div>
                <div class="brutalist-label" style="font-size:16px; margin-top:4px;">
                    <?= e($user['education_major'] ?? '') ?> &nbsp;|&nbsp; <?= e($user['education_level'] ?? '') ?> 
                    <?= !empty($user['graduation_year']) ? ' (class of ' . e($user['graduation_year']) . ')' : '' ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-500 font-medium mb-8">no education info listed.</p>
        <?php endif; ?>

        <!-- achievements -->
        <?php if (!empty($achievements)): ?>
            <div class="mt-8">
                <?php foreach ($achievements as $ach): ?>
                    <div class="brutalist-timeline-item">
                        <div class="brutalist-value" style="font-size:20px;"><?= e($ach['title'] ?? '-') ?></div>
                        <div class="brutalist-label" style="font-size:14px; margin:4px 0;">
                            <?= e($ach['type'] ?? '-') ?> / <?= !empty($ach['level']) ? e($ach['level']) . ' / ' : '' ?> <?= !empty($ach['year']) ? e($ach['year']) : '' ?>
                        </div>
                        <?php if (!empty($ach['organizer'])): ?>
                            <div class="brutalist-label">by <?= e($ach['organizer']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="brutalist-block">
        <div class="brutalist-block-header">
            <h2 class="brutalist-block-title">documents (resume / cv)</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- CV -->
            <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/cv" enctype="multipart/form-data" class="brutalist-doc-card">
                <?= csrf_field() ?>
                <div class="brutalist-value mb-2">resume / cv <span class="text-xs text-gray-500">(pdf/docx)</span></div>
                <div class="brutalist-label mb-4">
                    last updated: <span style="color:var(--color-text);"><?= e($formatDocUploadedAt((string) $user['cv_path'])) ?></span>
                </div>
                <input type="file" name="cv" accept=".pdf,.docx" class="block w-full text-sm border border-[#444] bg-[#111] text-white px-3 py-2 mb-4" required>
                <div class="flex gap-2">
                    <button type="submit" class="brutalist-btn w-full">upload cv</button>
                    <?php if (!empty($user['cv_path'])): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=cv" target="_blank" rel="noopener noreferrer" class="brutalist-btn brutalist-btn-outline w-full text-center">preview</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Diploma -->
            <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/diploma" enctype="multipart/form-data" class="brutalist-doc-card">
                <?= csrf_field() ?>
                <div class="brutalist-value mb-2">diploma <span class="text-xs text-gray-500">(pdf/docx)</span></div>
                <div class="brutalist-label mb-4">
                    last updated: <span style="color:var(--color-text);"><?= e($formatDocUploadedAt((string) $user['diploma_path'])) ?></span>
                </div>
                <input type="file" name="diploma" accept=".pdf,.docx" class="block w-full text-sm border border-[#444] bg-[#111] text-white px-3 py-2 mb-4" required>
                <div class="flex gap-2">
                    <button type="submit" class="brutalist-btn w-full">upload</button>
                    <?php if (!empty($user['diploma_path'])): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=diploma" target="_blank" rel="noopener noreferrer" class="brutalist-btn brutalist-btn-outline w-full text-center">preview</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Photo -->
            <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/photo" enctype="multipart/form-data" class="brutalist-doc-card">
                <?= csrf_field() ?>
                <div class="brutalist-value mb-2">photo ID <span class="text-xs text-gray-500">(jpg/png)</span></div>
                <div class="brutalist-label mb-4">
                    last updated: <span style="color:var(--color-text);"><?= e($formatDocUploadedAt((string) $user['photo_path'])) ?></span>
                </div>
                <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="block w-full text-sm border border-[#444] bg-[#111] text-white px-3 py-2 mb-4" required>
                <div class="flex gap-2">
                    <button type="submit" class="brutalist-btn w-full">upload photo</button>
                    <?php if (!empty($user['photo_path'])): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=photo" target="_blank" rel="noopener noreferrer" class="brutalist-btn brutalist-btn-outline w-full text-center">preview</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
