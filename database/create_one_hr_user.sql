-- Buat 1 akun HR baru (aman dijalankan berulang, tidak duplikat email)
USE challora_recruitment;

SET @hr_name = 'HR Baru';
SET @hr_email = 'hrbaru@example.com';
-- Plain password: password123
SET @hr_password_hash = '$2y$10$4oRFX8dxR0zUx9eC2QvQeu2ZrOkb.a7pR2tVAwREUab2Fda8kk8cC';

INSERT INTO users (name, email, password, role)
SELECT @hr_name, @hr_email, @hr_password_hash, 'hr'
WHERE NOT EXISTS (
  SELECT 1 FROM users WHERE email = @hr_email
);
