<?php
/**
 * HR only: CRUD jobs, list applicants, update application status
 */
class HrController {
    private Job $jobModel;
    private Application $appModel;

    public function __construct() {
        $this->jobModel = new Job();
        $this->appModel = new Application();
    }

    private function requireHr(): void {
        requireRole('hr');
    }

    public function jobs(): void {
        $this->requireHr();
        $list = $this->jobModel->findByCreator(currentUserId());
        foreach ($list as &$j) {
            $j['applicant_count'] = count($this->appModel->getByJobId((int)$j['id']));
        }
        unset($j);
        render_view('hr/jobs', ['jobs' => $list, 'pageTitle' => 'Dashboard HR']);
    }

    public function jobCreate(): void {
        $this->requireHr();
        $error = '';
        $old = ['title' => '', 'description' => '', 'location' => '', 'salary_range' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old['title'] = trim($_POST['title'] ?? '');
            $old['description'] = trim($_POST['description'] ?? '');
            $old['location'] = trim($_POST['location'] ?? '');
            $old['salary_range'] = trim($_POST['salary_range'] ?? '');
            if ($old['title'] === '' || $old['description'] === '') {
                $error = 'Judul dan deskripsi wajib diisi.';
            } else {
                $this->jobModel->create([
                    'title' => $old['title'],
                    'description' => $old['description'],
                    'location' => $old['location'] ?: null,
                    'salary_range' => $old['salary_range'] ?: null,
                    'created_by' => currentUserId(),
                ]);
                $_SESSION['flash'] = 'Lowongan berhasil ditambahkan.';
                redirect('/hr/jobs');
            }
        }
        render_view('hr/job_form', ['error' => $error, 'old' => $old, 'job' => null, 'pageTitle' => 'Buat Lowongan']);
    }

    public function jobEdit(): void {
        $this->requireHr();
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1 || !$this->jobModel->isCreatedBy($id, currentUserId())) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/hr/jobs');
        }
        $job = $this->jobModel->findById($id);
        $error = '';
        $old = ['title' => $job['title'], 'description' => $job['description'], 'location' => $job['location'] ?? '', 'salary_range' => $job['salary_range'] ?? ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old['title'] = trim($_POST['title'] ?? '');
            $old['description'] = trim($_POST['description'] ?? '');
            $old['location'] = trim($_POST['location'] ?? '');
            $old['salary_range'] = trim($_POST['salary_range'] ?? '');
            if ($old['title'] === '' || $old['description'] === '') {
                $error = 'Judul dan deskripsi wajib diisi.';
            } else {
                $this->jobModel->update($id, $old);
                $_SESSION['flash'] = 'Lowongan berhasil diperbarui.';
                redirect('/hr/jobs');
            }
        }
        render_view('hr/job_form', ['error' => $error, 'old' => $old, 'job' => $job, 'pageTitle' => 'Edit Lowongan']);
    }

    public function jobDelete(): void {
        $this->requireHr();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/hr/jobs');
        }
        $id = (int) ($_POST['id'] ?? 0);
        if ($id < 1 || !$this->jobModel->isCreatedBy($id, currentUserId())) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/hr/jobs');
        }
        $this->jobModel->delete($id);
        $_SESSION['flash'] = 'Lowongan telah dihapus.';
        redirect('/hr/jobs');
    }

    public function jobApplicants(): void {
        $this->requireHr();
        $jobId = (int) ($_GET['id'] ?? 0);
        if ($jobId < 1 || !$this->jobModel->isCreatedBy($jobId, currentUserId())) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/hr/jobs');
        }
        $job = $this->jobModel->findById($jobId);
        $applicants = $this->appModel->getByJobId($jobId);
        render_view('hr/applicants', ['job' => $job, 'applicants' => $applicants, 'pageTitle' => 'Pelamar - ' . e($job['title'])]);
    }

    public function applicationUpdateStatus(): void {
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
