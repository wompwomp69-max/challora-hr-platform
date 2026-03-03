# HR Recruitment App

Aplikasi rekrutmen dengan 2 role: **HR** dan **User (kandidat)**. MVC, PHP native, MySQL, session-based auth, role-based access control.

## Struktur

```
app/
├── controllers/   AuthController, JobController, ApplicationController, UserController, HrController, DownloadController
├── models/        User, Job, Application
├── views/         auth/, user/, hr/, jobs/, applications/
└── helpers.php
config/            database.php, app.php
database/          schema.sql, migration_cv_and_status.sql (jika DB sudah ada)
storage/cv/        Upload CV (writable)
public/            index.php (front controller), .htaccess
```

## Setup

1. **Database**
   - Buat database dan tabel: import `database/schema.sql` lewat phpMyAdmin atau CLI:
     ```bash
     mysql -u root -p < database/schema.sql
     ```
   - Atau jalankan isi file tersebut di MySQL. Schema sudah include pembuatan DB `challora_recruitment` dan satu user HR.

2. **Config**
   - Edit `config/database.php` jika perlu (host, user, password, nama DB).
   - Jika app tidak di subfolder `challorav2`, ubah `BASE_URL` di `config/app.php`.

3. **Storage**
   - Folder `storage/cv/` harus writable (untuk upload CV). Di Linux: `chmod 755 storage storage/cv` atau `chmod 777 storage/cv` jika perlu.

4. **Web server**
   - Akses lewat **public**: `http://localhost/challorav2/public/`
   - Pastikan mod_rewrite aktif (Apache) agar URL bersih. Jika tidak, pakai: `http://localhost/challorav2/public/index.php?url=jobs`

## Akun default

- **HR:** email `hr@example.com`, password `password123`
- **User:** daftar lewat menu Daftar (role kandidat)

## Alur

- **Login** → role `hr` → redirect ke `/hr/jobs`; role `user` → redirect ke `/jobs`
- **User:** Login → List Jobs → Detail Job → Apply (upload CV) → Status Lamaran (pending / accepted / rejected) → Edit profil.
- **HR:** Login → Buat/Edit/Hapus lowongan → Lihat pelamar per job → Unduh CV → Update status (pending / accepted / rejected).

Semua route selain `/auth/*` wajib login; cek di controller, bukan cuma sembunyiin tombol.

## Keamanan

- Password: `password_hash()` / `password_verify()`
- Query: PDO prepared statements
- Setiap akses: cek session + role di controller
- Output di view: escape pakai `e()` (htmlspecialchars)
- Apply: UNIQUE(user_id, job_id) di DB + cek di PHP; upload CV: validasi MIME (PDF/DOCX), extension, max 2MB, rename file (no .php)

## Route (konsep)

| Method | URL | Keterangan |
|--------|-----|------------|
| GET | /jobs | List lowongan (wajib login) |
| GET | /jobs/show?id= | Detail lowongan |
| POST | /jobs/apply | Apply + upload CV (user, multipart) |
| GET | /applications | Status lamaran (Job Title \| Status) |
| GET | /user/profile | Profil kandidat |
| GET/POST | /user/profile/edit | Edit profil |
| GET | /download/cv?id= | Unduh CV (HR/user punya akses) |
| GET | /hr/jobs | Dashboard HR |
| GET/POST | /hr/jobs/create | Form buat lowongan |
| GET/POST | /hr/jobs/edit?id= | Form edit lowongan |
| POST | /hr/jobs/delete | Hapus lowongan |
| GET | /hr/jobs/applicants?id= | Daftar pelamar per job |
| POST | /hr/applications/update-status | Update status lamaran |
