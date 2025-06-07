<?php
// File: public/index.php

// 1. Load konfigurasi database
require_once __DIR__ . '/../app/config/database.php';

// 2. Tentukan halaman yang diminta user
$page = $_GET['page'] ?? 'home';  // Jika tidak ada parameter, default ke home

// 3. Routing: Tentukan controller yang akan menangani request
switch($page) {
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
        
    case 'do-login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->doLogin();
        break;
        
    case 'register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'do-register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->doRegister();
        break;

    case 'profile':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->profile();
        break;

    case 'edit-profile':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->editProfile();
        break;
        
    case 'update-profile':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->updateProfile();
        break;

    case 'create':
        require_once __DIR__ . '/../app/controllers/AdminDestinasiController.php';
        $controller = new AdminDestinasiController($db);
        $controller->create();
        break;

    case 'destinasi':
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController($db);
        $controller->destinasi();
        break;

    case 'akses':
        require_once __DIR__ . '/../app/controllers/AdminUserController.php';
        $controller = new AdminUserController($db);
        $controller->user();
        break;

    default:
        http_response_code(404);
        echo "Halaman tidak ditemukan";
        exit;
}
?>