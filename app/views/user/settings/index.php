<?php
$maritalLabels = ['single' => 'Belum menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Duda/Janda'];
$religionLabels = ['islam' => 'Islam', 'katolik' => 'Katolik', 'kristen' => 'Kristen', 'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu', 'lainnya' => 'Lainnya'];
$achTypeLabels = ['kompetisi' => 'Kompetisi', 'webinar_seminar' => 'Webinar/Seminar', 'workshop' => 'Workshop', 'pelatihan_kursus' => 'Pelatihan/Kursus', 'sertifikasi' => 'Sertifikasi', 'lainnya' => 'Lainnya'];
$achLevelLabels = ['kota' => 'Kota', 'provinsi' => 'Provinsi', 'nasional' => 'Nasional', 'internasional' => 'Internasional'];
?>
<div class="card mb-4">
    <div class="card-body">
        <h1 class="card-title h4 mb-4">Profil Saya</h1>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> <?= e($user['name']) ?></p>
                <p><strong>Email:</strong> <?= e($user['email']) ?></p>
                <p><strong>No. HP:</strong> <?= e($user['phone'] ?? '-') ?></p>
                <p><strong>Alamat:</strong> <?= e($user['address'] ?? '-') ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= e($user['gender'] === 'male' ? 'Laki-laki' : ($user['gender'] === 'female' ? 'Perempuan' : '-')) ?></p>
                <p><strong>Agama:</strong> <?= e(!empty($user['religion']) ? ($religionLabels[$user['religion']] ?? $user['religion']) : '-') ?></p>
                <p><strong>Akun Media Sosial:</strong> <?= e($user['social_media'] ?? '-') ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Tempat, Tanggal Lahir:</strong>
                    <?= e($user['birth_place'] ?? '-') ?><?= !empty($user['birth_date']) ? ', ' . e($user['birth_date']) : '' ?>
                </p>
                <p><strong>Nama Ayah:</strong> <?= e($user['father_name'] ?? '-') ?></p>
                <p><strong>Pekerjaan Ayah:</strong> <?= e($user['father_job'] ?? '-') ?></p>
                <p><strong>Pendidikan Ayah:</strong> <?= e($user['father_education'] ?? '-') ?></p>
                <p><strong>No. HP Ayah:</strong> <?= e($user['father_phone'] ?? '-') ?></p>
                <p><strong>Nama Ibu:</strong> <?= e($user['mother_name'] ?? '-') ?></p>
                <p><strong>Pekerjaan Ibu:</strong> <?= e($user['mother_job'] ?? '-') ?></p>
                <p><strong>Pendidikan Ibu:</strong> <?= e($user['mother_education'] ?? '-') ?></p>
                <p><strong>No. HP Ibu:</strong> <?= e($user['mother_phone'] ?? '-') ?></p>
                <p><strong>Status Pernikahan:</strong> <?= e(!empty($user['marital_status']) ? ($maritalLabels[$user['marital_status']] ?? $user['marital_status']) : '-') ?></p>
                <p><strong>Alamat Orang Tua:</strong>
                    <?= ($user['address_type'] ?? '') === 'same'
                        ? 'Sama dengan saya'
                        : (!empty($user['address_family']) ? e($user['address_family']) : '-') ?>
                </p>
                <p><strong>Kontak Darurat:</strong>
                    <?= e($user['emergency_name'] ?? '-') ?><?= !empty($user['emergency_phone']) ? ' (' . e($user['emergency_phone']) . ')' : '' ?>
                </p>
            </div>
        </div>
        <?php if (!empty($user['education_level']) || !empty($user['education_university'])): ?>
        <h6 class="mt-3">Pendidikan Terakhir</h6>
        <p><?= e($user['education_level'] ?? '') ?> - <?= e($user['education_major'] ?? '') ?> (<?= e($user['graduation_year'] ?? '') ?>)<br><?= e($user['education_university'] ?? '') ?></p>
        <?php endif; ?>
        <?php if (!empty($user['job_description'])): ?>
        <h6 class="mt-3">Deskripsi Pekerjaan / Jobdesk</h6>
        <p><?= nl2br(e($user['job_description'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($achievements)): ?>
        <h6 class="mt-3">Pencapaian / Achievement</h6>
        <ul class="list-unstyled">
            <?php foreach ($achievements as $a): ?>
            <li class="mb-2">
                <strong><?= e($a['title']) ?></strong>
                (<?= e($achTypeLabels[$a['type']] ?? $a['type']) ?>)
                <?= !empty($a['organizer']) ? ' — ' . e($a['organizer']) : '' ?>
                <?= !empty($a['year']) ? ' (' . e($a['year']) . ')' : '' ?>
                <?= !empty($a['rank']) ? ' — Peringkat: ' . e($a['rank']) : '' ?>
                <?= !empty($a['level']) ? ' — ' . e($achLevelLabels[$a['level']] ?? $a['level']) : '' ?>
                <?= !empty($a['certificate_link']) ? ' <a href="' . e($a['certificate_link']) . '" target="_blank" rel="noopener">Sertifikat</a>' : '' ?>
                <?= !empty($a['description']) ? '<br><small class="text-muted">' . e($a['description']) . '</small>' : '' ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if (!empty($workExperiences)): ?>
        <h6 class="mt-3">Pengalaman Kerja</h6>
        <ul class="list-unstyled">
            <?php foreach ($workExperiences as $we): ?>
            <li class="mb-2"><?= e($we['title']) ?><?= !empty($we['company_name']) ? ' di ' . e($we['company_name']) : '' ?> (<?= e($we['year_start']) ?> - <?= e($we['year_end']) ?>)<br><small class="text-muted"><?= e($we['description']) ?></small></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/user/settings/edit" class="btn btn-primary">Edit Profil</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h2 class="card-title h5 mb-4">Lamaran Saya</h2>
        <?php if (empty($applications)): ?>
            <p class="text-muted">Belum ada lamaran.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Lowongan</th><th>Lokasi</th><th>Status</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $a): ?>
                            <tr>
                                <td><?= e($a['job_title']) ?></td>
                                <td><?= e($a['location'] ?? '-') ?></td>
                                <td>
                                    <?php $badgeClass = $a['status'] === 'pending' ? 'bg-primary' : ($a['status'] === 'accepted' ? 'bg-success' : ($a['status'] === 'rejected' ? 'bg-danger' : 'bg-secondary')); ?>
                                    <span class="badge <?= $badgeClass ?>"><?= e($a['status']) ?></span>
                                </td>
                                <td><?= e($a['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
