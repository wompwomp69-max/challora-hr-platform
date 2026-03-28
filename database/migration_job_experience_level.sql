-- Tambah kolom pengalaman level ke tabel jobs (untuk filter user)
USE challora_recruitment;

ALTER TABLE jobs
  ADD COLUMN experience_level VARCHAR(50) DEFAULT NULL COMMENT 'Level pengalaman yang disarankan, mis. fresh_grad, junior_1_3, senior_5_10';

