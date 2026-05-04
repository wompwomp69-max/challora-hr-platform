-- Deterministic dummy data for local testing:
-- - Create exactly 10 dummy users with complete profile fields
-- - Each dummy user applies to exactly 3 distinct jobs (when >= 3 jobs exist)
-- - Safe/idempotent inserts (does not delete or overwrite real data)
-- Password plaintext for all dummy users: password123
-- Password hash (bcrypt): compatible with Laravel Auth

START TRANSACTION;

-- =========================================================
-- STEP 1: Insert 10 complete dummy users (if not exists).
-- Naming convention:
-- - name  : user_{n}_dummy
-- - email : user_{n}_dummy@mail.com
-- =========================================================
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
    CONCAT('user_', d.n, '_dummy') AS name,
    CONCAT('user_', d.n, '_dummy@mail.com') AS email,
    NOW() AS email_verified_at,
    '$2y$10$JpvUfqVraSXeTbmIv9yH2e0a3CkeZWN/ur5s./358S7jrpVzvfgV.' AS password,
    'user' AS role,
    CONCAT('62812', LPAD(90010000 + d.n, 8, '0')) AS phone,
    CONCAT('Jl. Dummy Kandidat No. ', d.n, ', Kota Bandung, Jawa Barat') AS address,
    CONCAT('father_', d.n, '_dummy') AS father_name,
    CONCAT('mother_', d.n, '_dummy') AS mother_name,
    'Belum Menikah' AS marital_status,
    'S1' AS education_level,
    CAST(2014 + d.n AS CHAR) AS graduation_year,
    'Teknik Informatika' AS education_major,
    'Universitas Negeri Dummy' AS education_university,
    IF(MOD(d.n, 2) = 0, 'Perempuan', 'Laki-laki') AS gender,
    'Islam' AS religion,
    CONCAT('@user_', d.n, '_dummy') AS social_media,
    'Bandung' AS birth_place,
    DATE_ADD('1997-01-15', INTERVAL d.n * 120 DAY) AS birth_date,
    'Wiraswasta' AS father_job,
    'Guru' AS mother_job,
    'SMA' AS father_education,
    'S1' AS mother_education,
    CONCAT('62813', LPAD(77001000 + d.n, 8, '0')) AS father_phone,
    CONCAT('62813', LPAD(88001000 + d.n, 8, '0')) AS mother_phone,
    'domisili' AS address_type,
    CONCAT('Jl. Keluarga Dummy No. ', d.n, ', Kabupaten Bandung') AS address_family,
    CONCAT('emergency_', d.n, '_dummy') AS emergency_name,
    CONCAT('62811', LPAD(66001000 + d.n, 8, '0')) AS emergency_phone,
    CONCAT('Profil kandidat dummy ke-', d.n, ' untuk pengujian fitur rekrutmen.') AS user_summary,
    CONCAT('photos/avatar-user-', d.n, '-dummy.jpg') AS avatar_path,
    CONCAT('cv/cv-user-', d.n, '-dummy.pdf') AS cv_path,
    CONCAT('diplomas/diploma-user-', d.n, '-dummy.pdf') AS diploma_path,
    CONCAT('photos/photo-user-', d.n, '-dummy.jpg') AS photo_path,
    NULL AS remember_token,
    NOW() AS created_at,
    NOW() AS updated_at
FROM (
    SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
) d
WHERE NOT EXISTS (
    SELECT 1
    FROM users u
    WHERE u.email = CONCAT('user_', d.n, '_dummy@mail.com')
);

-- =========================================================
-- STEP 2: Build deterministic user-job pairing.
-- Logic:
-- - Take only the 10 dummy users above.
-- - Take jobs ordered by id.
-- - For each user, pick 3 jobs using modular offsets based on user order.
-- - Ensures distinct jobs per user when total jobs >= 3.
-- - Idempotent insert to avoid duplicate (user_id, job_id) pairs.
-- =========================================================
SET @job_count := (SELECT COUNT(*) FROM job_postings);

