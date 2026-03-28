-- Simpan dokumen lamaran kandidat di tabel users
USE challora_recruitment;

ALTER TABLE users
  ADD COLUMN cv_path VARCHAR(255) DEFAULT NULL COMMENT 'Relatif ke root proyek, mis. storage/cv/cv_1_xxx.pdf',
  ADD COLUMN diploma_path VARCHAR(255) DEFAULT NULL COMMENT 'Relatif ke root proyek, mis. storage/diplomas/diploma_1_xxx.pdf',
  ADD COLUMN photo_path VARCHAR(255) DEFAULT NULL COMMENT 'Relatif ke root proyek, mis. storage/photos/photo_1_xxx.jpg';
