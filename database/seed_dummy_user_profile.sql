-- Seed 1 kandidat dummy lengkap + 3 pengalaman kerja + 2 prestasi
-- Jalankan: mysql -u root challora_recruitment < database/seed_dummy_user_profile.sql

USE challora_recruitment;

SET @dummy_email = 'user_1_dummy@mail.com';

-- Password plain text untuk login dummy: password123
INSERT INTO users (
  name,
  email,
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
  user_summary
)
SELECT
  'user_1_dummy',
  @dummy_email,
  '$2y$10$4oRFX8dxR0zUx9eC2QvQeu2ZrOkb.a7pR2tVAwREUab2Fda8kk8cC',
  'user',
  '081234560001',
  'Jl. Raya Cibubur No. 18, Ciracas, Jakarta Timur',
  'Sutrisno',
  'Sri Wahyuni',
  'single',
  's1',
  '2022',
  'Sistem Informasi',
  'Universitas Gunadarma',
  'male',
  'islam',
  '@user_1_dummy',
  'Bogor',
  '2000-08-17',
  'Wiraswasta',
  'Ibu Rumah Tangga',
  'SMA',
  'SMA',
  '081234560101',
  '081234560102',
  'separate',
  'Jl. Melati No. 7, Bogor Tengah, Kota Bogor',
  'Budi Prasetyo',
  '081234560103',
  'Kandidat dummy untuk pengujian fitur profil, pengalaman kerja, dan pencapaian.'
WHERE NOT EXISTS (
  SELECT 1 FROM users WHERE email = @dummy_email
);

SET @dummy_user_id = (
  SELECT id
  FROM users
  WHERE email = @dummy_email
  LIMIT 1
);

INSERT INTO user_work_experiences (
  user_id,
  title,
  company_name,
  year_start,
  year_end,
  description,
  sort_order
)
SELECT
  source.user_id,
  source.title,
  source.company_name,
  source.year_start,
  source.year_end,
  source.description,
  source.sort_order
FROM (
  SELECT
    @dummy_user_id AS user_id,
    'Junior Web Developer' AS title,
    'PT Solusi Digital Nusantara' AS company_name,
    '2022' AS year_start,
    '2023' AS year_end,
    'Mengembangkan modul dashboard internal dan maintenance fitur recruitment. [dummy_data=true]' AS description,
    0 AS sort_order
  UNION ALL
  SELECT
    @dummy_user_id,
    'Frontend Developer',
    'CV Inovasi Teknologi Jakarta',
    '2023',
    '2024',
    'Membangun UI responsive berbasis Bootstrap dan optimasi performa halaman user settings. [dummy_data=true]',
    1
  UNION ALL
  SELECT
    @dummy_user_id,
    'Full Stack Developer',
    'PT Karya Aplikasi Indonesia',
    '2024',
    'Sekarang',
    'Menangani pengembangan fitur end-to-end (PHP, MySQL, JavaScript) untuk sistem rekrutmen. [dummy_data=true]',
    2
) AS source
WHERE source.user_id IS NOT NULL
  AND NOT EXISTS (
    SELECT 1
    FROM user_work_experiences existing
    WHERE existing.user_id = source.user_id
      AND existing.title = source.title
      AND existing.year_start = source.year_start
      AND existing.year_end = source.year_end
  );

INSERT INTO user_achievements (
  user_id,
  type,
  title,
  description,
  organizer,
  year,
  rank,
  level,
  certificate_link
)
SELECT
  source.user_id,
  source.type,
  source.title,
  source.description,
  source.organizer,
  source.year,
  source.rank,
  source.level,
  source.certificate_link
FROM (
  SELECT
    @dummy_user_id AS user_id,
    'kompetisi' AS type,
    'Finalis Hackathon Kota Bogor 2023' AS title,
    'Membuat prototipe platform rekrutmen UMKM berbasis web. [dummy_data=true]' AS description,
    'Dinas Kominfo Kota Bogor' AS organizer,
    '2023' AS year,
    'Finalis' AS rank,
    'kota' AS level,
    'https://example.com/certificate/user_1_dummy_hackathon' AS certificate_link
  UNION ALL
  SELECT
    @dummy_user_id,
    'sertifikasi',
    'Sertifikasi Junior Web Programmer (Dummy)',
    'Lulus pelatihan dan asesmen kompetensi pemrograman web dasar. [dummy_data=true]',
    'LSP Informatika Indonesia',
    '2024',
    'Lulus',
    'nasional',
    'https://example.com/certificate/user_1_dummy_jwp'
) AS source
WHERE source.user_id IS NOT NULL
  AND NOT EXISTS (
    SELECT 1
    FROM user_achievements existing
    WHERE existing.user_id = source.user_id
      AND existing.title = source.title
      AND existing.year = source.year
  );
