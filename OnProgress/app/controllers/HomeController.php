<?php
// File: app/controllers/HomeController.php

// Panggil model yang diperlukan
require_once __DIR__ . '/../models/DestinasiModel.php';

class HomeController {
    public function index() {
        // Dapatkan koneksi database dari global scope
        // global $db;
        
        // // Buat instance model
        // $model = new DestinasiModel($db);
        
        // // Ambil data destinasi dari model
        // $destinasiList = $model->getAll();
        
        // Tampilkan view
        require_once __DIR__ . '/../views/pages/home.php';
    }
}
?>