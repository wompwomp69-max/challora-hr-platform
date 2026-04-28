-- Insert 1 complete dummy user profile for Challora v2 (Laravel)
-- Password plaintext for login testing: password123
-- Password hash generated with bcrypt (PHP password_hash / Laravel compatible)

START TRANSACTION;

-- 1) Insert user only if email does not exist yet.
INSERT INTO users (
    name,
    email,
    email_verified_at,
    password,
    role,
    phone,
    address,
    father_name,
    mother_name,
    marital_status,
    education_level,
    graduation_year,
    education_major,
    education_university,
    gender,
    religion,
    social_media,
    birth_place,
    birth_date,
    father_job,
    mother_job,
    father_education,
    mother_education,
    father_phone,
    mother_phone,
    address_type,
    address_family,
    emergency_name,
    emergency_phone,
    user_summary,
    avatar_path,
    cv_path,
    diploma_path,
    photo_path,
    remember_token,
    created_at,
    updated_at
)
SELECT
    'user_1_dummy',
    'user_1_dummy@mail.com',
    NOW(),
    '$2y$10$JpvUfqVraSXeTbmIv9yH2e0a3CkeZWN/ur5s./358S7jrpVzvfgV.',
    'user',
    '6281290017781',
    'Jl. Cempaka Putih Tengah No. 17, Jakarta Pusat, DKI Jakarta',
    'Budi Santoso',
    'Siti Aminah',
    'Belum Menikah',
    'S1',
    '2022',
    'Teknik Informatika',
    'Universitas Indonesia',
    'Laki-laki',
    'Islam',
    '@user_1_dummy',
    'Bandung',
    '2000-08-17',
    'Wiraswasta',
    'Guru',
    'SMA',
    'S1',
    '6281290017782',
    '6281290017783',
    'domisili',
    'Jl. Melati Raya No. 9, Bandung, Jawa Barat',
    'Rina Hartati',
    '6281290017784',
    'Fresh graduate Informatika yang fokus pada pengembangan web berbasis Laravel dan React.',
    'photos/avatar-user-1-dummy.jpg',
    'cv/cv-user-1-dummy.pdf',
    'diplomas/diploma-user-1-dummy.pdf',
    'photos/photo-user-1-dummy.jpg',
    NULL,
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM users
    WHERE email = 'user_1_dummy@mail.com'
);

-- 2) Insert one work experience for the same user (avoid duplicate by title + company).
INSERT INTO user_work_experiences (
    user_id,
    title,
    company_name,
    year_start,
    year_end,
    description,
    created_at,
    updated_at
)
SELECT
    u.id,
    'Junior Web Developer',
    'PT Solusi Digital Nusantara',
    '2023',
    '2025',
    'Mengembangkan fitur recruitment dashboard, optimasi query MySQL, dan maintenance API internal.',
    NOW(),
    NOW()
FROM users u
WHERE u.email = 'user_1_dummy@mail.com'
  AND NOT EXISTS (
      SELECT 1
      FROM user_work_experiences uwe
      WHERE uwe.user_id = u.id
        AND uwe.title = 'Junior Web Developer'
        AND uwe.company_name = 'PT Solusi Digital Nusantara'
  );

-- 3) Insert one achievement for the same user (avoid duplicate by title + organizer).
INSERT INTO user_achievements (
    user_id,
    type,
    title,
    description,
    organizer,
    year,
    rank,
    level,
    certificate_link,
    created_at,
    updated_at
)
SELECT
    u.id,
    'sertifikasi',
    'Laravel Web Development Certification',
    'Sertifikasi kompetensi pengembangan aplikasi web modern menggunakan Laravel.',
    'BNSP x Digital Talent Scholarship',
    '2024',
    'Lulus',
    'Nasional',
    'https://example.com/certificate/user-1-dummy',
    NOW(),
    NOW()
FROM users u
WHERE u.email = 'user_1_dummy@mail.com'
  AND NOT EXISTS (
      SELECT 1
      FROM user_achievements ua
      WHERE ua.user_id = u.id
        AND ua.title = 'Laravel Web Development Certification'
        AND ua.organizer = 'BNSP x Digital Talent Scholarship'
  );

COMMIT;
