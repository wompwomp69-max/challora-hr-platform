-- Jalankan sekali jika DB sudah ada (sebelumnya tanpa cv_path & status lama)
USE challora_recruitment;

-- 1. Tambah kolom cv_path
ALTER TABLE applications ADD COLUMN cv_path VARCHAR(255) DEFAULT NULL;

-- 2. Konversi status lama ke pending, lalu ubah ENUM
UPDATE applications SET status = 'pending' WHERE status IN ('applied', 'reviewed');
ALTER TABLE applications MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending';
