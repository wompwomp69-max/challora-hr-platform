<?php
$maritalLabels = ['single' => 'Belum menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Duda/Janda'];
$religionLabels = ['islam' => 'Islam', 'katolik' => 'Katolik', 'kristen' => 'Kristen', 'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu', 'lainnya' => 'Lainnya'];
$genderLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan', 'other' => 'Lainnya'];
$genderLabel = $genderLabels[(string) ($user['gender'] ?? '')] ?? '-';
$profileAvatarSrc = currentUserAvatarImgSrc();
$profileInitial = mb_strtoupper(mb_substr($user['name'] ?? 'U', 0, 1));
$formatDocUploadedAt = static function (?string $relativePath): string {
    if (empty($relativePath)) {
        return '-';
    }
    $fullPath = BASE_PATH . '/' . ltrim($relativePath, '/');
    if (!is_file($fullPath)) {
        return '-';
    }
    $ts = @filemtime($fullPath);
    if ($ts === false) {
        return '-';
    }
    return date('d/m/Y H:i', $ts);
};
?>

<div class="max-w-5xl mx-auto">
    <div class="bg-surface rounded-2xl shadow-sm border border-muted p-5 md:p-8">
        <!-- Header profil -->
        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-shrink-0">
                <form
                    method="post"
                    action="<?= BASE_URL ?>/index.php?url=user/settings/avatar"
                    enctype="multipart/form-data"
                    class="group relative inline-block"
                >
                    <label
                        for="settings-avatar-input"
                        class="block cursor-pointer relative w-24 h-24 md:w-28 md:h-28 rounded-full overflow-hidden shadow-sm ring-2 ring-transparent hover:ring-primary/50 focus-within:ring-2 focus-within:ring-primary transition"
                        title="Klik untuk mengganti foto profil"
                    >
                        <?php if ($profileAvatarSrc): ?>
                            <img src="<?= e($profileAvatarSrc) ?>" alt="" class="w-full h-full object-cover" width="112" height="112">
                        <?php else: ?>
                            <div class="w-full h-full bg-primary flex items-center justify-center text-secondary text-3xl font-semibold"><?= e($profileInitial) ?></div>
                        <?php endif; ?>
                        <span class="absolute inset-0 flex items-center justify-center bg-black/50 text-white text-[11px] font-semibold opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none text-center px-1 leading-tight">Ganti foto</span>
                    </label>
                    <input
                        type="file"
                        id="settings-avatar-input"
                        name="avatar"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        class="sr-only"
                        onchange="if (this.files.length) this.form.submit()"
                    >
                </form>
                <p class="text-[10px] text-muted mt-1.5 max-w-[7rem] md:max-w-[8.75rem] text-center">JPG/PNG, maks. 1 MB</p>
            </div>
            <div class="flex-1 flex flex-col gap-2 min-w-0">
                <div class="flex flex-wrap items-start gap-2 justify-between">
                    <div class="min-w-0">
                        <h1 class="text-xl md:text-2xl font-semibold text-default"><?= e($user['name']) ?></h1>
                        <?php if (!empty($user['user_summary'])): ?>
                            <p class="text-sm text-muted mt-1 leading-relaxed"><?= nl2br(e($user['user_summary'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-muted mt-1">Belum ada perkenalan singkat. <a href="<?= BASE_URL ?>/user/settings/edit" class="text-primary hover:underline">Tambahkan di pengaturan</a>.</p>
                        <?php endif; ?>
                    </div>
                    <a href="<?= BASE_URL ?>/user/settings/edit" class="text-xs font-medium text-accent hover:underline shrink-0">Ubah data diri</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 text-xs md:text-sm text-default">
                    <div class="space-y-1">
                        <div><span class="font-semibold text-default">WhatsApp:</span> <?= e($user['phone'] ?? '-') ?></div>
                        <div><span class="font-semibold text-default">Lokasi:</span> <?= e($user['address'] ?? '-') ?></div>
                        <div><span class="font-semibold text-default">Agama:</span> <?= e(!empty($user['religion']) ? ($religionLabels[$user['religion']] ?? $user['religion']) : '-') ?></div>
                    </div>
                    <div class="space-y-1">
                        <div><span class="font-semibold text-default">Email:</span> <?= e($user['email']) ?></div>
                        <div><span class="font-semibold text-default">Usia, Jenis kelamin:</span>
                            <?php
                            $age = '-';
                            if (!empty($user['birth_date'])) {
                                try {
                                    $b = new DateTime((string) $user['birth_date']);
                                    $age = $b->diff(new DateTime())->y . ' tahun';
                                } catch (Throwable $e) {
                                    $age = '-';
                                }
                            }
                            ?>
                            <?= e($age) ?>, <?= e($genderLabel) ?>
                        </div>
                        <div><span class="font-semibold text-default">Status pernikahan:</span> <?= e(!empty($user['marital_status']) ? ($maritalLabels[$user['marital_status']] ?? $user['marital_status']) : '-') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengalaman kerja -->
        <div class="border-t border-muted pt-6 mt-6">
            <div class="flex items-center justify-between gap-2 mb-3">
                <h2 class="text-sm font-semibold tracking-wide text-default">PENGALAMAN KERJA</h2>
                <a href="<?= BASE_URL ?>/user/settings/edit#work-experiences" class="text-xs font-medium text-primary hover:underline uppercase shrink-0">Tambah</a>
            </div>
            <?php if (empty($workExperiences)): ?>
                <p class="text-sm text-muted">Belum ada pengalaman kerja.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($workExperiences as $we): ?>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center pt-1 shrink-0">
                                <div class="w-2 h-2 rounded-full bg-accent"></div>
                                <div class="flex-1 w-px bg-accent min-h-[1rem] mt-1"></div>
                            </div>
                            <div class="flex-1 min-w-0 pb-1">
                                <div class="font-semibold text-sm text-default"><?= e($we['title']) ?></div>
                                <div class="text-xs text-muted"><?= e($we['company_name'] ?? '') ?></div>
                                <div class="text-xs text-muted"><?= e($we['year_start']) ?> – <?= e($we['year_end']) ?></div>
                                <?php if (!empty($we['description'])): ?>
                                    <div class="text-xs text-default mt-1"><?= nl2br(e($we['description'])) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pendidikan -->
        <div class="border-t border-muted pt-6 mt-6">
            <div class="flex items-center justify-between gap-2 mb-3">
                <h2 class="text-sm font-semibold tracking-wide text-default">PENDIDIKAN</h2>
                <a href="<?= BASE_URL ?>/user/settings/edit#education" class="text-xs font-medium text-primary hover:underline uppercase shrink-0">Ubah</a>
            </div>
            <?php if (empty($user['education_level']) && empty($user['education_university'])): ?>
                <p class="text-sm text-muted">Belum ada data pendidikan.</p>
            <?php else: ?>
                <div class="flex gap-3">
                    <div class="flex flex-col items-center pt-1 shrink-0">
                        <div class="w-2 h-2 rounded-full bg-accent"></div>
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-sm text-default"><?= e($user['education_university'] ?? '-') ?></div>
                        <div class="text-xs text-muted"><?= e($user['education_major'] ?? '') ?></div>
                        <div class="text-xs text-muted">
                            <?= e($user['education_level'] ?? '') ?><?= !empty($user['graduation_year']) ? ' • Lulus ' . e($user['graduation_year']) : '' ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pencapaian -->
        <div class="border-t border-muted pt-6 mt-6">
            <div class="flex items-center justify-between gap-2 mb-3">
                <h2 class="text-sm font-semibold tracking-wide text-default">PENCAPAIAN</h2>
                <a href="<?= BASE_URL ?>/user/settings/edit#data-pencapaian" class="text-xs font-medium text-primary hover:underline uppercase shrink-0">Ubah</a>
            </div>
            <?php if (empty($achievements)): ?>
                <p class="text-sm text-muted">Belum ada pencapaian.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($achievements as $ach): ?>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center pt-1 shrink-0">
                                <div class="w-2 h-2 rounded-full bg-accent"></div>
                                <div class="flex-1 w-px bg-accent min-h-[1rem] mt-1"></div>
                            </div>
                            <div class="flex-1 min-w-0 pb-1">
                                <div class="font-semibold text-sm text-default"><?= e($ach['title'] ?? '-') ?></div>
                                <div class="text-xs text-muted">
                                    <?= e($ach['type'] ?? '-') ?>
                                    <?= !empty($ach['year']) ? ' • ' . e($ach['year']) : '' ?>
                                    <?= !empty($ach['level']) ? ' • ' . e($ach['level']) : '' ?>
                                </div>
                                <?php if (!empty($ach['organizer'])): ?>
                                    <div class="text-xs text-muted"><?= e($ach['organizer']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($ach['description'])): ?>
                                    <div class="text-xs text-default mt-1"><?= nl2br(e($ach['description'])) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Dokumen lamaran -->
        <div class="border-t border-muted pt-6 mt-6">
            <div class="flex items-center justify-between gap-2 mb-3">
                <h2 class="text-sm font-semibold tracking-wide text-default">DOKUMEN LAMARAN</h2>
                <span class="text-xs text-muted">Dipakai otomatis saat melamar</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/cv" enctype="multipart/form-data" class="rounded-xl border border-muted p-3">
                    <div class="text-xs font-semibold text-default mb-2">CV (PDF/DOCX)</div>
                    <div class="text-[11px] text-muted mb-2">
                        <?php if (!empty($user['cv_path'])): ?>
                            <span class="block text-[10px] uppercase tracking-wide text-muted/80">Terakhir ditambahkan</span>
                            <?= e($formatDocUploadedAt((string) $user['cv_path'])) ?>
                        <?php else: ?>
                            Belum diunggah
                        <?php endif; ?>
                    </div>
                    <input type="file" name="cv" accept=".pdf,.docx" class="block w-full text-xs border border-default rounded-md px-2 py-1.5 mb-2" required>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 px-3 py-1.5 rounded-full bg-accent text-primary text-xs font-semibold">Upload CV</button>
                        <?php if (!empty($user['cv_path'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=cv" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-full border border-default text-xs font-semibold text-default hover:bg-muted">Preview</a>
                        <?php endif; ?>
                    </div>
                </form>
                <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/diploma" enctype="multipart/form-data" class="rounded-xl border border-muted p-3">
                    <div class="text-xs font-semibold text-default mb-2">Ijazah (PDF/DOCX)</div>
                    <div class="text-[11px] text-muted mb-2">
                        <?php if (!empty($user['diploma_path'])): ?>
                            <span class="block text-[10px] uppercase tracking-wide text-muted/80">Terakhir ditambahkan</span>
                            <?= e($formatDocUploadedAt((string) $user['diploma_path'])) ?>
                        <?php else: ?>
                            Belum diunggah
                        <?php endif; ?>
                    </div>
                    <input type="file" name="diploma" accept=".pdf,.docx" class="block w-full text-xs border border-default rounded-md px-2 py-1.5 mb-2" required>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 px-3 py-1.5 rounded-full bg-accent text-primary text-xs font-semibold">Upload Ijazah</button>
                        <?php if (!empty($user['diploma_path'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=diploma" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-full border border-default text-xs font-semibold text-default hover:bg-muted">Preview</a>
                        <?php endif; ?>
                    </div>
                </form>
                <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/photo" enctype="multipart/form-data" class="rounded-xl border border-muted p-3">
                    <div class="text-xs font-semibold text-default mb-2">Pas Foto (JPG/PNG)</div>
                    <div class="text-[11px] text-muted mb-2">
                        <?php if (!empty($user['photo_path'])): ?>
                            <span class="block text-[10px] uppercase tracking-wide text-muted/80">Terakhir ditambahkan</span>
                            <?= e($formatDocUploadedAt((string) $user['photo_path'])) ?>
                        <?php else: ?>
                            Belum diunggah
                        <?php endif; ?>
                    </div>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="block w-full text-xs border border-default rounded-md px-2 py-1.5 mb-2" required>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 px-3 py-1.5 rounded-full bg-accent text-primary text-xs font-semibold">Upload Pas Foto</button>
                        <?php if (!empty($user['photo_path'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=download/user-file&type=photo" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-full border border-default text-xs font-semibold text-default hover:bg-muted">Preview</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
