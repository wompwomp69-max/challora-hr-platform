<?php
/**
 * List & detail job — wajib login (selain /auth/*)
 */
class JobController {
    private Job $jobModel;
    private SavedJob $savedJobModel;

    public function __construct() {
        $this->jobModel = new Job();
        $this->savedJobModel = new SavedJob();
    }

    public function index(): void {
        requireLogin();

        $searchParams = [
            'q' => trim($_GET['q'] ?? ''),
            'location' => trim($_GET['location'] ?? ''),
            'salary' => trim($_GET['salary'] ?? ''), // legacy, jika masih dipakai
            'min_salary' => trim($_GET['min_salary'] ?? ''),
            'max_salary' => trim($_GET['max_salary'] ?? ''),
            'job_type' => trim($_GET['job_type'] ?? ''),
            'min_education' => trim($_GET['min_education'] ?? ''),
            'experience_level' => trim($_GET['experience_level'] ?? ''),
            'updated' => trim($_GET['updated'] ?? ''),
        ];
        $jobView = trim($_GET['job_view'] ?? 'all');
        if (!in_array($jobView, ['all', 'saved', 'applied'], true)) {
            $jobView = 'all';
        }
        $perPage = (int) ($_GET['per_page'] ?? 20);
        $perPage = in_array($perPage, [20, 50, 100], true) ? $perPage : 20;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $userId = currentUserId();
        if ($jobView === 'all') {
            $totalJobs = $this->jobModel->countSearchAndFilter($searchParams);
            $totalPages = $totalJobs > 0 ? (int) ceil($totalJobs / $perPage) : 1;
            $page = min($page, $totalPages);
            $jobs = $this->jobModel->searchAndFilterPaginated($searchParams, $page, $perPage);
        } else {
            $totalJobs = $this->jobModel->countSearchAndFilterByUserView($searchParams, $userId, $jobView);
            $totalPages = $totalJobs > 0 ? (int) ceil($totalJobs / $perPage) : 1;
            $page = min($page, $totalPages);
            $jobs = $this->jobModel->searchAndFilterPaginatedByUserView($searchParams, $userId, $jobView, $page, $perPage);
        }

        $appliedJobIds = [];
        $savedJobIds = [];
        if (isLoggedIn() && currentRole() === 'user') {
            $appModel = new Application();
            $savedJobIds = $this->savedJobModel->getSavedJobIds($userId);
            foreach ($jobs as $j) {
                if ($appModel->hasApplied($userId, (int)$j['id'])) {
                    $appliedJobIds[] = (int)$j['id'];
                }
            }
        }

        render_view('user/jobs/index', [
            'jobs' => $jobs,
            'appliedJobIds' => $appliedJobIds,
            'savedJobIds' => $savedJobIds,
            'searchParams' => $searchParams,
            'jobView' => $jobView,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'totalJobs' => $totalJobs,
            'pageTitle' => 'Lowongan',
        ]);
    }

