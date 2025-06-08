<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function refresh_user_session() {
    if (isset($_SESSION['user_id'])) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['tanggal_register'] = $user['tanggal_register'];
            $_SESSION['foto_profil'] = $user['foto_profil'];
        }
    }
}

// Fungsi untuk mendapatkan role user
function get_user_role() {
    return $_SESSION['role'] ?? 'visitor';
}

// Fungsi untuk cek apakah user adalah admin
function is_admin() {
    $role = get_user_role();
    return $role === 'admin' || $role === 'superadmin';
}

function is_superadmin() {
    $role = get_user_role();
    return $role === 'superadmin';
}

// Fungsi untuk cek apakah user sudah login
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Refresh session setiap kali file ini di-load
refresh_user_session();
?>