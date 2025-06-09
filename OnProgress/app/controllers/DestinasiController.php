<?php

require_once __DIR__ . '/../models/DestinasiModel.php';

class DestinasiController {
    private $model;
    
    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/DestinasiModel.php';
        $this->model = new DestinasiModel($db);
    }

    public function list() {
        // Konfigurasi pagination
        $perPage = 12;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($currentPage - 1) * $perPage;
        
        // Ambil parameter pencarian
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Ambil parameter filter kategori
        $kategoriIds = [];
        if (isset($_GET['kategori']) && is_array($_GET['kategori'])) {
            $kategoriIds = array_map('intval', $_GET['kategori']);
        }
        
        // Ambil data destinasi
        $destinasiList = $this->model->getDestinasi($keyword, $kategoriIds, $perPage, $offset);
        
        // Hitung total data
        $totalDestinasi = $this->model->countDestinasi($keyword, $kategoriIds);
        $totalPages = ceil($totalDestinasi / $perPage);
        
        // Ambil semua kategori
        $kategoriList = $this->model->getAllKategori();
        
        // Tampilkan view
        require_once __DIR__ . '/../views/pages/list.php';
    }

    public function detail($id) {
        require_once __DIR__ . '/../models/DestinasiModel.php';
        require_once __DIR__ . '/../models/GaleriModel.php';
        require_once __DIR__ . '/../models/UlasanModel.php';
        require_once __DIR__ . '/../models/WaktuOperasionalModel.php';
        require_once __DIR__ . '/../models/TiketModel.php';
        global $db;
    $destinasiModel = new DestinasiModel($db);
    $galeriModel = new GaleriModel($db);
    $ulasanModel = new UlasanModel($db);
    $waktuOperasionalModel = new WaktuOperasionalModel($db);
    $tiketMasukModel = new TiketModel($db);

        // Ambil data destinasi
        $destinasi = $destinasiModel->getDestinasiById($id);
        
        if (!$destinasi) {
            die('Destinasi tidak ditemukan');
        }

    $galeri = $galeriModel->getGambarByDestinasiId($id);
    $ulasan = $ulasanModel->getUlasanByDestinasiId($id);
    $operasional = $waktuOperasionalModel->getOperasionalSummary($id);
    $tiketMasuk = $tiketMasukModel->getTiketByDestinasiId($id);
        
        // Proses form ulasan jika ada submit
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi
            $rating = $_POST['rating'] ?? '';
            $isi_ulasan = trim($_POST['isi_ulasan'] ?? '');
            
            if (empty($rating)) {
                $errors['rating'] = 'Rating harus diisi';
            } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
                $errors['rating'] = 'Rating harus antara 1-5';
            }
            
            if (empty($isi_ulasan)) {
                $errors['isi_ulasan'] = 'Isi ulasan tidak boleh kosong';
            } elseif (strlen($isi_ulasan) < 10) {
                $errors['isi_ulasan'] = 'Ulasan terlalu pendek';
            }
            
            // Jika tidak ada error, simpan ulasan
            if (empty($errors)) {
                session_start();
                $user_id = $_SESSION['user_id'] ?? null;
                
                if ($user_id) {
$data = [
            'user_id'      => $user_id,
            'destinasi_id' => (int)$id,
            'rating'       => (float)$rating,
            'isi_ulasan'   => $isi_ulasan,
        'errors' => $errors,
        'success' => $success
    ];
                    
                    if ($ulasanModel->tambahUlasan($data)) {
                        $success = true;
                        // Refresh data ulasan
                        $ulasan = $ulasanModel->getUlasanByDestinasiId($id);
                    } else {
                        $errors['general'] = 'Gagal menyimpan ulasan';
                    }
                } else {
                    $errors['general'] = 'Anda harus login untuk menambahkan ulasan';
                }
            }
        }
        
        // Kirim data ke view
        $data = [
            'destinasi' => $destinasi,
            'galeri' => $galeri,
            'ulasan' => $ulasan,
            'errors' => $errors,
            'success' => $success
        ];
        
        require_once __DIR__ . '/../views/pages/detail.php';
    }
}

?>