INSERT INTO applications (
    user_id,
    job_id,
    cv_path,
    diploma_path,
    photo_path,
    status,
    created_at,
    updated_at
)
SELECT
    map.user_id,
    map.job_id,
    map.cv_path,
    map.diploma_path,
    map.photo_path,
    'pending' AS status,
    NOW() AS created_at,
    NOW() AS updated_at
FROM (
    SELECT
        du.user_id,
        du.user_pos,
        du.cv_path,
        du.diploma_path,
        du.photo_path,
        j1.id AS job_id
    FROM (
        SELECT
            u.id AS user_id,
            u.cv_path,
            u.diploma_path,
            u.photo_path,
            ROW_NUMBER() OVER (ORDER BY u.id) AS user_pos
        FROM users u
        WHERE u.email LIKE 'user\_%\_dummy@mail.com'
        ORDER BY u.id
        LIMIT 10
    ) du
    JOIN (
        SELECT id, ROW_NUMBER() OVER (ORDER BY id) AS job_pos
        FROM job_postings
    ) j1
      ON j1.job_pos = ((du.user_pos - 1) MOD NULLIF(@job_count, 0)) + 1

    UNION ALL

    SELECT
        du.user_id,
        du.user_pos,
        du.cv_path,
        du.diploma_path,
        du.photo_path,
        j2.id AS job_id
    FROM (
        SELECT
            u.id AS user_id,
            u.cv_path,
            u.diploma_path,
            u.photo_path,
            ROW_NUMBER() OVER (ORDER BY u.id) AS user_pos
        FROM users u
        WHERE u.email LIKE 'user\_%\_dummy@mail.com'
        ORDER BY u.id
        LIMIT 10
    ) du
    JOIN (
        SELECT id, ROW_NUMBER() OVER (ORDER BY id) AS job_pos
        FROM job_postings
    ) j2
      ON j2.job_pos = ((du.user_pos) MOD NULLIF(@job_count, 0)) + 1

    UNION ALL

    SELECT
        du.user_id,
        du.user_pos,
        du.cv_path,
        du.diploma_path,
        du.photo_path,
        j3.id AS job_id
    FROM (
        SELECT
            u.id AS user_id,
            u.cv_path,
            u.diploma_path,
            u.photo_path,
            ROW_NUMBER() OVER (ORDER BY u.id) AS user_pos
        FROM users u
        WHERE u.email LIKE 'user\_%\_dummy@mail.com'
        ORDER BY u.id
        LIMIT 10
    ) du
    JOIN (
        SELECT id, ROW_NUMBER() OVER (ORDER BY id) AS job_pos
        FROM job_postings
    ) j3
      ON j3.job_pos = ((du.user_pos + 1) MOD NULLIF(@job_count, 0)) + 1
) map
LEFT JOIN applications a
    ON a.user_id = map.user_id
   AND a.job_id = map.job_id
WHERE @job_count >= 3
  AND a.id IS NULL;

COMMIT;

-- =========================================================
-- VALIDATION QUERIES (run manually after script execution)
-- 1) Should return 10
--    SELECT COUNT(*) AS total_dummy_users
--    FROM users
--    WHERE email LIKE 'user\_%\_dummy@mail.com';
--
-- 2) Should return 30 (if total job_postings >= 3)
--    SELECT COUNT(*) AS total_dummy_applications
--    FROM applications a
--    JOIN users u ON u.id = a.user_id
--    WHERE u.email LIKE 'user\_%\_dummy@mail.com';
--
-- 3) Each user should have exactly 3 rows
--    SELECT u.email, COUNT(*) AS total_apps
--    FROM applications a
--    JOIN users u ON u.id = a.user_id
--    WHERE u.email LIKE 'user\_%\_dummy@mail.com'
--    GROUP BY u.id, u.email
--    ORDER BY u.id;
-- =========================================================
