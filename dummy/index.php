switch($page) {
    // ... halaman sebelumnya ...
    
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
    
    // ... tambahkan lainnya sesuai kebutuhan ...
}