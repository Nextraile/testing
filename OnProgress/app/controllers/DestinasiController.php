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
}
?>