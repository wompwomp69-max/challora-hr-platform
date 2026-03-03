<?php
/**
 * Candidate: profile edit, my applications
 */
class UserController {
    private User $userModel;
    private Application $appModel;

    public function __construct() {
        $this->userModel = new User();
        $this->appModel = new Application();
    }

    public function profile(): void {
        requireRole('user');
        $user = $this->userModel->findById(currentUserId());
        if (!$user) {
            redirect('/auth/logout');
        }
        unset($user['password']);
        $applications = $this->appModel->getByUserId(currentUserId());
        render_view('user/settings/index', ['user' => $user, 'applications' => $applications, 'pageTitle' => 'Profil']);
    }

    public function profileEdit(): void {
        requireRole('user');
        $user = $this->userModel->findById(currentUserId());
        if (!$user) redirect('/auth/logout');
        unset($user['password']);
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            if ($name === '') {
                $error = 'Nama wajib diisi.';
            } else {
                $this->userModel->update(currentUserId(), ['name' => $name, 'phone' => $phone, 'address' => $address]);
                $_SESSION['flash'] = 'Profil berhasil diperbarui.';
                $_SESSION['user_name'] = $name;
                redirect('/user/settings');
            }
        }
        render_view('user/settings/edit', ['user' => $user, 'error' => $error, 'pageTitle' => 'Edit Profil']);
    }
}
