-- Rename kolom job_description menjadi user_summary pada tabel users
USE challora_recruitment;

ALTER TABLE users
  CHANGE COLUMN job_description user_summary TEXT DEFAULT NULL;

