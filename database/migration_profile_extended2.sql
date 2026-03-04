-- Extended user profile - pribadi, keluarga lanjutan, kontak darurat, pekerjaan, achievement
-- Jalankan setelah migration_profile_extended.sql

USE challora_recruitment;

ALTER TABLE users
  ADD COLUMN gender VARCHAR(20) DEFAULT NULL,
  ADD COLUMN religion VARCHAR(50) DEFAULT NULL,
  ADD COLUMN social_media VARCHAR(255) DEFAULT NULL,
  ADD COLUMN birth_place VARCHAR(100) DEFAULT NULL,
  ADD COLUMN birth_date DATE DEFAULT NULL,
  ADD COLUMN father_job VARCHAR(150) DEFAULT NULL,
  ADD COLUMN mother_job VARCHAR(150) DEFAULT NULL,
  ADD COLUMN father_education VARCHAR(100) DEFAULT NULL,
  ADD COLUMN mother_education VARCHAR(100) DEFAULT NULL,
  ADD COLUMN father_phone VARCHAR(30) DEFAULT NULL,
  ADD COLUMN mother_phone VARCHAR(30) DEFAULT NULL,
  ADD COLUMN address_type VARCHAR(50) DEFAULT NULL COMMENT 'same, separate',
  ADD COLUMN address_family TEXT DEFAULT NULL,
  ADD COLUMN emergency_name VARCHAR(100) DEFAULT NULL,
  ADD COLUMN emergency_phone VARCHAR(30) DEFAULT NULL,
  ADD COLUMN job_description TEXT DEFAULT NULL;

CREATE TABLE IF NOT EXISTS user_achievements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  type VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT DEFAULT NULL,
  organizer VARCHAR(255) DEFAULT NULL,
  year VARCHAR(10) DEFAULT NULL,
  rank VARCHAR(100) DEFAULT NULL,
  level VARCHAR(50) DEFAULT NULL COMMENT 'city, province, national, international',
  certificate_link VARCHAR(500) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

