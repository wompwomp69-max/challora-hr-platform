-- Jalankan sekali jika HR login gagal (password lama "password", sekarang jadi "password123")
USE challora_recruitment;
UPDATE users SET password = '$2y$10$4oRFX8dxR0zUx9eC2QvQeu2ZrOkb.a7pR2tVAwREUab2Fda8kk8cC' WHERE email = 'hr@example.com';
