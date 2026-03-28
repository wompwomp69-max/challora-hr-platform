-- Foto profil pengguna (bukan pas foto lamaran)
USE challora_recruitment;

ALTER TABLE users
  ADD COLUMN avatar_path VARCHAR(255) DEFAULT NULL COMMENT 'Relatif ke root proyek, mis. storage/photos/avatar_1_xxx.jpg';
