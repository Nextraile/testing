<?php
require_once __DIR__ . '/../../public/includes/session.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;
    
    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/UserModel.php';
        $this->model = new UserModel($db);
    }

    public function profile() {
        // Pastikan user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        
        // Ambil data user dari database
        $userId = $_SESSION['user_id'];
        $user = $this->model->getById($userId);
        
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan';
            header('Location: index.php?page=home');
            exit;
        }
        
        // Format tanggal registrasi
        $tanggalRegister = date_create($user['tanggal_register']);
        $bulan = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        
        $user['tanggal_register_formatted'] = 
            date_format($tanggalRegister, 'j') . ' ' . 
            $bulan[date_format($tanggalRegister, 'F')] . ' ' . 
            date_format($tanggalRegister, 'Y');
        
        // Tampilkan view
        require_once __DIR__ . '/../views/user/profile.php';
    }
    
    public function editProfile() {
        // Validasi login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        
        // Ambil data user
        $userId = $_SESSION['user_id'];
        $user = $this->model->getById($userId);
        
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan';
            header('Location: index.php?page=home');
            exit;
        }
        
        // Format tanggal registrasi (sama seperti di profile)
        $tanggalRegister = date_create($user['tanggal_register']);
        $bulan = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        
        $user['tanggal_register_formatted'] = 
            date_format($tanggalRegister, 'j') . ' ' . 
            $bulan[date_format($tanggalRegister, 'F')] . ' ' . 
            date_format($tanggalRegister, 'Y');
        
        // Tampilkan view edit
        require_once __DIR__ . '/../views/user/edit-profile.php';
    }
    
    public function updateProfile() {
        // Validasi login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->model->getById($userId);
        
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan';
            header('Location: index.php?page=home');
            exit;
        }
        
        // Tangkap input
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $fotoProfil = $_FILES['foto_profil'] ?? null;
        
        // Validasi input
        $errors = [];
        
        if (empty($username)) $errors[] = 'Username harus diisi';
        if (empty($email)) $errors[] = 'Email harus diisi';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
        
        if (!empty($username)){
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $errors[] = 'Username hanya boleh berisi huruf, angka, dan underscore';
            } else if (strlen($username) < 5){
                $errors[] = 'Username minimal 5 karakter';
            }
        }

        // Validasi password jika diisi
        if (!empty($password)) {
            if ($password !== $confirmPassword) {
                $errors[] = 'Password baru dan konfirmasi password tidak sama';
            } elseif (strlen($password) < 7) {
                $errors[] = 'Password minimal 7 karakter';
            }
        }
        
        // Validasi email unik
        if ($email !== $user['email']) {
            if ($this->model->emailExists($email)) {
                $errors[] = 'Email sudah digunakan oleh user lain';
            }
        }
        
        // Validasi file upload
        if ($fotoProfil && $fotoProfil['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($fotoProfil['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF';
            } elseif ($fotoProfil['size'] > 2 * 1024 * 1024) { // 2MB
                $errors[] = 'Ukuran file terlalu besar. Maksimal 2MB';
            }
        }
        
        // Jika ada error, redirect kembali ke form edit
        if (!empty($errors)) {
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = compact('username', 'email');
            header('Location: index.php?page=edit-profile');
            exit;
        }
        
        // Proses update
        $updateData = [
            'username' => $username,
            'email' => $email
        ];
        
        // Update password jika diisi
        if (!empty($password)) {
            $updateData['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Handle file upload
        $newFotoProfil = $user['foto_profil'];
        
        if ($fotoProfil && $fotoProfil['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($fotoProfil['name'], PATHINFO_EXTENSION);
            $newFilename = 'profile_' . $userId . '_' . time() . '.' . $ext;
            $uploadPath = __DIR__ . '/../../public/assets/img/profiles/' . $newFilename;
            
            if (move_uploaded_file($fotoProfil['tmp_name'], $uploadPath)) {
                // Hapus foto lama jika bukan default
                if ($user['foto_profil'] && $user['foto_profil'] !== 'default.svg') {
                    $oldFilePath = __DIR__ . '/../../public/assets/img/profiles/' . $user['foto_profil'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $newFotoProfil = $newFilename;
                $updateData['foto_profil'] = $newFotoProfil;
            }
        }
        
        // Update database
        if ($this->model->updateUser($userId, $updateData)) {
            // Update session
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['foto_profil'] = $newFotoProfil;
            
            $_SESSION['success'] = 'Profil berhasil diperbarui!';
            header('Location: index.php?page=profile');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil. Silakan coba lagi.';
            header('Location: index.php?page=edit-profile');
            exit;
        }
    }
}
?>