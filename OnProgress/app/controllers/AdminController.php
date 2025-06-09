<?php
require_once __DIR__ . '/../models/DestinasiModel.php';

class AdminController {
    private $model;
    
    public function __construct($db) {
        $this->model = new DestinasiModel($db);
    }
    
    public function destinasi() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // --- AUTH & AUTHZ ---
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        if (!in_array($_SESSION['role'], ['admin', 'superadmin'], true)) {
            header('Location: index.php?page=home');
            exit;
        }

        // Konfigurasi pagination
        $perPage = 5;
        // Gunakan 'p' untuk pagination, misal ?route=destinasi&p=2
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($currentPage - 1) * $perPage;

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $destinasi = $this->model->getAllDestinasi($perPage, $offset, $search);

        $totalDestinasi = $this->model->countAllDestinasi($search);
        $totalPages = ceil($totalDestinasi / $perPage);
        
        // Tangani aksi hapus
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            $id = (int)$_POST['delete_id'];
            if ($this->model->deleteDestinasi($id)) {
                $_SESSION['success_message'] = 'Destinasi berhasil dihapus.';
            } else {
                $_SESSION['error_message'] = 'Gagal menghapus destinasi.';
            }
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/admin/destinasi.php';
    }
}