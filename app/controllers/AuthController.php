<?php
class AuthController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login(): void {
        if (isLoggedIn()) {
            redirect(currentRole() === 'hr' ? '/hr/jobs' : '/jobs');
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf();
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Simple Rate Limiting
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $limitFile = BASE_PATH . '/storage/logs/login_attempts.json';
            $attempts = file_exists($limitFile) ? json_decode(file_get_contents($limitFile), true) : [];
            $now = time();
            $attemptData = $attempts[$ip] ?? ['count' => 0, 'last' => 0];

            if ($attemptData['count'] >= 5 && ($now - $attemptData['last']) < 300) {
                $error = 'Terlalu banyak percobaan login. Silakan coba lagi dalam 5 menit.';
            } else {
                if ($email === '' || $password === '') {
                    $error = 'Email dan password wajib diisi.';
                } else {
                    $user = $this->userModel->findByEmail($email);
                    if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
                        $error = 'Email atau password salah.';
                        // Increment attempts
                        $attemptData['count']++;
                        $attemptData['last'] = $now;
                        $attempts[$ip] = $attemptData;
                        file_put_contents($limitFile, json_encode($attempts));
                    } else {
                        // Success: Reset attempts
                        unset($attempts[$ip]);
                        file_put_contents($limitFile, json_encode($attempts));

                        session_regenerate_id(true);
                        $_SESSION['user_id'] = (int) $user['id'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_avatar_path'] = !empty($user['avatar_path']) ? (string) $user['avatar_path'] : '';
                        $_SESSION['user_avatar_ver'] = !empty($user['avatar_path']) ? md5((string) $user['avatar_path']) : '0';
                        if ($user['role'] === 'hr') {
                            redirect('/hr/jobs');
                        }
                        redirect('/jobs');
                    }
                }
            }
        }
        render_view('auth/login', ['error' => $error, 'pageTitle' => 'Login']);
    }

    public function register(): void {
        if (isLoggedIn()) {
            redirect(currentRole() === 'hr' ? '/hr/jobs' : '/jobs');
        }
        $error = '';
        $old = ['name' => '', 'email' => '', 'phone' => '', 'address' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf();

            // Registration Rate Limiting
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $limitFile = BASE_PATH . '/storage/logs/registration_attempts.json';
            $attempts = file_exists($limitFile) ? json_decode(file_get_contents($limitFile), true) : [];
            $now = time();
            $attemptData = $attempts[$ip] ?? ['count' => 0, 'last' => 0];

            if ($attemptData['count'] >= 5 && ($now - $attemptData['last']) < 3600) {
                $error = 'Terlalu banyak percobaan registrasi. Silakan coba lagi dalam 1 jam.';
            } else {
                $old['name'] = trim($_POST['name'] ?? '');
                $old['email'] = trim($_POST['email'] ?? '');
                $old['phone'] = trim($_POST['phone'] ?? '');
                $old['address'] = trim($_POST['address'] ?? '');
                $password = $_POST['password'] ?? '';
                $password_confirm = $_POST['password_confirm'] ?? '';

                $passwordError = validatePasswordStrength($password);

                if ($old['name'] === '' || $old['email'] === '' || $password === '') {
                    $error = 'Nama, email, dan password wajib diisi.';
                } elseif ($passwordError) {
                    $error = $passwordError;
                } elseif ($password !== $password_confirm) {
                    $error = 'Konfirmasi password tidak cocok.';
                } elseif ($this->userModel->findByEmail($old['email'])) {
                    $error = 'Email sudah terdaftar.';
                    // Track attempt for existing email as well to prevent discovery spam
                    $attemptData['count']++;
                    $attemptData['last'] = $now;
                    $attempts[$ip] = $attemptData;
                    @file_put_contents($limitFile, json_encode($attempts));
                } else {
                    // Success: Reset attempts for this IP
                    unset($attempts[$ip]);
                    @file_put_contents($limitFile, json_encode($attempts));

                    $this->userModel->create($old['name'], $old['email'], $password, 'user', $old['phone'] ?: null, $old['address'] ?: null);
                    $_SESSION['flash'] = 'Registrasi berhasil. Silakan login.';
                    $_SESSION['flash_type'] = 'success';
                    redirect('/auth/login');
                }
            }
        }
        render_view('auth/register', ['error' => $error, 'old' => $old, 'pageTitle' => 'Daftar']);
    }

    public function logout(): void {
        session_regenerate_id(true);
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        redirect('/auth/login');
    }

    public function forgot(): void {
        if (isLoggedIn()) {
            redirect(currentRole() === 'hr' ? '/hr/jobs' : '/jobs');
        }
        $error = '';
        $success = '';
        $link = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf();
            $email = trim($_POST['email'] ?? '');
            if ($email === '') {
                $error = 'Email wajib diisi.';
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user) {
                    $token = $this->userModel->createPasswordResetToken((int)$user['id']);
                    $link  = BASE_URL . '/index.php?url=auth/reset&token=' . urlencode($token);

                    $mail = new MailService();
                    if ($mail->isEnabled()) {
                        $sent = $mail->sendPasswordReset($user['email'], $user['name'], $link);
                        if ($sent) {
                            $success = 'Instruksi reset password telah dikirim ke email Anda.';
                            $link = '';
                        } else {
                            $success = 'Gagal mengirim email, gunakan tautan berikut untuk mereset password:';
                        }
                    } else {
                        $success = 'Mail dinonaktifkan; gunakan tautan berikut untuk mereset password:';
                    }
                } else {
                    $success = 'Jika email terdaftar, instruksi reset password telah dikirim.';
                }
            }
        }
        render_view('auth/forgot', [
            'error' => $error,
            'success' => $success,
            'link' => $link,
            'pageTitle' => 'Lupa Password'
        ]);
    }

    public function reset(): void {
        if (isLoggedIn()) {
            redirect(currentRole() === 'hr' ? '/hr/jobs' : '/jobs');
        }
        $token = $_GET['token'] ?? $_POST['token'] ?? '';
        $error = '';
        $hasValidToken = false;
        $reset = null;
        if ($token !== '') {
            $reset = $this->userModel->getPasswordResetByToken($token);
            $hasValidToken = (bool) $reset;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf();
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['password_confirm'] ?? '';
            
            $passwordError = validatePasswordStrength($password);

            if (!$hasValidToken) {
                $error = 'Token tidak valid atau sudah kadaluarsa.';
            } elseif ($password === '' || $confirm === '') {
                $error = 'Password dan konfirmasi wajib diisi.';
            } elseif ($password !== $confirm) {
                $error = 'Konfirmasi tidak cocok.';
            } elseif ($passwordError) {
                $error = $passwordError;
            } else {
                if ($reset) {
                    $this->userModel->updatePassword((int)$reset['user_id'], $password);
                    $this->userModel->invalidatePasswordResetToken($token);
                    $_SESSION['flash'] = 'Password berhasil diubah. Silakan login.';
                    $_SESSION['flash_type'] = 'success';
                    redirect('/auth/login');
                } else {
                    $error = 'Token tidak valid atau sudah kadaluarsa.';
                }
            }
        } else {
            if ($token !== '') {
                if (!$hasValidToken) {
                    $error = 'Token tidak valid atau sudah kadaluarsa.';
                }
            } else {
                $error = 'Token tidak tersedia.';
            }
        }
        render_view('auth/reset', ['error' => $error, 'token' => $token, 'hasValidToken' => $hasValidToken, 'pageTitle' => 'Reset Password']);
    }
}
