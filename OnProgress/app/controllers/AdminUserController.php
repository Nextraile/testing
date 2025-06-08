<?php
require_once __DIR__ . '/../models/UserModel.php';

class AdminUserController {
    private $model;
    
    public function __construct(PDO $db) {
        $this->model = new UserModel($db);
    }
    
    public function user() {
        // Mulai session (jika belum)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // --- AUTH & AUTHZ ---
        if (empty($_SESSION['user_id'])) {
            header('Location: /public/index.php?page=login');
            exit;
        }
        if (!in_array($_SESSION['role'], ['admin', 'superadmin'], true)) {
            header('Location: /public/index.php?page=home');
            exit;
        }
        
        // --- PAGINATION & SEARCH ---
        $perPage     = 5;
        // Baca nomor halaman dari `p`, bukan `page`
        $currentPage = isset($_GET['p']) && is_numeric($_GET['p'])
                       ? max(1, (int)$_GET['p'])
                       : 1;
        $offset      = ($currentPage - 1) * $perPage;
        $search      = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // --- DATA RETRIEVAL ---
        $users      = $this->model->getAllUsers($perPage, $offset, $search);
        $totalUsers = $this->model->countAllUsers($search);
        $totalPages = (int) ceil($totalUsers / $perPage);
        
        // --- HANDLE ROLE UPDATE ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
            $userId  = (int) ($_POST['user_id'] ?? 0);
            $newRole = trim($_POST['new_role'] ?? '');
            
            if ($userId > 0 && in_array($newRole, ['user','admin','superadmin'], true)
                && $this->model->updateUserRole($userId, $newRole)
            ) {
                $_SESSION['success_message'] = 'Role user berhasil diubah.';
            } else {
                $_SESSION['error_message'] = 'Gagal mengubah role user.';
            }
            
            // Redirect ulang, jaga routing dan pagination/search
            $qs = http_build_query([
                'page'   => 'akses',
                'p'      => $currentPage,
                'search' => $search,
            ]);
            header("Location: ?{$qs}");
            exit;
        }
        
        // --- RENDER VIEW ---
        // Pastikan di view Anda:
        //  - Form pencarian menyertakan <input type="hidden" name="page" value="admin_user">
        //  - Link pagination menggunakan ?page=admin_user&p=...
        require_once __DIR__ . '/../views/admin/user.php';
    }
}