    public function show(): void {
        requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1) {
            redirect('/jobs');
        }
        $job = $this->jobModel->findById($id);
        if (!$job) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/jobs');
        }
        $canApply = false;
        $alreadyApplied = false;
        $isSaved = false;
        $hasRequiredDocs = true;
        $missingDocs = [];
        $relatedJobs = $this->jobModel->findRelatedJobs($job, 6);
        $relatedAppliedJobIds = [];
        $relatedSavedJobIds = [];
        if (isLoggedIn() && currentRole() === 'user') {
            $appModel = new Application();
            $alreadyApplied = $appModel->hasApplied(currentUserId(), $id);
            $canApply = !$alreadyApplied;
            $isSaved = $this->savedJobModel->isSaved(currentUserId(), $id);
            $savedJobIds = $this->savedJobModel->getSavedJobIds(currentUserId());
            foreach ($relatedJobs as $rj) {
                $rid = (int) ($rj['id'] ?? 0);
                if ($rid < 1) continue;
                if ($appModel->hasApplied(currentUserId(), $rid)) {
                    $relatedAppliedJobIds[] = $rid;
                }
                if (in_array($rid, $savedJobIds, true)) {
                    $relatedSavedJobIds[] = $rid;
                }
            }
            $user = (new User())->findById(currentUserId());
            if ($user) {
                if (empty($user['cv_path'])) $missingDocs[] = 'CV';
                if (empty($user['diploma_path'])) $missingDocs[] = 'ijazah';
                if (empty($user['photo_path'])) $missingDocs[] = 'pas foto';
            } else {
                $missingDocs = ['CV', 'ijazah', 'pas foto'];
            }
            $hasRequiredDocs = empty($missingDocs);
        }
        render_view('user/jobs/show', [
            'job' => $job,
            'canApply' => $canApply,
            'alreadyApplied' => $alreadyApplied,
            'isSaved' => $isSaved,
            'hasRequiredDocs' => $hasRequiredDocs,
            'missingDocs' => $missingDocs,
            'relatedJobs' => $relatedJobs,
            'relatedAppliedJobIds' => $relatedAppliedJobIds,
            'relatedSavedJobIds' => $relatedSavedJobIds,
            'pageTitle' => e($job['title']),
        ]);
    }

    public function saveJob(): void {
        requireLogin();
        requireRole('user');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/jobs');
        }
        $jobId = (int) ($_POST['job_id'] ?? 0);
        if ($jobId < 1) {
            $_SESSION['flash_error'] = 'Job tidak valid.';
            redirect('/jobs');
        }
        $job = $this->jobModel->findById($jobId);
        if (!$job) {
            $_SESSION['flash_error'] = 'Lowongan tidak ditemukan.';
            redirect('/jobs');
        }
        $this->savedJobModel->save(currentUserId(), $jobId);
        $redirect = !empty(trim($_POST['redirect'] ?? '')) ? trim($_POST['redirect']) : '/jobs/show?id=' . $jobId;
        $_SESSION['flash_toast'] = [
            'message' => 'Lowongan berhasil disimpan.',
            'undo' => [
                'label' => 'Undo',
                'url' => BASE_URL . '/index.php?url=jobs/unsave',
                'method' => 'POST',
                'fields' => ['job_id' => $jobId, 'redirect' => $redirect],
            ],
        ];
        redirect($redirect);
    }

    public function unsaveJob(): void {
        requireLogin();
        requireRole('user');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/jobs');
        }
        $jobId = (int) ($_POST['job_id'] ?? 0);
        if ($jobId < 1) {
            redirect('/jobs');
        }
        $this->savedJobModel->unsave(currentUserId(), $jobId);
        $redirect = !empty(trim($_POST['redirect'] ?? '')) ? trim($_POST['redirect']) : '/jobs';
        $_SESSION['flash_toast'] = [
            'message' => 'Lowongan dihapus dari daftar simpan.',
            'undo' => [
                'label' => 'Undo',
                'url' => BASE_URL . '/index.php?url=jobs/save',
                'method' => 'POST',
                'fields' => ['job_id' => $jobId, 'redirect' => $redirect],
            ],
        ];
        redirect($redirect);
    }

    public function savedIndex(): void {
        requireLogin();
        requireRole('user');

        $jobs = $this->savedJobModel->getByUserId(currentUserId());

        $appModel = new Application();
        $appliedJobIds = [];
        foreach ($jobs as $j) {
            if ($appModel->hasApplied(currentUserId(), (int)$j['id'])) {
                $appliedJobIds[] = (int)$j['id'];
            }
        }
        $savedJobIds = $this->savedJobModel->getSavedJobIds(currentUserId());

        render_view('user/jobs/saved', [
            'jobs' => $jobs,
            'appliedJobIds' => $appliedJobIds,
            'savedJobIds' => $savedJobIds,
            'pageTitle' => 'Lowongan Tersimpan',
        ]);
    }
}
