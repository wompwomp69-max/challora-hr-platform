<div class="card">
    <div class="card-body">
        <h1 class="card-title h4 mb-4">Pengaturan Profil</h1>
        <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/edit">
            <h5 class="mb-3">Data Pribadi</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= e($user['name']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" value="<?= e($user['email']) ?>" readonly disabled>
                    <small class="text-muted">Email tidak dapat diubah</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="phone">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= e($user['phone'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gender">Jenis Kelamin</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">— Pilih —</option>
                        <option value="male" <?= ($user['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="female" <?= ($user['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Perempuan</option>
                        <option value="other" <?= ($user['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="religion">Agama</label>
                    <select class="form-select" id="religion" name="religion">
                        <option value="">— Pilih —</option>
                        <?php
                        $religions = ['islam' => 'Islam', 'katolik' => 'Katolik', 'kristen' => 'Kristen', 'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu', 'lainnya' => 'Lainnya'];
                        foreach ($religions as $key => $label):
                        ?>
                        <option value="<?= $key ?>" <?= ($user['religion'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="birth_place">Tempat Lahir</label>
                    <input type="text" class="form-control" id="birth_place" name="birth_place" value="<?= e($user['birth_place'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="birth_date">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= e($user['birth_date'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="social_media">Akun Media Sosial (opsional)</label>
                    <input type="text" class="form-control" id="social_media" name="social_media" placeholder="@username / link profil" value="<?= e($user['social_media'] ?? '') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label" for="address">Alamat Tinggal</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?= e($user['address'] ?? '') ?></textarea>
                </div>
            </div>

            <h5 class="mb-3 mt-4">Data Keluarga</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="father_name">Nama Ayah</label>
                    <input type="text" class="form-control" id="father_name" name="father_name" value="<?= e($user['father_name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="mother_name">Nama Ibu</label>
                    <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?= e($user['mother_name'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="father_job">Pekerjaan Ayah</label>
                    <input type="text" class="form-control" id="father_job" name="father_job" value="<?= e($user['father_job'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="mother_job">Pekerjaan Ibu</label>
                    <input type="text" class="form-control" id="mother_job" name="mother_job" value="<?= e($user['mother_job'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="father_education">Pendidikan Terakhir Ayah</label>
                    <input type="text" class="form-control" id="father_education" name="father_education" value="<?= e($user['father_education'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="mother_education">Pendidikan Terakhir Ibu</label>
                    <input type="text" class="form-control" id="mother_education" name="mother_education" value="<?= e($user['mother_education'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="father_phone">No. Telepon Ayah</label>
                    <input type="text" class="form-control" id="father_phone" name="father_phone" value="<?= e($user['father_phone'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="mother_phone">No. Telepon Ibu</label>
                    <input type="text" class="form-control" id="mother_phone" name="mother_phone" value="<?= e($user['mother_phone'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label">Alamat Tinggal Orang Tua</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="address_type" id="address_same" value="same" <?= ($user['address_type'] ?? '') === 'same' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="address_same">Sama dengan saya</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="address_type" id="address_separate" value="separate" <?= ($user['address_type'] ?? '') === 'separate' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="address_separate">Tinggal terpisah</label>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="address_family">Alamat Orang Tua (jika tinggal terpisah)</label>
                    <textarea class="form-control" id="address_family" name="address_family" rows="2"><?= e($user['address_family'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="emergency_name">Kontak Darurat (Nama)</label>
                    <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="<?= e($user['emergency_name'] ?? '') ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="form-label" for="emergency_phone">Kontak Darurat (No. Telepon)</label>
                    <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?= e($user['emergency_phone'] ?? '') ?>">
                </div>
            </div>

            <h5 class="mb-3 mt-4">Data Pendidikan (Pendidikan Terakhir)</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="education_level">Pendidikan Terakhir</label>
                    <input type="text" class="form-control" id="education_level" name="education_level" placeholder="Contoh: S1, D3, SMA" value="<?= e($user['education_level'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="graduation_year">Tahun Lulus</label>
                    <input type="text" class="form-control" id="graduation_year" name="graduation_year" placeholder="Contoh: 2020" value="<?= e($user['graduation_year'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="education_major">Jurusan</label>
                    <input type="text" class="form-control" id="education_major" name="education_major" value="<?= e($user['education_major'] ?? '') ?>">
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label" for="education_university">Nama Universitas/Instansi</label>
                    <input type="text" class="form-control" id="education_university" name="education_university" value="<?= e($user['education_university'] ?? '') ?>">
                </div>
            </div>

            <h5 class="mb-3 mt-4">Pengalaman Kerja</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-work-exp">+ Tambah Pengalaman Kerja</button>
            <div id="work-experiences">
                <?php
                $exps = $workExperiences ?? [];
                if (empty($exps)) $exps = [['title' => '', 'company_name' => '', 'year_start' => '', 'year_end' => '', 'description' => '']];
                foreach ($exps as $idx => $exp):
                ?>
                <div class="work-exp-row card mb-3 p-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Judul / Jabatan</label>
                            <input type="text" class="form-control" name="work_title[]" value="<?= e($exp['title'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Nama Instansi Pekerjaan</label>
                            <input type="text" class="form-control" name="work_company[]" placeholder="Nama perusahaan / instansi" value="<?= e($exp['company_name'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Tahun Mulai</label>
                            <input type="text" class="form-control" name="work_year_start[]" placeholder="2020" value="<?= e($exp['year_start'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Tahun Selesai</label>
                            <input type="text" class="form-control" name="work_year_end[]" placeholder="2023" value="<?= e($exp['year_end'] ?? '') ?>">
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="work_description[]" rows="2"><?= e($exp['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <h5 class="mb-3 mt-4">Pencapaian / Achievement</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-achievement">+ Tambah Pencapaian</button>
            <?php
            $achTypes = ['kompetisi' => 'Kompetisi', 'webinar_seminar' => 'Webinar/Seminar', 'workshop' => 'Workshop', 'pelatihan_kursus' => 'Pelatihan/Kursus', 'sertifikasi' => 'Sertifikasi', 'lainnya' => 'Lainnya'];
            $achLevels = ['kota' => 'Kota', 'provinsi' => 'Provinsi', 'nasional' => 'Nasional', 'internasional' => 'Internasional'];
            $achList = $achievements ?? [];
            if (empty($achList)) $achList = [['type' => '', 'title' => '', 'description' => '', 'organizer' => '', 'year' => '', 'rank' => '', 'level' => '', 'certificate_link' => '']];
            ?>
            <div id="achievements">
                <?php foreach ($achList as $idx => $a): ?>
                <div class="achievement-row card mb-3 p-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Jenis</label>
                            <select class="form-select" name="ach_type[]">
                                <option value="">— Pilih —</option>
                                <?php foreach ($achTypes as $k => $l): ?>
                                <option value="<?= $k ?>" <?= ($a['type'] ?? '') === $k ? 'selected' : '' ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Judul Kegiatan</label>
                            <input type="text" class="form-control" name="ach_title[]" value="<?= e($a['title'] ?? '') ?>">
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" name="ach_description[]" rows="2"><?= e($a['description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Penyelenggara</label>
                            <input type="text" class="form-control" name="ach_organizer[]" value="<?= e($a['organizer'] ?? '') ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Tahun</label>
                            <input type="text" class="form-control" name="ach_year[]" placeholder="2023" value="<?= e($a['year'] ?? '') ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Peringkat (opsional)</label>
                            <input type="text" class="form-control" name="ach_rank[]" placeholder="Juara 1" value="<?= e($a['rank'] ?? '') ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tingkat (opsional)</label>
                            <select class="form-select" name="ach_level[]">
                                <option value="">— Pilih —</option>
                                <?php foreach ($achLevels as $k => $l): ?>
                                <option value="<?= $k ?>" <?= ($a['level'] ?? '') === $k ? 'selected' : '' ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">Link Google Drive Sertifikat (opsional)</label>
                            <input type="url" class="form-control" name="ach_certificate_link[]" placeholder="https://drive.google.com/..." value="<?= e($a['certificate_link'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($error)): ?><p class="text-danger"><?= e($error) ?></p><?php endif; ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= BASE_URL ?>/user/settings" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('add-work-exp').addEventListener('click', function() {
    const tpl = document.querySelector('.work-exp-row').cloneNode(true);
    tpl.querySelectorAll('input, textarea').forEach(el => el.value = '');
    document.getElementById('work-experiences').insertBefore(tpl, document.getElementById('work-experiences').firstChild);
});
document.getElementById('add-achievement').addEventListener('click', function() {
    const tpl = document.querySelector('.achievement-row').cloneNode(true);
    tpl.querySelectorAll('input, textarea, select').forEach(el => { if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = ''; });
    document.getElementById('achievements').insertBefore(tpl, document.getElementById('achievements').firstChild);
});
</script>
