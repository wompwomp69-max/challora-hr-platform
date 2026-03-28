<?php
/**
 * Secure file download: CV, diploma, photo
 * HR atau user (pemilik lamaran) dapat mengakses
 */
class DownloadController {
    private Application $appModel;
    private Job $jobModel;
    private User $userModel;

    public function __construct() {
        $this->appModel = new Application();
        $this->jobModel = new Job();
        $this->userModel = new User();
    }

    public function cv(): void {
        $_GET['type'] = 'cv';
        $this->file();
    }

    /**
     * Preview dokumen milik user login (cv, diploma, photo)
     */
    public function userFile(): void {
        requireRole('user');
        $type = $_GET['type'] ?? '';
        if (!in_array($type, ['cv', 'diploma', 'photo'], true)) {
            $_SESSION['flash_error'] = 'Tipe dokumen tidak valid.';
            redirect('/user/settings');
        }

        $user = $this->userModel->findById(currentUserId());
        if (!$user) {
            redirect('/auth/logout');
        }
        $pathKey = $type === 'cv' ? 'cv_path' : ($type === 'diploma' ? 'diploma_path' : 'photo_path');
        $rel = (string) ($user[$pathKey] ?? '');
        if ($rel === '') {
            $_SESSION['flash_error'] = ucfirst($type) . ' belum diunggah.';
            redirect('/user/settings');
        }

        $pattern = '#^storage/(cv|diplomas|photos)/[a-zA-Z0-9_.-]+$#';
        $path = BASE_PATH . '/' . $rel;
        if (!preg_match($pattern, $rel) || !is_file($path)) {
            $_SESSION['flash_error'] = 'File tidak ditemukan.';
            redirect('/user/settings');
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . basename($rel) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    /**
     * Download a single document by type (cv, diploma, photo)
     */
    public function file(): void {
        requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $type = $_GET['type'] ?? '';
        if ($id < 1 || !in_array($type, ['cv', 'diploma', 'photo'], true)) {
            $_SESSION['flash_error'] = 'Tidak valid.';
            redirect('/jobs');
        }
        $app = $this->appModel->findById($id);
        if (!$app) {
            $_SESSION['flash_error'] = 'Lamaran tidak ditemukan.';
            redirect('/jobs');
        }
        $pathKey = $type === 'cv' ? 'cv_path' : ($type === 'diploma' ? 'diploma_path' : 'photo_path');
        if (empty($app[$pathKey])) {
            $_SESSION['flash_error'] = ucfirst($type) . ' tidak ditemukan.';
            redirect('/jobs');
        }
        $uid = currentUserId();
        $role = currentRole();
        $allowed = ($role === 'hr') || (($role === 'user') && ((int)$app['user_id']) === $uid);
        if (!$allowed) {
            $_SESSION['flash_error'] = 'Akses ditolak.';
            redirect('/jobs');
        }
        $path = BASE_PATH . '/' . $app[$pathKey];
        $pattern = '#^storage/(cv|diplomas|photos)/[a-zA-Z0-9_.-]+$#';
        if (!preg_match($pattern, $app[$pathKey]) || !is_file($path)) {
            $_SESSION['flash_error'] = 'File tidak ditemukan.';
            redirect('/jobs');
        }
        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $filename = basename($app[$pathKey]);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    /** Foto profil user yang sedang login (candidate) */
    public function avatar(): void {
        requireLogin();
        if (currentRole() !== 'user') {
            $_SESSION['flash_error'] = 'Akses ditolak.';
            redirect('/jobs');
        }
        $user = $this->userModel->findById(currentUserId());
        if (!$user || empty($user['avatar_path'])) {
            http_response_code(404);
            header('Content-Type: text/plain; charset=UTF-8');
            echo 'Not found';
            exit;
        }
        $rel = (string) $user['avatar_path'];
        $pattern = '#^storage/photos/[a-zA-Z0-9_.-]+$#';
        if (!preg_match($pattern, $rel)) {
            http_response_code(404);
            exit;
        }
        $path = BASE_PATH . '/' . $rel;
        if (!is_file($path)) {
            http_response_code(404);
            exit;
        }
        $mime = mime_content_type($path) ?: 'image/jpeg';
        header('Content-Type: ' . $mime);
        header('Cache-Control: private, max-age=3600');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    /**
     * Halaman berkas (CV, ijazah, pas foto) untuk satu lamaran
     */
    public function berkas(): void {
        requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1) {
            $_SESSION['flash_error'] = 'Tidak valid.';
            redirect('/jobs');
        }
        $app = $this->appModel->findById($id);
        if (!$app) {
            $_SESSION['flash_error'] = 'Lamaran tidak ditemukan.';
            redirect('/jobs');
        }
        $uid = currentUserId();
        $role = currentRole();
        $allowed = ($role === 'hr') || (($role === 'user') && ((int)$app['user_id']) === $uid);
        if (!$allowed) {
            $_SESSION['flash_error'] = 'Akses ditolak.';
            redirect('/jobs');
        }
        if ($role === 'hr' && ($app['status'] ?? '') === 'pending') {
            $this->appModel->updateStatus((int)$app['id'], 'reviewed');
            $app['status'] = 'reviewed';
        }
        render_view('hr/applications/berkas', ['app' => $app]);
    }
}
