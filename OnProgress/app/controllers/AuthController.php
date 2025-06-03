<?php
require_once __DIR__ . '/../../public/includes/session.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $model;
    
    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/UserModel.php';
        $this->model = new UserModel($db);
    }

    public function login() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function doLogin() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
   
        // Cari user di database
        $user = $this->model->getByEmailAndUsername($email, $username);
        
        // Verifikasi password
        if ($user && password_verify($password, $user['password_hash'])) {
            $this->setUserSession($user);
            header('Location: index.php?page=home');
            exit;
        } else {
            $error = $this->validateLoginInput($username, $email, $password);
            $this->redirectWithError('login', $error);
        }
    }

    public function doRegister() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        // Validasi input
        $errors = $this->validateRegisterInput($username, $email, $password, $confirm);
        
        if (!empty($errors)) {
            $this->redirectWithErrors('register', $errors);
        }

        // Buat user baru
        $userId = $this->model->createUser($username, $email, $password);
        
        if ($userId) {
            $user = $this->model->getById($userId);
            $this->setUserSession($user);
            header('Location: index.php?page=home');
            exit;
        } else {
            $this->redirectWithErrors('register', 'Gagal membuat akun. Silakan coba lagi.');
        }
    }
    
    private function validateRegisterInput($username, $email, $password, $confirm) {
        $errors = [];
        
        if (empty($username)) $errors[] = 'Username harus diisi';
        if (empty($email)) $errors[] = 'Email harus diisi';
        if (empty($password)) $errors[] = 'Password harus diisi';
        if ($this->model->usernameExists($username)) $errors[] ='Username sudah terdaftar';
        if ($this->model->emailExists($email)) $errors[] = 'Email sudah terdaftar';
        if ($password !== $confirm) $errors[] = 'Password tidak sama';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors[] = 'Username hanya boleh berisi huruf, angka, dan underscore';
        if (strlen($password) < 7) $errors[] = 'Password minimal 7 karakter';
        if (strlen($username) < 5) $errors[] = 'Username minimal 5 karakter';
        
        return $errors;
    }
    
    private function validateLoginInput($username, $email, $password) {
            $error = [];
            
            if (empty($username)) $error[] = 'Username harus diisi';
            if (empty($email)) $error[] = 'Email harus diisi';
            if (empty($password)) $error[] = 'Password harus diisi';

            if (empty($error)) {
            // Cek apakah kombinasi username dan email valid
            if (!$this->model->isUsernameEmailMatch($username, $email)) {
                $error[] = 'Username atau email salah';
            } else {
                // Jika kombinasi username-email cocok, cek password
                $user = $this->model->getByUsernameEmail($username, $email);
                if (!$user || !password_verify($password, $user['password'])) {
                    $error[] = 'Password salah';
                }
            }

            if (empty($username)) $error[] = 'Username harus diisi';
            if (empty($email)) $error[] = 'Email harus diisi';
            if (empty($password)) $error[] = 'Password harus diisi';
            
            return $error;
        }
    }

    private function setUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['foto_profil'] = $user['foto_profil'];
    }
    
    private function redirectWithError($page, $error) {
        $_SESSION['error'] = $error;
        header("Location: index.php?page=$page");
        exit;
    }
    
    private function redirectWithErrors($page, $errors) {
        $_SESSION['errors'] = $errors;
        header("Location: index.php?page=$page");
        exit;
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }
}
?>