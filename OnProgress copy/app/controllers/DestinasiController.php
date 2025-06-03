<?php
// File: app/controllers/DestinasiController.php

// Panggil model
require_once __DIR__ . '/../models/DestinasiModel.php';

class DestinasiController {
    public function show($id) {
        // Validasi ID
        if ($id <= 0) {
            http_response_code(404);
            echo "ID destinasi tidak valid";
            exit;
        }
        
        // Dapatkan koneksi database
        global $db;
        
        // Buat instance model
        $model = new DestinasiModel($db);
        
        // Ambil data destinasi
        $destinasi = $model->getById($id);
        
        // Cek apakah destinasi ditemukan
        if (!$destinasi) {
            http_response_code(404);
            echo "Destinasi tidak ditemukan";
            exit;
        }
        
        // Tampilkan view detail
        require_once __DIR__ . '/../views/detail.php';
    }

        public function list() {
        global $db;
        
        // Pagination settings
        $itemsPerPage = 9;
        $currentPage = $_GET['p'] ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        // Ambil keyword pencarian jika ada
        $searchKeyword = $_GET['search'] ?? null;
        
        // Buat instance model
        $model = new DestinasiModel($db);
        
        if ($searchKeyword) {
            // Handle pencarian
            $destinasiList = $model->search($searchKeyword, $itemsPerPage, $offset);
            $totalDestinasi = $model->getSearchTotal($searchKeyword);
        } else {
            // Ambil semua destinasi
            $destinasiList = $model->getAllPaginated($itemsPerPage, $offset);
            $totalDestinasi = $model->getTotal();
        }
        
        $totalPages = ceil($totalDestinasi / $itemsPerPage);
        
        // Ambil gambar utama untuk setiap destinasi
        foreach ($destinasiList as &$destinasi) {
            $destinasi['gambar_utama'] = $model->getGambarUtama($destinasi['id']);
        }
        unset($destinasi); // Hapus reference
        
        // Load view
        require_once __DIR__ . '/../views/pages/list.php';
    }
}
?>