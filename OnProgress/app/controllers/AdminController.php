<?php
require_once __DIR__ . '/../models/Model.php';

class AdminController {
    private $model;

    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/AdminModel.php';
        $this->model = new AdminModel($db);
    }

    public function index() {
        // Ambil data yang diperlukan untuk halaman admin
        $data = $this->model->getAdminData();
        
        // Tampilkan view admin
        require_once __DIR__ . '/../views/admin/index.php';
    }

    public function manageUsers() {
        // Ambil daftar pengguna
        $users = $this->model->getAllUsers();
        
        // Tampilkan view untuk mengelola pengguna
        require_once __DIR__ . '/../views/admin/manage_users.php';
    }

    public function manageDestinations() {
        // Ambil daftar destinasi
        $destinations = $this->model->getAllDestinations();
        
        // Tampilkan view untuk mengelola destinasi
        require_once __DIR__ . '/../views/admin/manage_destinations.php';
    }

    public function addDestination() {
        // Proses penambahan destinasi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            
            // Validasi input
            if (empty($name) || empty($description) || empty($location)) {
                $error = 'All fields are required.';
                require_once __DIR__ . '/../views/admin/add_destination.php';
                return;
            }
            
            // Tambahkan destinasi
            $this->model->addDestination($name, $description, $location);
            header('Location: index.php?page=admin-manage-destinations');
            exit;
        }
        
        // Tampilkan form penambahan destinasi
        require_once __DIR__ . '/../views/admin/add_destination.php';
    }
    
    public function editDestination($id) {
        // Proses pengeditan destinasi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            
            // Validasi input
            if (empty($name) || empty($description) || empty($location)) {
                $error = 'All fields are required.';
                require_once __DIR__ . '/../views/admin/edit_destination.php';
                return;
            }
            
            // Update destinasi
            $this->model->updateDestination($id, $name, $description, $location);
            header('Location: index.php?page=admin-manage-destinations');
            exit;
        }
        
        // Ambil data destinasi untuk diedit
        $destination = $this->model->getDestinationById($id);
        
        // Tampilkan form pengeditan destinasi
        require_once __DIR__ . '/../views/admin/edit_destination.php';
    }

    public function deleteDestination($id) {
        // Hapus destinasi
        $this->model->deleteDestination($id);
        header('Location: index.php?page=admin-manage-destinations');
        exit;
    }
}
?>