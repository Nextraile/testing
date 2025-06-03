<?php
// File: public/index.php

// 1. Load konfigurasi database
require_once __DIR__ . '/../app/config/database.php';

// 2. Tentukan halaman yang diminta user
$page = $_GET['page'] ?? 'home';  // Jika tidak ada parameter, default ke home

// 3. Routing: Tentukan controller yang akan menangani request
switch($page) {
    case 'switch-role':
        require_once __DIR__ . '/../app/controllers/RoleSwitcherController.php';
        $controller = new RoleSwitcherController();
        $controller->switch();
        break;
        
    case 'home':
        require_once __DIR__ . '/../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'detail':
        require_once __DIR__ . '/../app/controllers/DestinasiController.php';
        $controller = new DestinasiController();
        
        // Ambil ID dari URL dan pastikan berupa angka
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->show($id);
        break;
     case 'list':
        require_once __DIR__ . '/../app/controllers/DestinasiController.php';
        $controller = new DestinasiController();
        $controller->list();
        break;
        
    case 'admin':
        // Cek apakah user sudah login dan role admin
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superadmin')) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'profile':
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->profile();
        break;    
    // Tambahkan case lain untuk halaman lainnya...
    
    default:
        http_response_code(404);
        echo "Halaman tidak ditemukan";
        exit;
}
?>