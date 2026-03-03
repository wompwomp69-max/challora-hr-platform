<?php
/**
 * HR: lihat applicant, update status
 */
class HrApplicationController {
    private Job $jobModel;
    private Application $appModel;

    public function __construct() {
        $this->jobModel = new Job();
        $this->appModel = new Application();
    }

    private function requireHr(): void {
        requireRole('hr');
    }

    public function index(): void {
        $this->requireHr();
        $jobId = (int) ($_GET['id'] ?? 0);
        if ($jobId < 1 || !$this->jobModel->isCreatedBy($jobId, currentUserId())) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/hr/jobs');
        }
        $job = $this->jobModel->findById($jobId);
        $applicants = $this->appModel->getByJobId($jobId);
        render_view('hr/applications/index', ['job' => $job, 'applicants' => $applicants, 'pageTitle' => 'Pelamar - ' . e($job['title'])]);
    }

    public function updateStatus(): void {
        $this->requireHr();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/hr/jobs');
        }
        $appId = (int) ($_POST['application_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $app = $this->appModel->getApplicationForHrJob($appId, currentUserId());
        if (!$app) {
            $_SESSION['flash_error'] = 'Data lamaran tidak ditemukan.';
            redirect('/hr/jobs');
        }
        if ($this->appModel->updateStatus($appId, $status)) {
            $_SESSION['flash'] = 'Status lamaran diperbarui.';
        }
        redirect('/hr/jobs/applicants?id=' . $app['job_id']);
    }
}
