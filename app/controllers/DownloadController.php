<?php
/**
 * Secure file download: CV hanya untuk HR (pemilik job) atau user (pemilik lamaran)
 */
class DownloadController {
    private Application $appModel;
    private Job $jobModel;

    public function __construct() {
        $this->appModel = new Application();
        $this->jobModel = new Job();
    }

    public function cv(): void {
        requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1) {
            $_SESSION['flash_error'] = 'Tidak valid.';
            redirect('/jobs');
        }
        $app = $this->appModel->findById($id);
        if (!$app || empty($app['cv_path'])) {
            $_SESSION['flash_error'] = 'CV tidak ditemukan.';
            redirect('/jobs');
        }
        $uid = currentUserId();
        $role = currentRole();
        $allowed = false;
        if ($role === 'hr') {
            $allowed = $this->jobModel->isCreatedBy((int)$app['job_id'], $uid);
        } elseif ($role === 'user') {
            $allowed = ((int)$app['user_id']) === $uid;
        }
        if (!$allowed) {
            $_SESSION['flash_error'] = 'Akses ditolak.';
            redirect('/jobs');
        }
        $path = BASE_PATH . '/' . $app['cv_path'];
        if (!preg_match('#^storage/cv/[a-zA-Z0-9_.-]+$#', $app['cv_path']) || !is_file($path)) {
            $_SESSION['flash_error'] = 'File tidak ditemukan.';
            redirect('/jobs');
        }
        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $filename = basename($app['cv_path']);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
