<?php
$religions = ['islam' => 'Islam', 'katolik' => 'Katolik', 'kristen' => 'Kristen', 'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu', 'lainnya' => 'Lainnya'];
$maritalOptions = ['single' => 'Belum menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Duda/Janda'];
$achTypes = ['kompetisi' => 'Kompetisi', 'webinar_seminar' => 'Webinar/Seminar', 'workshop' => 'Workshop', 'pelatihan_kursus' => 'Pelatihan/Kursus', 'sertifikasi' => 'Sertifikasi', 'lainnya' => 'Lainnya'];
$achLevels = ['kota' => 'Kota', 'provinsi' => 'Provinsi', 'nasional' => 'Nasional', 'internasional' => 'Internasional'];
$exps = $workExperiences ?? [];
if (empty($exps)) $exps = [];
$achList = $achievements ?? [];
if (empty($achList)) $achList = [];
$educationItem = [
    'education_level' => $user['education_level'] ?? '',
    'graduation_year' => $user['graduation_year'] ?? '',
    'education_major' => $user['education_major'] ?? '',
    'education_university' => $user['education_university'] ?? '',
];
$educationJson = json_encode($educationItem, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($educationJson === false) $educationJson = '{"education_level":"","graduation_year":"","education_major":"","education_university":""}';
$workJson = json_encode(array_values($exps), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($workJson === false) $workJson = '[]';
$achievementJson = json_encode(array_values($achList), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($achievementJson === false) $achievementJson = '[]';
$achTypeJson = json_encode($achTypes, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($achTypeJson === false) $achTypeJson = '{}';
$achLevelJson = json_encode($achLevels, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
if ($achLevelJson === false) $achLevelJson = '{}';
?>

<style>
/* Brutalist Edit Form Overrides */
.brutalist-title {
    font-size: 56px;
    font-weight: 600;
    letter-spacing: -2px;
    color: var(--color-text);
    margin-bottom: 32px;
    padding-bottom: 16px;
    border-bottom: 4px solid var(--color-border);
    text-transform: lowercase;
}
input, select, textarea {
    background: #111 !important;
    border: 2px solid var(--color-border) !important;
    border-radius: 0 !important;
    color: var(--color-text) !important;
    text-transform: lowercase;
    transition: all 0.2s ease !important;
    box-shadow: 2px 2px 0 rgba(0,0,0,0.5) !important;
}
input:focus, select:focus, textarea:focus {
    border-color: var(--color-accent) !important;
    box-shadow: 4px 4px 0 var(--color-accent) !important;
    outline: none !important;
    transform: translate(-2px, -2px) !important;
}
.brutalist-btn {
    display: inline-block;
    background: var(--color-accent) !important;
    color: var(--color-surface) !important;
    padding: 12px 24px !important;
    font-weight: 800 !important;
    font-size: 16px !important;
    text-transform: lowercase;
    text-decoration: none;
    border: 2px solid var(--color-border) !important;
    border-radius: 0 !important;
    cursor: pointer;
    box-shadow: 4px 4px 0 rgba(0,0,0,1) !important;
    transition: all 0.2s ease;
}
.brutalist-btn:hover {
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0 rgba(0,0,0,1) !important;
}
.brutalist-btn:active {
    transform: translate(2px, 2px);
    box-shadow: 0px 0px 0 rgba(0,0,0,1) !important;
}
.brutalist-btn-outline {
    background: #111 !important;
    color: var(--color-text) !important;
    border: 2px solid var(--color-text) !important;
}
.brutalist-btn-outline:hover {
    background: var(--color-text) !important;
    color: var(--color-surface) !important;
}
.rounded-3xl, .rounded-2xl, .rounded-xl {
    border-radius: 0 !important;
}
main, aside {
    background: #0a0a0a !important;
    border: 2px solid var(--color-border) !important;
    box-shadow: 6px 6px 0 rgba(0,0,0,1) !important;
}
h2 {
    text-transform: lowercase;
    color: var(--color-text) !important;
    font-size: 28px !important;
    letter-spacing: -1px;
    border-bottom: 2px dashed var(--color-border);
    padding-bottom: 12px;
    margin-bottom: 24px !important;
}
label {
    text-transform: lowercase;
    color: var(--color-text) !important;
    font-weight: 600 !important;
    font-size: 14px !important;
}
.settings-nav-link {
    border: 2px solid transparent;
    transition: all 0.2s;
}
.settings-nav-link:hover, .settings-nav-link.text-accent {
    border: 2px solid var(--color-border);
    background: var(--color-accent) !important;
    color: var(--color-surface) !important;
    box-shadow: 4px 4px 0 rgba(0,0,0,1);
    transform: translate(-2px, -2px);
}
</style>

<div class="max-w-7xl mx-auto px-4 md:px-6 py-4 md:py-6 lowercase">
    <h1 class="brutalist-title" style="margin-top:0;">edit profile</h1>
    <div class="grid grid-cols-1 lg:grid-cols-[220px_minmax(0,1fr)] gap-4 md:gap-6 mt-8">
        <aside class="bg-surface rounded-3xl p-4 border border-muted h-fit lg:sticky lg:top-20">
            <nav class="space-y-2 text-sm">
                <a href="#data-pribadi" class="settings-nav-link block px-3 py-2 rounded-xl text-accent font-semibold">Data Pribadi</a>
                <a href="#data-keluarga" class="settings-nav-link block px-3 py-2 rounded-xl text-default hover:bg-muted">Data Keluarga</a>
                <a href="#data-pendidikan" class="settings-nav-link block px-3 py-2 rounded-xl text-default hover:bg-muted">Data Pendidikan</a>
                <a href="#data-pengalaman" class="settings-nav-link block px-3 py-2 rounded-xl text-default hover:bg-muted">Data Pengalaman Kerja</a>
                <a href="#data-pencapaian" class="settings-nav-link block px-3 py-2 rounded-xl text-default hover:bg-muted">Data Pencapaian</a>
            </nav>
        </aside>

        <main class="bg-surface rounded-3xl border border-muted p-4 md:p-6">
            <form method="post" action="<?= BASE_URL ?>/index.php?url=user/settings/edit" class="space-y-7">
                <section id="data-pribadi" class="scroll-mt-24">
                    <h2 class="text-base md:text-lg font-semibold text-default mb-3">Data Pribadi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-muted mb-1" for="name">Nama</label>
                            <input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="name" name="name" required value="<?= e($user['name']) ?>">
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="email">Email</label>
                            <input type="email" class="w-full rounded-xl border border-default bg-muted px-3 py-2 text-sm text-muted" id="email" value="<?= e($user['email']) ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-3">
                        <div>
                            <label class="block text-xs text-muted mb-1" for="phone">Nomor Telepon</label>
                            <input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="phone" name="phone" value="<?= e($user['phone'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="gender">Jenis Kelamin</label>
                            <select class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="gender" name="gender">
                                <option value="">— Pilih —</option>
                                <option value="male" <?= ($user['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="female" <?= ($user['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Perempuan</option>
                                <option value="other" <?= ($user['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="religion">Agama</label>
                            <select class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="religion" name="religion">
                                <option value="">— Pilih —</option>
                                <?php foreach ($religions as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= ($user['religion'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="marital_status">Status Pernikahan</label>
                            <select class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="marital_status" name="marital_status">
                                <option value="">— Pilih —</option>
                                <?php foreach ($maritalOptions as $key => $label): ?>
                                    <option value="<?= $key ?>" <?= ($user['marital_status'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                        <div>
                            <label class="block text-xs text-muted mb-1" for="birth_place">Tempat Lahir</label>
                            <input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="birth_place" name="birth_place" value="<?= e($user['birth_place'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="birth_date">Tanggal Lahir</label>
                            <input type="date" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="birth_date" name="birth_date" value="<?= e($user['birth_date'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="social_media">Akun Media Sosial</label>
                            <input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="social_media" name="social_media" placeholder="@username / link profil" value="<?= e($user['social_media'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-xs text-muted mb-1" for="address">Alamat Tinggal</label>
                        <textarea class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="address" name="address" rows="3"><?= e($user['address'] ?? '') ?></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="block text-xs text-muted mb-1" for="user_summary">Perkenalan Singkat</label>
                        <textarea class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm text-default focus:outline-none focus:ring-2 focus:ring-primary/30" id="user_summary" name="user_summary" rows="3"><?= e($user['user_summary'] ?? '') ?></textarea>
                    </div>
                </section>

                <section id="data-keluarga" class="scroll-mt-24 border-t border-muted pt-6">
                    <h2 class="text-base md:text-lg font-semibold text-default mb-3">Data Keluarga</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div><label class="block text-xs text-muted mb-1" for="father_name">Nama Ayah</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="father_name" name="father_name" value="<?= e($user['father_name'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="mother_name">Nama Ibu</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="mother_name" name="mother_name" value="<?= e($user['mother_name'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="father_job">Pekerjaan Ayah</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="father_job" name="father_job" value="<?= e($user['father_job'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="mother_job">Pekerjaan Ibu</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="mother_job" name="mother_job" value="<?= e($user['mother_job'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="father_education">Pendidikan Terakhir Ayah</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="father_education" name="father_education" value="<?= e($user['father_education'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="mother_education">Pendidikan Terakhir Ibu</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="mother_education" name="mother_education" value="<?= e($user['mother_education'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="father_phone">No. Telepon Ayah</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="father_phone" name="father_phone" value="<?= e($user['father_phone'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="mother_phone">No. Telepon Ibu</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="mother_phone" name="mother_phone" value="<?= e($user['mother_phone'] ?? '') ?>"></div>
                    </div>
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-muted mb-1">Alamat Tinggal Orang Tua</label>
                            <label class="inline-flex items-center mr-4 text-sm"><input type="radio" class="mr-1" name="address_type" value="same" <?= ($user['address_type'] ?? '') === 'same' ? 'checked' : '' ?>>Sama dengan saya</label>
                            <label class="inline-flex items-center text-sm"><input type="radio" class="mr-1" name="address_type" value="separate" <?= ($user['address_type'] ?? '') === 'separate' ? 'checked' : '' ?>>Tinggal terpisah</label>
                        </div>
                        <div>
                            <label class="block text-xs text-muted mb-1" for="address_family">Alamat Orang Tua</label>
                            <textarea class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="address_family" name="address_family" rows="2"><?= e($user['address_family'] ?? '') ?></textarea>
                        </div>
                        <div><label class="block text-xs text-muted mb-1" for="emergency_name">Kontak Darurat (Nama)</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="emergency_name" name="emergency_name" value="<?= e($user['emergency_name'] ?? '') ?>"></div>
                        <div><label class="block text-xs text-muted mb-1" for="emergency_phone">Kontak Darurat (No. Telepon)</label><input type="text" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" id="emergency_phone" name="emergency_phone" value="<?= e($user['emergency_phone'] ?? '') ?>"></div>
                    </div>
                </section>

                <section id="data-pendidikan" class="scroll-mt-24 border-t border-muted pt-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base md:text-lg font-semibold text-default">Data Pendidikan</h2>
                        <button type="button" class="brutalist-btn" id="add-education">Ubah Data</button>
                    </div>
                    <p class="text-xs text-muted mb-3">Sistem saat ini menyimpan 1 data pendidikan utama. Jika diubah, data sebelumnya akan diganti.</p>
                    <div id="education-card" class="space-y-3"></div>
                    <div id="education-inputs" class="hidden"></div>
                </section>

                <section id="data-pengalaman" class="scroll-mt-24 border-t border-muted pt-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base md:text-lg font-semibold text-default">Data Pengalaman Kerja</h2>
                        <button type="button" class="brutalist-btn" id="add-work-exp">+ Tambah</button>
                    </div>
                    <div id="work-experiences" class="space-y-3"></div>
                    <div id="work-experiences-inputs" class="hidden"></div>
                </section>

                <section id="data-pencapaian" class="scroll-mt-24 border-t border-muted pt-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base md:text-lg font-semibold text-default">Data Pencapaian</h2>
                        <button type="button" class="brutalist-btn" id="add-achievement">+ Tambah</button>
                    </div>
                    <div id="achievements" class="space-y-3"></div>
                    <div id="achievements-inputs" class="hidden"></div>
                </section>

                <?php if (!empty($error)): ?>
                    <p class="text-sm text-danger"><?= e($error) ?></p>
                <?php endif; ?>
                <div class="flex items-center gap-2 pt-2 mt-6">
                    <button type="submit" class="brutalist-btn">Simpan</button>
                    <a href="<?= BASE_URL ?>/user/settings" class="brutalist-btn brutalist-btn-outline">Batal</a>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', function () {
const initialEducationItem = <?= $educationJson ?>;
let educationItems = [];
if ((initialEducationItem.education_level || '').trim() || (initialEducationItem.graduation_year || '').trim() || (initialEducationItem.education_major || '').trim() || (initialEducationItem.education_university || '').trim()) {
    educationItems = [initialEducationItem];
}
const workItems = <?= $workJson ?>;
const achievementItems = <?= $achievementJson ?>;
const achTypeLabels = <?= $achTypeJson ?>;
const achLevelLabels = <?= $achLevelJson ?>;

function eHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function (m) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m];
    });
}

function hasEducation(item) {
    return Boolean((item.education_level || '').trim() || (item.graduation_year || '').trim() || (item.education_major || '').trim() || (item.education_university || '').trim());
}

function renderEducationItems() {
    const cardRoot = document.getElementById('education-card');
    const hidden = document.getElementById('education-inputs');
    cardRoot.innerHTML = '';
    hidden.innerHTML = '';

    if (!educationItems.length) {
        cardRoot.innerHTML = '<div class="text-sm text-muted">Belum ada data pendidikan.</div>';
        hidden.insertAdjacentHTML('beforeend', `
            <input type="hidden" name="education_level" value="">
            <input type="hidden" name="graduation_year" value="">
            <input type="hidden" name="education_major" value="">
            <input type="hidden" name="education_university" value="">
        `);
        return;
    }

    educationItems.forEach((item, idx) => {
        const card = document.createElement('div');
        card.className = 'rounded-2xl border border-muted p-3';
        card.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-sm font-semibold text-default">${eHtml(item.education_university || '-')}</div>
                    <div class="text-xs text-muted">${eHtml(item.education_major || '-')}</div>
                    <div class="text-xs text-muted">${eHtml(item.education_level || '-')} ${item.graduation_year ? ('• Lulus ' + eHtml(item.graduation_year)) : ''}</div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" class="px-3 py-1.5 rounded-full text-accent text-xs font-semibold" data-action="edit-education" data-index="${idx}">Edit</button>
                    <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" data-action="delete-education" data-index="${idx}">Hapus</button>
                </div>
            </div>
        `;
        cardRoot.appendChild(card);
    });

    const item = educationItems[0] || {};
    hidden.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="education_level" value="${eHtml(item.education_level || '')}">
        <input type="hidden" name="graduation_year" value="${eHtml(item.graduation_year || '')}">
        <input type="hidden" name="education_major" value="${eHtml(item.education_major || '')}">
        <input type="hidden" name="education_university" value="${eHtml(item.education_university || '')}">
    `);
}

function renderWorkItems() {
    const list = document.getElementById('work-experiences');
    const hidden = document.getElementById('work-experiences-inputs');
    list.innerHTML = '';
    hidden.innerHTML = '';

    if (!workItems.length) {
        list.innerHTML = '<div class="text-sm text-muted">Belum ada pengalaman kerja.</div>';
        return;
    }

    workItems.forEach((item, idx) => {
        const card = document.createElement('div');
        card.className = 'rounded-2xl border border-muted p-3';
        card.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-sm font-semibold text-default">${eHtml(item.title || '-')}</div>
                    <div class="text-xs text-muted">${eHtml(item.company_name || '-')}</div>
                    <div class="text-xs text-muted">${eHtml(item.year_start || '-')} - ${eHtml(item.year_end || '-')}</div>
                    <div class="text-xs text-default mt-1">${eHtml(item.description || '-')}</div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" class="px-3 py-1.5 rounded-full text-accent text-xs font-semibold" data-action="edit-work" data-index="${idx}">Edit</button>
                    <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" data-action="delete-work" data-index="${idx}">Hapus</button>
                </div>
            </div>
        `;
        list.appendChild(card);

        hidden.insertAdjacentHTML('beforeend', `
            <input type="hidden" name="work_title[]" value="${eHtml(item.title || '')}">
            <input type="hidden" name="work_company[]" value="${eHtml(item.company_name || '')}">
            <input type="hidden" name="work_year_start[]" value="${eHtml(item.year_start || '')}">
            <input type="hidden" name="work_year_end[]" value="${eHtml(item.year_end || '')}">
            <input type="hidden" name="work_description[]" value="${eHtml(item.description || '')}">
        `);
    });
}

function renderAchievementItems() {
    const list = document.getElementById('achievements');
    const hidden = document.getElementById('achievements-inputs');
    list.innerHTML = '';
    hidden.innerHTML = '';

    if (!achievementItems.length) {
        list.innerHTML = '<div class="text-sm text-muted">Belum ada pencapaian.</div>';
        return;
    }

    achievementItems.forEach((item, idx) => {
        const typeText = achTypeLabels[item.type] || item.type || '-';
        const levelText = achLevelLabels[item.level] || item.level || '-';
        const card = document.createElement('div');
        card.className = 'rounded-2xl border border-muted p-3';
        card.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-sm font-semibold text-default">${eHtml(item.title || '-')}</div>
                    <div class="text-xs text-muted">${eHtml(typeText)} | ${eHtml(item.year || '-')} | ${eHtml(levelText)}</div>
                    <div class="text-xs text-muted">${eHtml(item.organizer || '-')}</div>
                    <div class="text-xs text-default mt-1">${eHtml(item.description || '-')}</div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" class="px-3 py-1.5 rounded-full text-accent text-xs font-semibold" data-action="edit-achievement" data-index="${idx}">Edit</button>
                    <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" data-action="delete-achievement" data-index="${idx}">Hapus</button>
                </div>
            </div>
        `;
        list.appendChild(card);

        hidden.insertAdjacentHTML('beforeend', `
            <input type="hidden" name="ach_type[]" value="${eHtml(item.type || '')}">
            <input type="hidden" name="ach_title[]" value="${eHtml(item.title || '')}">
            <input type="hidden" name="ach_description[]" value="${eHtml(item.description || '')}">
            <input type="hidden" name="ach_organizer[]" value="${eHtml(item.organizer || '')}">
            <input type="hidden" name="ach_year[]" value="${eHtml(item.year || '')}">
            <input type="hidden" name="ach_rank[]" value="${eHtml(item.rank || '')}">
            <input type="hidden" name="ach_level[]" value="${eHtml(item.level || '')}">
            <input type="hidden" name="ach_certificate_link[]" value="${eHtml(item.certificate_link || '')}">
        `);
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
window.openModal = openModal;
window.closeModal = closeModal;

let editingWorkIndex = -1;
let editingAchievementIndex = -1;

const addWorkBtn = document.getElementById('add-work-exp');
if (addWorkBtn) {
    addWorkBtn.addEventListener('click', function () {
        editingWorkIndex = -1;
        const form = document.getElementById('work-form');
        if (form) form.reset();
        openModal('work-modal');
    });
}

const addEducationBtn = document.getElementById('add-education');
let editingEducationIndex = -1;
if (addEducationBtn) {
    addEducationBtn.addEventListener('click', function () {
        editingEducationIndex = -1;
        const form = document.getElementById('education-form');
        if (!form) return;
        form.reset();
        openModal('education-modal');
    });
}

const addAchievementBtn = document.getElementById('add-achievement');
if (addAchievementBtn) {
    addAchievementBtn.addEventListener('click', function () {
        editingAchievementIndex = -1;
        const form = document.getElementById('achievement-form');
        if (form) form.reset();
        openModal('achievement-modal');
    });
}

document.getElementById('work-save-btn').addEventListener('click', function () {
    const form = document.getElementById('work-form');
    const item = {
        title: form.querySelector('[name="title"]').value.trim(),
        company_name: form.querySelector('[name="company_name"]').value.trim(),
        year_start: form.querySelector('[name="year_start"]').value.trim(),
        year_end: form.querySelector('[name="year_end"]').value.trim(),
        description: form.querySelector('[name="description"]').value.trim(),
    };
    if (!item.title) return;
    if (editingWorkIndex >= 0) workItems[editingWorkIndex] = item;
    else workItems.unshift(item);
    renderWorkItems();
    closeModal('work-modal');
});

document.getElementById('achievement-save-btn').addEventListener('click', function () {
    const form = document.getElementById('achievement-form');
    const item = {
        type: form.querySelector('[name="type"]').value.trim(),
        title: form.querySelector('[name="title"]').value.trim(),
        description: form.querySelector('[name="description"]').value.trim(),
        organizer: form.querySelector('[name="organizer"]').value.trim(),
        year: form.querySelector('[name="year"]').value.trim(),
        rank: form.querySelector('[name="rank"]').value.trim(),
        level: form.querySelector('[name="level"]').value.trim(),
        certificate_link: form.querySelector('[name="certificate_link"]').value.trim(),
    };
    if (!item.title) return;
    if (editingAchievementIndex >= 0) achievementItems[editingAchievementIndex] = item;
    else achievementItems.unshift(item);
    renderAchievementItems();
    closeModal('achievement-modal');
});

document.getElementById('education-save-btn').addEventListener('click', function () {
    const form = document.getElementById('education-form');
    const item = {
        education_level: form.querySelector('[name="education_level"]').value.trim(),
        graduation_year: form.querySelector('[name="graduation_year"]').value.trim(),
        education_major: form.querySelector('[name="education_major"]').value.trim(),
        education_university: form.querySelector('[name="education_university"]').value.trim(),
    };
    if (!hasEducation(item)) return;
    educationItems = [item];
    editingEducationIndex = 0;
    renderEducationItems();
    closeModal('education-modal');
});

document.addEventListener('click', function (event) {
    const btn = event.target.closest('button[data-action]');
    if (!btn) return;
    const action = btn.dataset.action;
    if (action === 'edit-education') {
        const index = parseInt(btn.dataset.index || '-1', 10);
        if (index < 0) return;
        const item = educationItems[index];
        if (!item) return;
        editingEducationIndex = index;
        const form = document.getElementById('education-form');
        form.querySelector('[name="education_level"]').value = item.education_level || '';
        form.querySelector('[name="graduation_year"]').value = item.graduation_year || '';
        form.querySelector('[name="education_major"]').value = item.education_major || '';
        form.querySelector('[name="education_university"]').value = item.education_university || '';
        openModal('education-modal');
        return;
    }
    if (action === 'delete-education') {
        const index = parseInt(btn.dataset.index || '-1', 10);
        if (index < 0) return;
        educationItems.splice(index, 1);
        renderEducationItems();
        return;
    }
    const index = parseInt(btn.dataset.index || '-1', 10);
    if (index < 0) return;
    if (action === 'delete-work') {
        workItems.splice(index, 1);
        renderWorkItems();
        return;
    }
    if (action === 'delete-achievement') {
        achievementItems.splice(index, 1);
        renderAchievementItems();
        return;
    }
    if (action === 'edit-work') {
        const item = workItems[index];
        if (!item) return;
        editingWorkIndex = index;
        const form = document.getElementById('work-form');
        form.querySelector('[name="title"]').value = item.title || '';
        form.querySelector('[name="company_name"]').value = item.company_name || '';
        form.querySelector('[name="year_start"]').value = item.year_start || '';
        form.querySelector('[name="year_end"]').value = item.year_end || '';
        form.querySelector('[name="description"]').value = item.description || '';
        openModal('work-modal');
        return;
    }
    if (action === 'edit-achievement') {
        const item = achievementItems[index];
        if (!item) return;
        editingAchievementIndex = index;
        const form = document.getElementById('achievement-form');
        form.querySelector('[name="type"]').value = item.type || '';
        form.querySelector('[name="title"]').value = item.title || '';
        form.querySelector('[name="description"]').value = item.description || '';
        form.querySelector('[name="organizer"]').value = item.organizer || '';
        form.querySelector('[name="year"]').value = item.year || '';
        form.querySelector('[name="rank"]').value = item.rank || '';
        form.querySelector('[name="level"]').value = item.level || '';
        form.querySelector('[name="certificate_link"]').value = item.certificate_link || '';
        openModal('achievement-modal');
    }
});

const navLinks = Array.from(document.querySelectorAll('.settings-nav-link'));
const sections = navLinks.map(link => document.querySelector(link.getAttribute('href'))).filter(Boolean);
function setActiveLink(id) {
    navLinks.forEach(link => {
        const active = link.getAttribute('href') === '#' + id;
        link.classList.toggle('bg-muted', active);
        link.classList.toggle('text-accent', active);
        link.classList.toggle('font-semibold', active);
    });
}
navLinks.forEach(link => {
    link.addEventListener('click', function (event) {
        const targetId = (link.getAttribute('href') || '').replace('#', '');
        const target = targetId ? document.getElementById(targetId) : null;
        if (!target) return;
        event.preventDefault();
        setActiveLink(targetId);
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
window.addEventListener('scroll', function () {
    let activeId = sections[0] ? sections[0].id : '';
    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top <= 140) activeId = section.id;
    });
    if (activeId) setActiveLink(activeId);
});

renderEducationItems();
renderWorkItems();
renderAchievementItems();
if (sections[0]) setActiveLink(sections[0].id);
});
</script>

<div id="education-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-2xl rounded-2xl bg-surface border border-muted p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-semibold text-default">Form Data Pendidikan</h3>
            <button type="button" class="text-sm text-muted" onclick="closeModal('education-modal')">Tutup</button>
        </div>
        <form id="education-form" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input name="education_level" placeholder="Pendidikan Terakhir" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="graduation_year" placeholder="Tahun Lulus" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="education_major" placeholder="Jurusan" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="education_university" placeholder="Nama Universitas / Instansi" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
        </form>
        <div class="flex justify-end gap-2 mt-3">
            <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" onclick="closeModal('education-modal')">Batal</button>
            <button type="button" id="education-save-btn" class="px-3 py-1.5 rounded-full bg-accent text-white text-xs font-semibold">Simpan</button>
        </div>
    </div>
</div>

<div id="work-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-2xl rounded-2xl bg-surface border border-muted p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-semibold text-default">Form Pengalaman Kerja</h3>
            <button type="button" class="text-sm text-muted" onclick="closeModal('work-modal')">Tutup</button>
        </div>
        <form id="work-form" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input name="title" placeholder="Judul / Jabatan" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="company_name" placeholder="Nama Instansi" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="year_start" placeholder="Tahun Mulai" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="year_end" placeholder="Tahun Selesai" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <textarea name="description" rows="3" placeholder="Deskripsi" class="md:col-span-2 w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm"></textarea>
        </form>
        <div class="flex justify-end gap-2 mt-3">
            <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" onclick="closeModal('work-modal')">Batal</button>
            <button type="button" id="work-save-btn" class="px-3 py-1.5 rounded-full bg-accent text-white text-xs font-semibold">Simpan</button>
        </div>
    </div>
</div>

<div id="achievement-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-3xl rounded-2xl bg-surface border border-muted p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-semibold text-default">Form Pencapaian</h3>
            <button type="button" class="text-sm text-muted" onclick="closeModal('achievement-modal')">Tutup</button>
        </div>
        <form id="achievement-form" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <select name="type" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm">
                <option value="">Pilih Jenis</option>
                <?php foreach ($achTypes as $k => $l): ?><option value="<?= $k ?>"><?= $l ?></option><?php endforeach; ?>
            </select>
            <input name="title" placeholder="Judul Kegiatan" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="organizer" placeholder="Penyelenggara" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="year" placeholder="Tahun" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <input name="rank" placeholder="Peringkat" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
            <select name="level" class="w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm">
                <option value="">Pilih Tingkat</option>
                <?php foreach ($achLevels as $k => $l): ?><option value="<?= $k ?>"><?= $l ?></option><?php endforeach; ?>
            </select>
            <textarea name="description" rows="3" placeholder="Deskripsi" class="md:col-span-2 w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm"></textarea>
            <input name="certificate_link" placeholder="Link Sertifikat" class="md:col-span-2 w-full rounded-xl border border-default bg-surface px-3 py-2 text-sm" />
        </form>
        <div class="flex justify-end gap-2 mt-3">
            <button type="button" class="px-3 py-1.5 rounded-full bg-danger text-white text-xs font-semibold" onclick="closeModal('achievement-modal')">Batal</button>
            <button type="button" id="achievement-save-btn" class="px-3 py-1.5 rounded-full bg-accent text-white text-xs font-semibold">Simpan</button>
        </div>
    </div>
</div>
