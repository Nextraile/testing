<?php
require_once __DIR__ . '/../models/DestinasiModel.php';

class HomeController {
    private $model;
    
    public function __construct($db) {
        $this->model = new DestinasiModel($db);
    }
    
    public function index() {
        // Ambil destinasi rekomendasi
        $rekomendasi = $this->model->getDestinasiRekomendasi(3);
        
        // Tangani pencarian
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $keyword = trim($_GET['search']);
            if (!empty($keyword)) {
                // Redirect ke halaman list destinasi dengan hasil pencarian
                header("Location: index.php?page=list&search=" . urlencode($keyword));
                exit;
            }
        }
        
        // Tampilkan view
        require_once __DIR__ . '/../views/pages/home.php';
    }
}
?>